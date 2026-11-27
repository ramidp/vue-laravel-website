<?php

namespace Database\Seeders;

use App\Models\CompanyInfo;
use App\Models\HeaderLink;
use App\Models\SocialLink;
use Illuminate\Database\Seeder;

class SiteChromeSeeder extends Seeder
{
    /**
     * Load the header and footer content that is on the site today.
     * Skips a table that already has rows.
     */
    public function run(): void
    {
        if (! HeaderLink::query()->exists()) {
            foreach (['Mad Studio', 'Mad Dev', 'Case Studies'] as $index => $label) {
                HeaderLink::query()->create([
                    'label' => $label,
                    'url' => null,
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]);
            }
        }

        if (! SocialLink::query()->exists()) {
            SocialLink::query()->create([
                'name' => 'Instagram',
                'url' => '#footer',
                'icon' => 'images/cf550.svg',
                'sort_order' => 1,
                'is_active' => true,
            ]);
            SocialLink::query()->create([
                'name' => 'LinkedIn',
                'url' => '#footer',
                'icon' => 'images/222bd.svg',
                'sort_order' => 2,
                'is_active' => true,
            ]);
        }

        if (! CompanyInfo::query()->exists()) {
            CompanyInfo::query()->create([
                'line_1' => 'Canada Office Location: 11 Victoria Street,',
                'line_2' => 'Unit B10 Barrie, ON L4N6T3',
                'phone' => '+ 1-888-623-2482',
                'phone_url' => 'tel:+18886232482',
                'button_label' => 'Chat With Us',
                'button_url' => '/contact',
                'is_active' => true,
            ]);
        }
    }
}
