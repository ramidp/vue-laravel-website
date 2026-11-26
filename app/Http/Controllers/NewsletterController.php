<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    /**
     * Validate the email and add it to the subscribers table.
     */
    public function store(Request $request): RedirectResponse
    {
        // The field is called "newsletter_email" so it doesn't clash with the contact form's "email"
        $validated = $request->validate([
            'newsletter_email' => ['required', 'email', 'max:255', 'unique:subscribers,email'],
        ], [
            'newsletter_email.required' => 'Please enter your email.',
            'newsletter_email.email' => 'Please enter a valid email.',
            'newsletter_email.unique' => 'This email is already subscribed.',
        ]);

        Subscriber::create([
            'email' => strtolower($validated['newsletter_email']),
        ]);

        return back()->with('newsletter_success', 'You are in! Thanks for subscribing.');
    }
}
