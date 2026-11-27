<?php

namespace App\Filament\Resources\HeaderLinks;

use App\Filament\Resources\HeaderLinks\Pages\CreateHeaderLink;
use App\Filament\Resources\HeaderLinks\Pages\EditHeaderLink;
use App\Filament\Resources\HeaderLinks\Pages\ListHeaderLinks;
use App\Models\HeaderLink;
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

class HeaderLinkResource extends Resource
{
    protected static ?string $model = HeaderLink::class;

    protected static ?string $navigationLabel = 'Header';

    protected static ?string $modelLabel = 'header item';

    protected static ?string $recordTitleAttribute = 'label';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBars3;

    protected static string|UnitEnum|null $navigationGroup = 'Header & footer';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('label')
                ->required()
                ->maxLength(255),
            TextInput::make('url')
                ->label('Link')
                ->maxLength(255)
                ->helperText('Leave this empty to show the name as text, with no link.'),
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
                TextColumn::make('label')->searchable(),
                TextColumn::make('url')->label('Link')->placeholder('Text only'),
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
            'index' => ListHeaderLinks::route('/'),
            'create' => CreateHeaderLink::route('/create'),
            'edit' => EditHeaderLink::route('/{record}/edit'),
        ];
    }
}
