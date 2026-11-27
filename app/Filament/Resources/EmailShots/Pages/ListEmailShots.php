<?php

namespace App\Filament\Resources\EmailShots\Pages;

use App\Filament\Resources\EmailShots\EmailShotResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEmailShots extends ListRecords
{
    protected static string $resource = EmailShotResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
