<?php

namespace App\Http\Middleware;

use App\Models\CompanyInfo;
use App\Models\HeaderLink;
use App\Models\SocialLink;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * Root Blade template loaded on the first page visit (resources/views/app.blade.php).
     */
    protected $rootView = 'app';

    /**
     * Asset version: when it changes, Inertia forces a full page reload.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Props shared with EVERY page (available in Vue through usePage().props).
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),

            // Logged-in user (null for visitors). Only safe fields are exposed.
            'auth' => [
                'user' => fn () => $request->user()?->only('id', 'name', 'email'),
            ],

            // One-time flash messages set with ->with('key', 'message') in controllers
            'flash' => [
                'status' => fn () => $request->session()->get('status'),
                'contact_success' => fn () => $request->session()->get('contact_success'),
                'newsletter_success' => fn () => $request->session()->get('newsletter_success'),
            ],

            'headerLinks' => fn () => HeaderLink::visible()
                ->get()
                ->map(fn (HeaderLink $link) => [
                    'id' => $link->id,
                    'label' => $link->label,
                    'url' => $link->url,
                ]),

            'socialLinks' => fn () => SocialLink::visible()
                ->get()
                ->filter(fn (SocialLink $link) => filled($link->icon))
                ->map(fn (SocialLink $link) => [
                    'id' => $link->id,
                    'name' => $link->name,
                    'url' => $link->url ?: '#footer',
                    'icon' => asset($link->icon),
                    'external' => Str::startsWith((string) $link->url, ['http://', 'https://']),
                ])
                ->values(),

            'company' => function () {
                $info = CompanyInfo::query()->where('is_active', true)->first();

                if (! $info) {
                    return null;
                }

                return [
                    'line1' => $info->line_1,
                    'line2' => $info->line_2,
                    'phone' => $info->phone,
                    'phoneUrl' => $info->phone_url,
                    'buttonLabel' => $info->button_label,
                    'buttonUrl' => $info->button_url,
                ];
            },
        ];
    }
}
