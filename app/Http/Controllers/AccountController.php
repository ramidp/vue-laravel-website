<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AccountController extends Controller
{
    /**
     * Private page for logged-in users (resources/js/pages/Account.vue).
     */
    public function show(Request $request): Response
    {
        $user = $request->user();

        return Inertia::render('Account', [
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'memberSince' => $user->created_at->format('M d, Y'),
            ],
        ]);
    }
}
