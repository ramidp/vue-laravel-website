<?php

namespace App\Filament\Resources\DemoReels\Pages;

use App\Filament\Resources\DemoReels\DemoReelResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDemoReels extends ListRecords
{
    protected static string $resource = DemoReelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
