<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class DemoReel extends Model
{
    protected $fillable = [
        'video',
        'video_mobile',
        'title',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * The reel that should play on the homepage.
     */
    public function scopeCurrent(Builder $query): Builder
    {
        return $query
            ->where('is_active', true)
            ->where(function (Builder $query) {
                $query->whereNotNull('video')->orWhereNotNull('video_mobile');
            })
            ->latest('updated_at');
    }
}
