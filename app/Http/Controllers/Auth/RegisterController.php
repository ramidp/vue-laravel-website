<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
use Inertia\Response;

class RegisterController extends Controller
{
    /**
     * Show the registration form (resources/js/pages/auth/Register.vue).
     */
    public function create(): Response
    {
        return Inertia::render('auth/Register');
    }

    /**
     * Validate the form, create the user and log them in.
     */
    public function store(Request $request): RedirectResponse
    {
        // On failure, Inertia sends the errors back to the Vue form (form.errors)
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        // The password is hashed automatically by the 'hashed' cast in the User model
        $user = User::create($validated);

        Auth::login($user);

        // Prevent session fixation
        $request->session()->regenerate();

        return redirect()->route('account')->with('status', 'Welcome, '.$user->name.'! Your account was created.');
    }
}
