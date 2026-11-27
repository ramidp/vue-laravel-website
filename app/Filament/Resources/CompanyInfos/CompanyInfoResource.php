<?php

namespace App\Filament\Resources\CompanyInfos;

use App\Filament\Resources\CompanyInfos\Pages\CreateCompanyInfo;
use App\Filament\Resources\CompanyInfos\Pages\EditCompanyInfo;
use App\Filament\Resources\CompanyInfos\Pages\ListCompanyInfos;
use App\Models\CompanyInfo;
use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class CompanyInfoResource extends Resource
{
    protected static ?string $model = CompanyInfo::class;

    protected static ?string $navigationLabel = 'Company info';

    protected static ?string $modelLabel = 'company info';

    protected static ?string $pluralModelLabel = 'Company info';

    protected static ?string $recordTitleAttribute = 'line_1';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice;

    protected static string|UnitEnum|null $navigationGroup = 'Header & footer';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('line_1')
                ->label('Address, first line')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),
            TextInput::make('line_2')
                ->label('Address, second line')
                ->maxLength(255)
                ->columnSpanFull(),
            TextInput::make('phone')
                ->label('Phone, as shown')
                ->maxLength(255),
            TextInput::make('phone_url')
                ->label('Phone link')
                ->maxLength(255)
                ->helperText('Use tel:+18886232482 so tapping the number starts a call.'),
            TextInput::make('button_label')
                ->label('Header button')
                ->required()
                ->maxLength(255)
                ->default('Chat With Us'),
            TextInput::make('button_url')
                ->label('Header button link')
                ->required()
                ->maxLength(255)
                ->default('/contact'),
            Toggle::make('is_active')
                ->label('Show on the site')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('line_1')->label('Address'),
                TextColumn::make('phone'),
                TextColumn::make('button_label')->label('Header button'),
                IconColumn::make('is_active')->label('Shown')->boolean(),
            ])
            ->recordActions([
                EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCompanyInfos::route('/'),
            'create' => CreateCompanyInfo::route('/create'),
            'edit' => EditCompanyInfo::route('/{record}/edit'),
        ];
    }
}
