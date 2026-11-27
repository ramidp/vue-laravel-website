<?php

namespace App\Filament\Resources\DemoReels;

use App\Filament\Resources\DemoReels\Pages\CreateDemoReel;
use App\Filament\Resources\DemoReels\Pages\EditDemoReel;
use App\Filament\Resources\DemoReels\Pages\ListDemoReels;
use App\Models\DemoReel;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class DemoReelResource extends Resource
{
    protected static ?string $model = DemoReel::class;

    protected static ?string $navigationLabel = 'Demo reel';

    protected static ?string $modelLabel = 'demo reel';

    protected static ?string $recordTitleAttribute = 'title';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedVideoCamera;

    protected static string|UnitEnum|null $navigationGroup = 'Homepage';

    protected static ?int $navigationSort = 7;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')
                ->maxLength(255)
                ->helperText('Only used in the admin, so you can tell reels apart.'),
            FileUpload::make('video')
                ->label('Desktop video')
                ->requiredWithout('video_mobile')
                ->disk('site')
                ->directory('videos')
                ->visibility('public')
                ->acceptedFileTypes(['video/mp4', 'video/webm', 'video/quicktime'])
                ->maxSize(102400)
                ->helperText('Played on desktop. MP4, WebM, or MOV. The newest active reel is the one that plays.'),
            FileUpload::make('video_mobile')
                ->label('Mobile video')
                ->requiredWithout('video')
                ->disk('site')
                ->directory('videos')
                ->visibility('public')
                ->acceptedFileTypes(['video/mp4', 'video/webm', 'video/quicktime'])
                ->maxSize(102400)
                ->helperText('Played on phones. Leave this empty to use the desktop video.'),
            Toggle::make('is_active')
                ->label('Show on the site')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->placeholder('Demo reel')->searchable(),
                TextColumn::make('video')->label('Desktop')->placeholder('—'),
                TextColumn::make('video_mobile')->label('Mobile')->placeholder('Uses desktop'),
                IconColumn::make('is_active')->label('Shown')->boolean(),
                TextColumn::make('updated_at')->label('Updated')->dateTime()->sortable(),
            ])
            ->defaultSort('updated_at', 'desc')
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
            'index' => ListDemoReels::route('/'),
            'create' => CreateDemoReel::route('/create'),
            'edit' => EditDemoReel::route('/{record}/edit'),
        ];
    }
}
