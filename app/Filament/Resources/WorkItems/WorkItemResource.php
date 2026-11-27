<?php

namespace App\Filament\Resources\WorkItems;

use App\Filament\Resources\WorkItems\Pages\CreateWorkItem;
use App\Filament\Resources\WorkItems\Pages\EditWorkItem;
use App\Filament\Resources\WorkItems\Pages\ListWorkItems;
use App\Filament\SiteImage;
use App\Models\WorkItem;
use BackedEnum;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class WorkItemResource extends Resource
{
    protected static ?string $model = WorkItem::class;

    protected static ?string $navigationLabel = 'Work marquee';

    protected static ?string $modelLabel = 'work image';

    protected static ?string $recordTitleAttribute = 'image';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Homepage';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            SiteImage::upload('image')->required(),
            Select::make('row')
                ->options([
                    1 => 'Row 1 (scrolls left)',
                    2 => 'Row 2 (scrolls right, hidden on phones)',
                ])
                ->required()
                ->default(1),
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
                TextColumn::make('row')->sortable(),
                TextColumn::make('sort_order')->label('Order')->sortable(),
                IconColumn::make('is_active')->label('Shown')->boolean(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->orderBy('row')->orderBy('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWorkItems::route('/'),
            'create' => CreateWorkItem::route('/create'),
            'edit' => EditWorkItem::route('/{record}/edit'),
        ];
    }
}
