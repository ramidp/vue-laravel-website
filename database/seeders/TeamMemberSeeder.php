<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    /**
     * Insert sample team members into the database.
     * Names and roles are placeholders: edit them in the database.
     */
    public function run(): void
    {
        $members = [
            ['name' => 'Alex Carter', 'role' => 'Founder & CEO', 'photo' => 'images/842b4.png'],
            ['name' => 'Emma Lewis', 'role' => 'Head of Strategy', 'photo' => 'images/919e3.png'],
            ['name' => 'Ryan Brooks', 'role' => 'Creative Director', 'photo' => 'images/8d6f6.png'],
            ['name' => 'Sofia Martin', 'role' => 'Lead Designer', 'photo' => 'images/cd908.png'],
            ['name' => 'Daniel Hayes', 'role' => 'Performance Marketer', 'photo' => 'images/a909d.png'],
            ['name' => 'Olivia Reed', 'role' => 'Email & Retention Lead', 'photo' => 'images/e5783.png'],
            ['name' => 'Marco Silva', 'role' => 'Web Developer', 'photo' => 'images/709d8.png'],
            ['name' => 'Lucas Grant', 'role' => 'Video Editor', 'photo' => 'images/64960.png'],
        ];

        foreach ($members as $index => $member) {
            TeamMember::create([
                ...$member,
                'sort_order' => $index + 1,
            ]);
        }
    }
}
