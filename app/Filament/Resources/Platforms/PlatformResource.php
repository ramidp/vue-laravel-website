<?php

namespace App\Filament\Resources\Platforms;

use App\Filament\Resources\Platforms\Pages\CreatePlatform;
use App\Filament\Resources\Platforms\Pages\EditPlatform;
use App\Filament\Resources\Platforms\Pages\ListPlatforms;
use App\Filament\SiteImage;
use App\Models\Platform;
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

class PlatformResource extends Resource
{
    protected static ?string $model = Platform::class;

    protected static ?string $navigationLabel = 'Platforms';

    protected static ?string $modelLabel = 'platform';

    protected static ?string $recordTitleAttribute = 'alt';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedGlobeAlt;

    protected static string|UnitEnum|null $navigationGroup = 'Homepage';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            SiteImage::upload('image')->required(),
            TextInput::make('alt')
                ->label('Name')
                ->maxLength(255),
            Select::make('row')
                ->options([
                    1 => 'Row 1',
                    2 => 'Row 2',
                ])
                ->required()
                ->default(1)
                ->helperText('Row 2 is the lower line, with the logos spread apart.'),
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
            'index' => ListPlatforms::route('/'),
            'create' => CreatePlatform::route('/create'),
            'edit' => EditPlatform::route('/{record}/edit'),
        ];
    }
}
