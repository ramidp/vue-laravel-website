<?php

namespace App\Filament\Resources\ServiceGroups;

use App\Filament\Resources\ServiceGroups\Pages\CreateServiceGroup;
use App\Filament\Resources\ServiceGroups\Pages\EditServiceGroup;
use App\Filament\Resources\ServiceGroups\Pages\ListServiceGroups;
use App\Models\ServiceGroup;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class ServiceGroupResource extends Resource
{
    protected static ?string $model = ServiceGroup::class;

    protected static ?string $navigationLabel = 'Services';

    protected static ?string $modelLabel = 'service group';

    protected static ?string $recordTitleAttribute = 'line1';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Homepage';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('number')
                ->label('Number')
                ->required()
                ->maxLength(8)
                ->helperText('Shown on the tab, for example 01.'),
            TextInput::make('line1')
                ->label('Title, first line')
                ->required()
                ->maxLength(255),
            TextInput::make('line2')
                ->label('Title, second line')
                ->required()
                ->maxLength(255),
            Textarea::make('text')
                ->label('Description')
                ->required()
                ->rows(4)
                ->columnSpanFull(),
            Repeater::make('items')
                ->relationship()
                ->orderColumn('sort_order')
                ->helperText('The tab shows how many items this group has. Drag to change their order.')
                ->schema([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    Select::make('column')
                        ->options([
                            1 => 'Left column',
                            2 => 'Right column',
                        ])
                        ->required()
                        ->default(1),
                ])
                ->columns(2)
                ->columnSpanFull()
                ->addActionLabel('Add service')
                ->itemLabel(fn (array $state): ?string => $state['name'] ?? null),
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
                TextColumn::make('number')->sortable(),
                TextColumn::make('line1')->label('Title')->searchable(),
                TextColumn::make('line2')->label('Second line'),
                TextColumn::make('items_count')->counts('items')->label('Items'),
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
            'index' => ListServiceGroups::route('/'),
            'create' => CreateServiceGroup::route('/create'),
            'edit' => EditServiceGroup::route('/{record}/edit'),
        ];
    }
}
