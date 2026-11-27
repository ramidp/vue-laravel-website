<?php

namespace App\Filament\Resources\EmailShots;

use App\Filament\Resources\EmailShots\Pages\CreateEmailShot;
use App\Filament\Resources\EmailShots\Pages\EditEmailShot;
use App\Filament\Resources\EmailShots\Pages\ListEmailShots;
use App\Filament\SiteImage;
use App\Models\EmailShot;
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
use Filament\Tables\Table;
use UnitEnum;

class EmailShotResource extends Resource
{
    protected static ?string $model = EmailShot::class;

    protected static ?string $navigationLabel = 'Emails';

    protected static ?string $modelLabel = 'email';

    protected static ?string $recordTitleAttribute = 'image';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedEnvelope;

    protected static string|UnitEnum|null $navigationGroup = 'Homepage';

    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            SiteImage::upload('image')->required(),
            Toggle::make('is_wide')
                ->label('Wide')
                ->helperText('The larger shot in the row.'),
            Toggle::make('is_dim')
                ->label('Dimmed')
                ->default(true)
                ->helperText('Turn this off for the shot that stays bright.'),
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
                IconColumn::make('is_wide')->label('Wide')->boolean(),
                IconColumn::make('is_dim')->label('Dimmed')->boolean(),
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
            'index' => ListEmailShots::route('/'),
            'create' => CreateEmailShot::route('/create'),
            'edit' => EditEmailShot::route('/{record}/edit'),
        ];
    }
}
