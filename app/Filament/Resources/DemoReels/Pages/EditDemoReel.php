<?php

namespace App\Filament\Resources\DemoReels\Pages;

use App\Filament\Resources\DemoReels\DemoReelResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDemoReel extends EditRecord
{
    protected static string $resource = DemoReelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
