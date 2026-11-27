<?php

namespace App\Filament\Resources\JourneySteps;

use App\Filament\Resources\JourneySteps\Pages\CreateJourneyStep;
use App\Filament\Resources\JourneySteps\Pages\EditJourneyStep;
use App\Filament\Resources\JourneySteps\Pages\ListJourneySteps;
use App\Filament\SiteImage;
use App\Models\JourneyStep;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
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

class JourneyStepResource extends Resource
{
    protected static ?string $model = JourneyStep::class;

    protected static ?string $navigationLabel = 'Journey steps';

    protected static ?string $modelLabel = 'journey step';

    protected static ?string $recordTitleAttribute = 'label';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMap;

    protected static string|UnitEnum|null $navigationGroup = 'Homepage';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('number')
                ->required()
                ->maxLength(8),
            TextInput::make('label')
                ->required()
                ->maxLength(255),
            SiteImage::upload('image')->required(),
            TextInput::make('title')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),
            Textarea::make('body')
                ->label('Text')
                ->required()
                ->rows(4)
                ->columnSpanFull(),
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
                TextColumn::make('label')->searchable(),
                SiteImage::column('image'),
                TextColumn::make('title')->searchable(),
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
            'index' => ListJourneySteps::route('/'),
            'create' => CreateJourneyStep::route('/create'),
            'edit' => EditJourneyStep::route('/{record}/edit'),
        ];
    }
}
