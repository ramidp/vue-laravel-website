<?php

namespace App\Filament\Resources\CompanyInfos\Pages;

use App\Filament\Resources\CompanyInfos\CompanyInfoResource;
use App\Models\CompanyInfo;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCompanyInfos extends ListRecords
{
    protected static string $resource = CompanyInfoResource::class;

    protected function getHeaderActions(): array
    {
        if (CompanyInfo::query()->exists()) {
            return [];
        }

        return [
            CreateAction::make(),
        ];
    }
}
