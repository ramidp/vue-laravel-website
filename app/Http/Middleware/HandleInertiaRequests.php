<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
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
        ];
    }
}
