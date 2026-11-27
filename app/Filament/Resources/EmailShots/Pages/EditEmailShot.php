<?php

namespace App\Filament\Resources\EmailShots\Pages;

use App\Filament\Resources\EmailShots\EmailShotResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEmailShot extends EditRecord
{
    protected static string $resource = EmailShotResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
