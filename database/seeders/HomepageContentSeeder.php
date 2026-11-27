<?php

namespace Database\Seeders;

use App\Models\ClientLogo;
use App\Models\EmailShot;
use App\Models\JourneyStep;
use App\Models\Platform;
use App\Models\ServiceGroup;
use App\Models\WorkItem;
use Illuminate\Database\Seeder;

class HomepageContentSeeder extends Seeder
{
    /**
     * Load the homepage blocks that are on the site today.
     * Skips a table that already has rows.
     */
    public function run(): void
    {
        $this->seedLogos();
        $this->seedWork();
        $this->seedServices();
        $this->seedJourney();
        $this->seedPlatforms();
        $this->seedEmails();
    }

    private function seedLogos(): void
    {
        if (ClientLogo::query()->exists()) {
            return;
        }

        $logos = [
            ['af51e.png', 'Client logo'],
            ['6d134.png', 'Paramount'],
            ['d9fd2.png', 'Hush'],
            ['036b4.png', 'Habitat for Humanity'],
            ['e3dd5.png', 'Kala Redlight'],
            ['3e9f7.png', 'Kinsmen'],
            ['da572.png', 'Trufit Customs'],
            ['982ff.png', 'CertainTeed'],
            ['cd1d6.png', 'True Classic'],
            ['2330a.png', 'BioHarvest'],
            ['d2cdc.png', 'VINIA'],
            ['572bc.png', 'Impact Dog Crates'],
            ['675f1.png', 'Client logo'],
            ['3755d.png', 'Shop Fan Expo'],
            ['395cf.png', 'Sympli'],
            ['64071.png', 'Coldture'],
            ['5a1f3.png', 'Pluck Teas'],
            ['03281.png', 'Solv Wellness'],
            ['73b0c.png', 'truLOCAL'],
            ['8252d.png', 'Hinoman'],
            ['cc9e2.png', 'Mankai'],
            ['7570c.png', 'Lebert'],
            ['4b3bd.png', 'Accessibility Professionals'],
            ['3603a.png', 'United Way'],
            ['80a48.png', 'Caribu'],
            ['c3429.png', 'Blumsafe'],
            ['cdef1.png', 'MCSC'],
            ['9db0b.png', 'Xpand'],
            ['57d8d.png', 'Pave'],
            ['3cc39.png', '13 Fifty Apparel'],
            ['e5102.png', 'Tugboat'],
            ['a9193.png', 'Client logo'],
            ['58e42.png', 'Proodles'],
            ['689c6.png', 'made+'],
            ['7e56c.png', 'Moxxor'],
            ['bd6f5.png', 'Reerth'],
            ['6310b.png', 'KCS'],
            ['ae070.png', 'Riverside'],
            ['de361.png', 'Patch Aura'],
            ['77f6a.png', 'Faireez'],
            ['48b04.png', 'Turmeric Tea'],
            ['04a5e.png', 'Revitasize'],
            ['32f7f.png', 'Client logo'],
            ['44c54.png', 'Deer Creek'],
            ['e6c51.png', "Fox's Bakery"],
        ];

        foreach ($logos as $index => [$file, $alt]) {
            ClientLogo::query()->create([
                'image' => "images/{$file}",
                'alt' => $alt,
                'sort_order' => $index + 1,
                'is_active' => true,
            ]);
        }
    }

    private function seedWork(): void
    {
        if (WorkItem::query()->exists()) {
            return;
        }

        $rows = [
            1 => ['483b4.png', '7e821.png', 'd6bb6.png', 'd599e.png', 'cdedf.png', '9befb.png', '0cb78.png', 'bf6b4.png', '9b11e.png', '0cb78.png'],
            2 => ['7f0ab.png', 'bf6b4.png', 'f5c51.png', '2d83d.png'],
        ];

        foreach ($rows as $row => $files) {
            foreach ($files as $index => $file) {
                WorkItem::query()->create([
                    'image' => "images/{$file}",
                    'row' => $row,
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]);
            }
        }
    }

    private function seedServices(): void
    {
        if (ServiceGroup::query()->exists()) {
            return;
        }

        $groups = [
            [
                'number' => '01',
                'line1' => 'CREATIVELY',
                'line2' => 'ENGINEERED',
                'text' => 'We build brand identity, ads, messaging, and campaigns designed to hold, awe and segregate customer signals into funnels. No matter where they are.',
                'columns' => [
                    ['Creative Ads', 'UGC / PGC', 'AI Creative', 'Video Production'],
                    ['3D Modelling', 'Photography', 'Printed Media', 'Branding / Packaging'],
                ],
            ],
            [
                'number' => '02',
                'line1' => 'PERFORMANCE',
                'line2' => 'DRIVEN',
                'text' => 'The algorithms are hungry! Fast iteration and tactical precision is the name of the game. Every campaign we launch is grounded in strategy and managed to SCALE!',
                'columns' => [
                    ['Meta Performance', 'Google Performance', 'Amazon Management', 'AppLovin Ads', 'TikTok Ads'],
                    ['LinkedIn Ads', 'Pinterest Ads', 'Reddit Ads', 'Broadcast Media', 'StackAdapt - Programmatic'],
                ],
            ],
            [
                'number' => '03',
                'line1' => 'CONVERSION',
                'line2' => 'LED',
                'text' => 'From first click to final conversion, we design high-impact digital experiences that guide users, remove friction, and drive real results.',
                'columns' => [
                    ['Shopify Management', 'Website Development', 'Website Enhancement (CRO)', 'Speed & Core Web Vitals', 'Landing Page Testin'],
                    ['Amazon Management', 'SEO / AEO / GEO', 'Tracking & Analytics', 'Security & Compliance'],
                ],
            ],
            [
                'number' => '04',
                'line1' => 'RETENTION',
                'line2' => 'FOCUSED',
                'text' => 'The secret to compound growth isn’t just looking for new customers. It’s keeping the ones you already paid to acquire.',
                'columns' => [
                    ['Email Marketing / SMS', 'Subscription Programs', 'Churn prevention'],
                    ['CRM Integration', 'LTV as a north star metric', 'Data Modelling'],
                ],
            ],
        ];

        foreach ($groups as $index => $group) {
            $record = ServiceGroup::query()->create([
                'number' => $group['number'],
                'line1' => $group['line1'],
                'line2' => $group['line2'],
                'text' => $group['text'],
                'sort_order' => $index + 1,
                'is_active' => true,
            ]);

            $order = 1;
            foreach ($group['columns'] as $column => $names) {
                foreach ($names as $name) {
                    $record->items()->create([
                        'name' => $name,
                        'column' => $column + 1,
                        'sort_order' => $order,
                    ]);
                    $order++;
                }
            }
        }
    }

    private function seedJourney(): void
    {
        if (JourneyStep::query()->exists()) {
            return;
        }

        $steps = [
            [
                'number' => '1',
                'label' => 'DISCOVER',
                'image' => 'images/c6aec.png',
                'title' => 'RESEARCH-DRIVEN AD ANGLES',
                'body' => 'A busy parent and a bargain hunter have different drives and timing. We create angles for each type of buyer, run it across multiple channels with specific tactics, customizing the storytelling to test different hypothesis.',
            ],
            [
                'number' => '2',
                'label' => 'SEGREGATE',
                'image' => 'images/702bb.png',
                'title' => 'PERSONA-BASED LANDING PAGES',
                'body' => 'Each page picks up where its ad left off, built around one persona’s needs and stage in the journey. It answers the questions they’re actually asking and moves them toward signing up or buying.',
            ],
            [
                'number' => '3',
                'label' => 'CONVERT & NURTURE',
                'image' => 'images/5c44c.png',
                'title' => 'CUSTOM-MADE POP-UPS & EMAIL',
                'body' => 'Pop-ups capture interest with an offer that fits that journey. Email takes it from there, nurturing with consistency throughout the flows, giving them reasons to buy and to come back, consistent with the very first signal.',
            ],
        ];

        foreach ($steps as $index => $step) {
            JourneyStep::query()->create($step + [
                'sort_order' => $index + 1,
                'is_active' => true,
            ]);
        }
    }

    private function seedPlatforms(): void
    {
        if (Platform::query()->exists()) {
            return;
        }

        $rows = [
            1 => [
                ['9a9a4.png', 'Meta'],
                ['e8cfb.png', 'YouTube'],
                ['cfc15.png', 'TikTok'],
                ['6dd3c.png', 'LinkedIn'],
                ['b59a4.png', 'Mailchimp'],
                ['2b4a8.png', 'StackAdapt'],
                ['ba363.png', 'Pinterest'],
            ],
            2 => [
                ['db795.png', 'Shopify'],
                ['4bafa.png', ''],
                ['e2cc7.png', 'Reddit'],
                ['d679d.png', 'Walmart'],
                ['3dd34.png', 'Google'],
                ['d9534.png', 'Klaviyo'],
            ],
        ];

        foreach ($rows as $row => $logos) {
            foreach ($logos as $index => [$file, $alt]) {
                Platform::query()->create([
                    'image' => "images/{$file}",
                    'alt' => $alt,
                    'row' => $row,
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]);
            }
        }
    }

    private function seedEmails(): void
    {
        if (EmailShot::query()->exists()) {
            return;
        }

        $shots = [
            ['b2110.png', false, true],
            ['abd36.png', true, false],
            ['7843a.png', false, true],
            ['feec4.png', false, true],
            ['92017.png', false, true],
            ['fda02.png', false, true],
            ['082d4.png', false, true],
            ['43ae4.png', false, true],
            ['1be04.png', false, true],
            ['37281.png', false, true],
            ['2655d.png', false, true],
            ['677a8.png', false, true],
        ];

        foreach ($shots as $index => [$file, $wide, $dim]) {
            EmailShot::query()->create([
                'image' => "images/{$file}",
                'is_wide' => $wide,
                'is_dim' => $dim,
                'sort_order' => $index + 1,
                'is_active' => true,
            ]);
        }
    }
}
