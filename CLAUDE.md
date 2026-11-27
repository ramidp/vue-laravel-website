# CLAUDE.md — madhub-laravel

Practice project for the team's new stack: **Laravel + Inertia + Vue + SSR + Filament**, replacing WordPress and page builders with custom code built with AI.
The generic, reusable process lives in the `laravel-vue-site-builder` skill and the "Laravel + Inertia + Vue + Filament Stack Guide" doc. This file describes **this** project.

---

## Working rules

- Never take action, assume next steps or complete tasks unless explicitly asked. If unclear, ask "¿Qué vamos a hacer?" and wait.
- Always provide the full code of any file that changes, never partial snippets.
- All code, code comments and site content are written in English (conversation is in Spanish).
- Reproduce any string the user provides exactly as given.
- The user knows the logic (Liquid / PHP / React / Vue); he describes what he wants and Claude writes it.
- No Tailwind in the public site: plain CSS files in `public/css/`.
- The user runs PHP, Composer and npm on his Windows machine; Claude gives exact commands when it cannot run them.

---

## Stack and environment

| Item | Choice |
|---|---|
| Backend | Laravel 12 (`laravel/framework ^12.0`) |
| PHP | 8.2.12 from XAMPP (`C:\xamppNew\php\php.exe`). Laravel 13 needs 8.3, so the project stays on 12 |
| Database | SQLite, file `database/database.sqlite` (`DB_CONNECTION=sqlite`) |
| Sessions | Database (`SESSION_DRIVER=database`) |
| Bridge | Inertia.js v3 (`inertiajs/inertia-laravel ^3.8`, `@inertiajs/vue3 ^3`, `@inertiajs/vite ^3`) |
| Frontend | Vue 3, compiled by Vite 8 (Node 20.19+ required) |
| SSR | Inertia SSR through the `@inertiajs/vite` plugin (automatic in dev; `php artisan inertia:start-ssr` after a build) |
| Admin panel | Filament (`filament/filament ^4.0` in composer.json) — **being installed**, panel not set up yet |
| CSS | Plain CSS: `public/css/style.css` (global), `home.css`, `contact.css` (page styles) |
| Fonts | Google Fonts: Montserrat, Poppins, Urbanist |
| Dev DB browser | Adminer at `/adminer.php` (local only, gitignored) |

Only XAMPP's `php.exe` is used (no Apache, no MySQL). If a terminal reports "requires a PHP version >= 8.2.0", it is running another PHP (check `where php`); fix the Windows Path or call `C:\xamppNew\php\php.exe` directly. Filament needs the `intl` extension enabled in that PHP's `php.ini`.

The project folder is inside OneDrive: `vendor/` and `node_modules/` sync slowly. Use a non-synced folder for real projects.

---

## How data reaches a page

1. **Migration** creates the table (structure only).
2. **Seeder** inserts sample rows.
3. **Model** represents the table; `scopeVisible()` = active rows ordered by `sort_order`.
4. **Controller** queries the model, maps rows to plain arrays and returns `Inertia::render('PageName', props)`.
5. **Route** in `routes/web.php` points a URL to the controller.
6. **Vue page** in `resources/js/pages/` receives the props and renders them (SSR on the first visit).

Shared props on every page (`app/Http/Middleware/HandleInertiaRequests.php`): `auth.user` (id, name, email) and `flash` (`status`, `contact_success`, `newsletter_success`).

---

## Project structure

```
routes/web.php                               All URLs
bootstrap/app.php                            Inertia middleware + auth redirects (guests → /login, users → /account)
app/Providers/AppServiceProvider.php         Forces APP_URL as root URL when it is https (tunnel)
app/Http/Middleware/HandleInertiaRequests.php
app/Http/Controllers/HomeController.php      Home page: testimonials from the database
app/Http/Controllers/ContactController.php   /contact page + contact form submission
app/Http/Controllers/NewsletterController.php
app/Http/Controllers/AccountController.php
app/Http/Controllers/Auth/RegisterController.php, LoginController.php
app/Models/                                  Service, TeamMember, Testimonial, ContactMessage, Subscriber, User

resources/views/app.blade.php                The only page Blade view: <head>, fonts, CSS, @vite, @inertiaHead, @inertia
resources/js/app.js                          createInertiaApp (title template "Page | MADHUB", progress bar)
resources/js/layouts/AppLayout.vue           Header + flash message + <slot /> + footer
resources/js/pages/                          Home, Contact, Account, auth/Login, auth/Register
resources/js/components/SiteHeader.vue, SiteFooter.vue
resources/js/components/home/                LogoMarquee, WorkMarquee, ServicesTabs (home page pieces)
resources/js/components/sections/            TestimonialsSection (used on Home); the other files here are from the first version of the home
resources/js/home/data.js                    Static home content: assets, logos, stats, work rows, services tabs, journey, platforms, team

public/css/                                  style.css, home.css, contact.css
public/images/                               Static images (hashed names from the MADHUB site; image1-5.png for work items)
public/adminer.php + tools/adminer/          Local database browser (gitignored)
```

---

## Routes

| Method | URL | Controller | Access |
|---|---|---|---|
| GET | `/` | HomeController@index | Public |
| GET | `/contact` | ContactController@create | Public |
| POST | `/contact` | ContactController@store | Public, `throttle:5,1` |
| POST | `/newsletter` | NewsletterController@store | Public, `throttle:5,1` |
| GET/POST | `/register` | RegisterController | Guests only |
| GET/POST | `/login` | LoginController | Guests only, login `throttle:5,1` |
| GET | `/account` | AccountController@show | Logged in |
| POST | `/logout` | LoginController@destroy | Logged in |
| — | `/admin` | Filament | Pending setup |

---

## Database tables

| Table | Columns / notes | Used by |
|---|---|---|
| `testimonials` | name, role, quote, photo, photo_position, logo, logo_alt, logo_width, logo_height, logo_blend, logo_crop (json), sort_order, is_active | Home (TestimonialsSection) |
| `services` | title, description, image, link, sort_order, is_active | Seeded; not shown on the current home (home services come from `data.js`) |
| `team_members` | name, role, photo, sort_order, is_active (+ `initials` accessor) | Seeded; not shown on the current home |
| `contact_messages` | name, email, message | Contact form |
| `subscribers` | email (unique) | Newsletter form |
| `users` | Laravel default, bcrypt passwords. Test user `test@example.com` / `password` | Register, login, account |
| `sessions`, `cache`, `jobs`, `migrations`… | Laravel internals | — |

Images are stored as paths relative to `public/` and turned into URLs with `asset()` in the controller.

**Content split today**: testimonials come from the database; most other home content is static in `resources/js/home/data.js`. Content the client should edit moves to the database and gets a Filament screen.

---

## Filament (next step)

`filament/filament ^4.0` is in composer.json. Still to do:

1. `php artisan filament:install --panels` → `app/Providers/Filament/AdminPanelProvider.php`, panel at `/admin`.
2. `php artisan make:filament-user` → first admin.
3. `User` implements `FilamentUser::canAccessPanel()`. Because the site has public registration, add an `is_admin` boolean to `users` (new migration) and allow only admins.
4. Resources: Testimonial, Service, TeamMember (editable, image uploads on the `public` disk + `php artisan storage:link`), ContactMessage and Subscriber (read-only).
5. Controllers map uploaded images with `Storage::disk('public')->url()` and seeded ones (`images/…`) with `asset()`.

Filament keeps its own look and never touches the Vue site or `public/css`.

---

## Commands

All `php` and `npm` commands run inside the project folder.

```
php artisan serve                     # Site at http://127.0.0.1:8000
npm run dev                           # Vite: hot reload + SSR in development (port 5173)
npm run build                         # Client + SSR bundles (public/build, bootstrap/ssr)
php artisan inertia:start-ssr         # SSR server after a build (port 13714, internal)
php artisan migrate                   # New migrations only
php artisan db:seed --class=XSeeder   # Seed one table (plain db:seed duplicates rows)
php artisan migrate:fresh --seed      # Rebuild everything (deletes all data)
php artisan make:model Name -ms       # Model + migration + seeder
php artisan db:show                   # List tables
php artisan tinker                    # e.g. App\Models\ContactMessage::all();
```

Database browser: http://127.0.0.1:8000/adminer.php (opens directly, no login locally).

---

## `.env` modes

| Variable | Development | Demo link (tunnel) |
|---|---|---|
| `APP_URL` | `http://localhost` | `https://<words>.trycloudflare.com` (no trailing slash, changes every run) |
| `APP_DEBUG` | `true` | `false` |

Edit the existing lines; never add duplicates (the first occurrence wins). Other keys stay the same in both modes, including `ADMINER_USER` / `ADMINER_PASSWORD` (tunnel access to Adminer).

---

## Sharing a demo link (Cloudflare Tunnel)

1. Stop `npm run dev`; delete `public/hot` if it remains.
2. `npm run build`.
3. Terminals: `php artisan serve` · `php artisan inertia:start-ssr` · `cloudflared tunnel --url http://127.0.0.1:8000`.
4. Put the printed URL in `APP_URL`, set `APP_DEBUG=false`.
5. To show Vue changes through the tunnel: `npm run build` again, or `npx vite build --watch`. PHP and `public/css` changes apply instantly.
6. Back to development: restore the `.env` development values and run `npm run dev`.

Adminer through the tunnel shows an English "Database access" sign-in (credentials from `.env`); locally it opens directly. Never give Adminer to a client: Filament is the client tool.

---

## Production (not set up)

Needs a host that runs PHP and Node together (Laravel Cloud, Forge + VPS, Railway, Render). Not shared PHP hosting, not Netlify/Vercel. Switch to MySQL/PostgreSQL, `APP_DEBUG=false`, keep the SSR process running under a monitor, never deploy Adminer.

---

## Decisions and context

- Laravel was chosen by the team to leave WordPress and page builders. For pure marketing sites the user prefers Next.js + MongoDB; Laravel + Inertia + Vue + Filament is the base for projects that need a client admin and backend logic.
- WordPress headless (wp-admin as CMS, Vue/Next frontend) is the alternative when a client already works in WordPress; backend plugins (ACF, SEO, WooCommerce data) work through the API, frontend plugins and page builders do not.
- SSR is mandatory for public pages; Next.js offers the same, so SEO is not a differentiator between the two.
