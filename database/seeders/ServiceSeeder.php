<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Insert sample services into the database.
     */
    public function run(): void
    {
        $services = [
            [
                'title' => 'Creative Performance Ads',
                'description' => 'Scroll-stopping static and video ads built to test fast and scale what converts on Meta, TikTok and Google.',
                'image' => 'images/483b4.png',
            ],
            [
                'title' => 'Persona-Driven Landing Pages',
                'description' => 'Landing pages designed around each audience segment, its objections and the traffic source it comes from.',
                'image' => 'images/702bb.png',
            ],
            [
                'title' => 'Email & SMS Flows',
                'description' => 'Campaigns and automated flows that capture, nurture and bring your customers back.',
                'image' => 'images/0cb78.png',
            ],
            [
                'title' => 'UGC & Video Content',
                'description' => 'Creator-led videos and testimonials that feel native to the feed and build trust.',
                'image' => 'images/7e821.png',
            ],
            [
                'title' => 'CRO & Funnel Strategy',
                'description' => 'Audits, A/B tests and funnel mapping to turn more of your traffic into revenue.',
                'image' => 'images/c6aec.png',
            ],
            [
                'title' => 'Brand & Product Creative',
                'description' => 'Product visuals and brand assets that make your offer impossible to ignore.',
                'image' => 'images/2d83d.png',
            ],
        ];

        foreach ($services as $index => $service) {
            Service::create([
                ...$service,
                'link' => '#contact',
                'sort_order' => $index + 1,
            ]);
        }
    }
}
