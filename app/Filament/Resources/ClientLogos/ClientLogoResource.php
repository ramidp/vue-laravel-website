<?php

namespace App\Filament\Resources\ClientLogos;

use App\Filament\Resources\ClientLogos\Pages\CreateClientLogo;
use App\Filament\Resources\ClientLogos\Pages\EditClientLogo;
use App\Filament\Resources\ClientLogos\Pages\ListClientLogos;
use App\Filament\SiteImage;
use App\Models\ClientLogo;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
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

class ClientLogoResource extends Resource
{
    protected static ?string $model = ClientLogo::class;

    protected static ?string $navigationLabel = 'Logo marquee';

    protected static ?string $modelLabel = 'logo';

    protected static ?string $recordTitleAttribute = 'alt';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static string|UnitEnum|null $navigationGroup = 'Homepage';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            SiteImage::upload('image')->required(),
            TextInput::make('alt')
                ->label('Name')
                ->helperText('Used as the image description.')
                ->maxLength(255),
            TextInput::make('sort_order')
                ->label('Order')
                ->required()
                ->numeric()
                ->default(0)
                ->minValue(0),
            Toggle::make('is_active')
                ->label('Show on the site')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SiteImage::column('image'),
                TextColumn::make('alt')->label('Name')->searchable(),
                TextColumn::make('sort_order')->label('Order')->sortable(),
                IconColumn::make('is_active')->label('Shown')->boolean(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListClientLogos::route('/'),
            'create' => CreateClientLogo::route('/create'),
            'edit' => EditClientLogo::route('/{record}/edit'),
        ];
    }
}
