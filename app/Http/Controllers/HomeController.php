<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\TeamMember;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    /**
     * Show the homepage with data from the database.
     * Inertia::render() sends the props to resources/js/pages/Home.vue
     */
    public function index(): Response
    {
        return Inertia::render('Home', [
            'services' => Service::visible()
                ->get(['id', 'title', 'description', 'link']),

            'teamMembers' => TeamMember::visible()
                ->get()
                ->map(fn (TeamMember $member) => [
                    'id' => $member->id,
                    'name' => $member->name,
                    'role' => $member->role,
                    'photo' => $member->photo ? asset($member->photo) : null,
                    'initials' => $member->initials,
                ]),
        ]);
    }
}
