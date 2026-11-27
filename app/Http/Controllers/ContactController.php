<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    /**
     * Validate the contact form and save the submission.
     */
    /**
     * Show the multi-step contact questionnaire.
     */
    public function create(): Response
    {
        return Inertia::render('Contact');
    }

    public function store(Request $request): RedirectResponse
    {
        // On failure, Inertia sends the errors back to the Vue form (form.errors)
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
        ]);

        ContactMessage::create($validated);

        // back() returns to the homepage; the Vue form keeps the scroll position
        return back()->with('contact_success', 'Thanks! Your message was sent. We will get back to you soon.');
    }
}
