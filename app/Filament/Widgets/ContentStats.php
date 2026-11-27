<?php

namespace App\Filament\Widgets;

use App\Models\ContactMessage;
use App\Models\Service;
use App\Models\Subscriber;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ContentStats extends StatsOverviewWidget
{
    protected static ?int $sort = -2;

    protected function getStats(): array
    {
        return [
            Stat::make('Services', Service::query()->count()),
            Stat::make('Team members', TeamMember::query()->count()),
            Stat::make('Testimonials', Testimonial::query()->count()),
            Stat::make('Messages', ContactMessage::query()->count()),
            Stat::make('Subscribers', Subscriber::query()->count()),
            Stat::make('Users', User::query()->count()),
        ];
    }
}
