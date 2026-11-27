<?php

namespace App\Filament;

use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;

class SiteImage
{
    /**
     * Image field stored on the "site" disk as images/file.png.
     */
    public static function upload(string $name): FileUpload
    {
        return FileUpload::make($name)
            ->image()
            ->disk('site')
            ->directory('images')
            ->visibility('public')
            ->maxSize(4096);
    }

    /**
     * Thumbnail for a path stored on the "site" disk.
     */
    public static function column(string $name): ImageColumn
    {
        return ImageColumn::make($name)
            ->label('Preview')
            ->disk('site')
            ->visibility('public')
            ->imageHeight(48)
            ->imageWidth(72)
            ->extraImgAttributes([
                'style' => 'object-fit:contain;background:#1c1c1c;border-radius:4px;',
            ]);
    }
}
