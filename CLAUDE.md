# CLAUDE.md — madhub-laravel

Learning project to understand Laravel by building a simple MADHUB-styled website with data coming from a database.
Context: the team wants to move away from WordPress and page builders toward custom code that can be built with AI.

---

## Working rules (how to collaborate on this project)

- Never take action, assume next steps or complete tasks unless explicitly asked. If unclear, ask "¿Qué vamos a hacer?" and wait.
- Always provide the full code of any file that changes, never partial snippets.
- All code, code comments and site content are written in English (conversation is in Spanish).
- Reproduce any string the user provides exactly as given.
- The user knows the logic (Liquid / PHP / React); he describes what he wants and Claude writes it in Blade/Laravel.
- Keep it simple: no Tailwind, no npm, no build step.

---

## Stack and environment

| Item | Choice |
|---|---|
| Framework | Laravel 12 (`laravel/framework ^12.0`) |
| PHP | 8.2.12 from XAMPP (`C:\xamppNew\php\php.exe`) — Laravel 13 needs PHP 8.3+, so we stay on 12 |
| Composer | 2.8.12 |
| Database | SQLite, single file `database/database.sqlite` (`DB_CONNECTION=sqlite`). No MySQL / XAMPP server needed |
| Sessions | Stored in the database (`SESSION_DRIVER=database`, `SESSION_LIFETIME=120`) |
| Templates | Blade (`resources/views/*.blade.php`) |
| CSS | Plain CSS in `public/css/style.css` (CSS variables in `:root`). Tailwind, Vite, SCSS and `package.json` were removed on purpose |
| JS | None yet. If needed: `public/js/main.js` loaded with `<script src="{{ asset('js/main.js') }}" defer></script>`, libraries via CDN (e.g. Swiper) |
| Fonts | Google Fonts: Montserrat (headings) + Poppins (body, buttons) |
| Local server | `php artisan serve` → http://127.0.0.1:8000 (Apache from XAMPP is not used) |
| Project path | `C:\Users\ramdp\OneDrive\Escritorio\Big Data\HTML\Laravel Projects\madhub-laravel` (inside OneDrive: `vendor/` sync can be slow; use a non-OneDrive folder for real projects) |

The user dislikes XAMPP; only its `php.exe` is used. Laravel Herd is the alternative if PHP needs upgrading.

---

## Visual style (reference: MADHUB Next.js site at http://localhost:3000)

- Black background, primary red `#ff4f41` (`--color-primary`), dark surfaces `#0d0d0d` / `#141414`.
- Headings: Montserrat, uppercase, heavy weights, one word highlighted in red via `<span>`.
- Buttons: Poppins; `.btn--primary` (red), `.btn--outline`, `.btn--ghost`, `.btn--dark`, `.btn--lg` (pill), `.btn--block`.
- Cards with dark gradient and reddish border. BEM class naming.
- Hero: "WE ENCOURAGE" in red + "CRAZY" white over a skewed red block, red radial glow + subtle grid background (CSS only).
- No animated sections (logo marquee etc. intentionally skipped). Only hover transitions.

---

## Project structure (custom parts)

```
routes/web.php                          Routes (home, auth, account)
bootstrap/app.php                       Middleware redirects (guests → /login, users → /account)

app/Http/Controllers/HomeController.php        Loads services + team members for the homepage
app/Http/Controllers/Auth/RegisterController.php  Register (validate, create user, log in)
app/Http/Controllers/Auth/LoginController.php     Login, logout

app/Models/Service.php                  scopeVisible() = active + ordered by sort_order
app/Models/TeamMember.php               scopeVisible() + initials accessor (fallback avatar)
app/Models/User.php                     Default Laravel user (password cast 'hashed')

database/migrations/2026_11_25_000001_create_services_table.php
database/migrations/2026_11_25_000002_create_team_members_table.php
database/seeders/ServiceSeeder.php      6 sample services
database/seeders/TeamMemberSeeder.php   8 sample members (placeholder names/roles)
database/seeders/DatabaseSeeder.php     Test user + calls both seeders

resources/views/layouts/app.blade.php   Base layout: head, fonts, CSS, header, flash message, @yield('content'), footer
resources/views/partials/header.blade.php   Logo, nav, @guest Login/Register, @auth name/Logout
resources/views/partials/footer.blade.php
resources/views/home.blade.php          Includes sections in order
resources/views/sections/hero.blade.php
resources/views/sections/services.blade.php   @forelse ($services as $service) — no images in cards (removed on request)
resources/views/sections/team.blade.php       @forelse ($teamMembers as $member) — circular photos
resources/views/sections/contact.blade.php    Static placeholder form (not wired yet)
resources/views/sections/newsletter.blade.php Static placeholder form (not wired yet)
resources/views/auth/register.blade.php
resources/views/auth/login.blade.php
resources/views/account.blade.php       Private page (auth only)

public/css/style.css                    All styles
public/images/                          Assets from the MADHUB site (hashed filenames, e.g. logo = 8eeb8.png)
public/adminer.php + tools/adminer/     Local DB browser (gitignored, never deploy)
```

---

## Database tables

| Table | Columns / notes |
|---|---|
| `services` | id, title, description, image (path relative to `public/`, currently unused in the view), link, sort_order, is_active, timestamps |
| `team_members` | id, name, role, photo (path relative to `public/`), sort_order, is_active, timestamps |
| `users` | Laravel default. Passwords stored as bcrypt hashes. Test user: `test@example.com` / `password` |
| `sessions` | Active login sessions |
| Others (Laravel defaults) | `migrations`, `password_reset_tokens`, `cache`, `cache_locks`, `jobs`, `job_batches`, `failed_jobs` |

Images are stored as paths (e.g. `images/842b4.png`) and rendered with `asset()`.

---

## How data reaches the page (the Laravel flow)

1. **Migration** creates the table structure (no data).
2. **Seeder** inserts rows (sample data).
3. **Model** represents the table; Eloquent translates `Service::visible()->get()` to
   `SELECT * FROM services WHERE is_active = 1 ORDER BY sort_order`.
4. **Controller** (`HomeController@index`) runs the query and passes `$services` / `$teamMembers` to the view.
5. **Route** `/` → `HomeController@index`.
6. **Blade view** loops with `@forelse ... @empty ... @endforelse` (`$loop->iteration` ≈ Liquid `forloop.index`).

Simpler alternative (valid for tiny pages): query directly inside a route closure, skipping controller and scope.
`php artisan make:model Name -msc` generates model + migration + seeder + controller in one go.

---

## Authentication (built by hand, no starter kit)

- Routes: `/register`, `/login` (middleware `guest`), `/account`, `POST /logout` (middleware `auth`).
- Login is rate-limited: `throttle:5,1` (5 attempts per minute).
- `$request->validate()` returns to the form with `@error` messages and `old()` input on failure.
- `@csrf` required in every POST form.
- `Auth::login()`, `Auth::attempt()`, session `regenerate()` on login, `invalidate()` + `regenerateToken()` on logout.
- Flash messages via `->with('status', '...')`, shown in the layout.
- Not built yet: password reset, email verification.

---

## Assets

- Static assets go in `public/` (`public/images`, `public/js`, `public/fonts`) and are referenced with `{{ asset('images/file.png') }}`.
- User-uploaded files (future) go in `storage/app/public/` + `php artisan storage:link`.

---

## Useful commands

```
php artisan serve                     # Run the site at http://127.0.0.1:8000
php artisan migrate                   # Run new migrations only
php artisan migrate --seed            # Migrate + seed
php artisan migrate:fresh --seed      # Drop everything, recreate and seed (destroys data)
php artisan migrate:rollback          # Undo the last batch of migrations
php artisan make:migration add_x_to_y_table --table=y   # New migration to alter a table
php artisan db:show                   # List tables
php artisan db:table services         # Show a table's columns
php artisan tinker                    # Interactive PHP console, e.g. App\Models\User::all();
```

Visual DB browser: http://127.0.0.1:8000/adminer.php → click **Login** with empty fields (localhost only).
Desktop alternatives: DB Browser for SQLite, TablePlus, VS Code "SQLite Viewer".

### Adding a column (correct way)

1. `php artisan make:migration add_subtitle_to_services_table --table=services`
2. In `up()`: `$table->string('subtitle')->nullable()->after('title');` — in `down()`: `$table->dropColumn('subtitle');`
3. `php artisan migrate`
4. Add the field to the model's `$fillable` and use it in the view.

Editing columns directly in Adminer works for quick tests but is lost on `migrate:fresh` and not shared with the team.

---

## Pending / next steps (only when asked)

- Contact form: save to a `contact_messages` table (+ optional email to the log mailer).
- Newsletter: save to a `subscribers` table with unique email validation.
- SEO: per-page title / meta description / Open Graph, canonical, JSON-LD, sitemap.
- Optional admin panel: Filament at `/admin`.

---

## Key takeaways from the discussion

### Blade
Blade is Laravel's templating language, almost 1:1 with Liquid:
`{{ $x }}` ↔ `{{ x }}`, `@foreach` ↔ `{% for %}`, `@if` ↔ `{% if %}`, `@include` ↔ `{% render %}`, `@extends` ↔ `layout`. `{{ }}` escapes output automatically.

### Composer vs npm
Composer = PHP packages (`vendor/`). npm = frontend tooling (Vite, Sass) only needed to compile SCSS/JS. Plain CSS removes the need for npm entirely.

### SSR
Laravel renders full HTML on the server (good for SEO). This is not unique to Laravel: WordPress, Shopify and Next.js (Server Components, SSR/SSG/ISR + Metadata API) do it too. The SEO advantage only applies against a client-side SPA (plain React/Vite).

### Laravel vs Next.js + MongoDB

| Criteria | Laravel + SQL | Next.js + MongoDB |
|---|---|---|
| Language | PHP + Blade | JavaScript/TypeScript end to end |
| Learning curve | PHP, Blade, Eloquent to learn | Stack already known (React, Next, Atlas) |
| SSR / SEO | Yes | Yes, plus SSG and ISR |
| SEO metadata | Manual in layout | Built-in Metadata API, sitemap.ts, robots.ts |
| Interactivity / animations | Separate JS (or Livewire/Alpine) | Native React, Framer Motion, GSAP |
| Database | SQL; MongoDB via extra package | Native MongoDB |
| Auth, mail, queues, validation | Built in | Separate libraries (Auth.js, Resend, Zod) |
| Client admin panel | Filament | Payload CMS (inside Next, MongoDB) |
| Hosting | Cheap PHP hosting / VPS | Vercel + MongoDB Atlas (free tiers) |
| Best for | Backend-heavy systems (users, roles, payments, jobs) | Websites/landings with polished UI and dynamic content |

Conclusion: Laravel shines for data-heavy systems with business logic; for nice-looking marketing sites and landing pages, Next.js (+ a headless CMS) is a better fit. The user's preference for MADHUB is **Next.js + MongoDB**. Hybrid option: Laravel as API/backend + Next as frontend.
