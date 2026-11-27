<?php

namespace App\Filament\Resources\Testimonials\Schemas;

use App\Filament\SiteImage;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TestimonialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('role')
                    ->required()
                    ->maxLength(255),
                Textarea::make('quote')
                    ->required()
                    ->columnSpanFull(),
                SiteImage::upload('photo')
                    ->required(),
                TextInput::make('photo_position')
                    ->helperText('CSS object-position, for example "center bottom".')
                    ->maxLength(255),
                SiteImage::upload('logo')
                    ->required(),
                TextInput::make('logo_alt')
                    ->label('Logo alt text')
                    ->required()
                    ->maxLength(255),
                TextInput::make('logo_width')
                    ->required()
                    ->numeric()
                    ->minValue(1),
                TextInput::make('logo_height')
                    ->required()
                    ->numeric()
                    ->minValue(1),
                TextInput::make('logo_blend')
                    ->helperText('CSS mix-blend-mode. Leave empty when the logo does not need it.')
                    ->maxLength(255),
                KeyValue::make('logo_crop')
                    ->helperText('Optional crop box: width, height, left, top.')
                    ->keyLabel('Property')
                    ->valueLabel('Value')
                    ->columnSpanFull(),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->minValue(0),
                Toggle::make('is_active')
                    ->default(true),
            ]);
    }
}
