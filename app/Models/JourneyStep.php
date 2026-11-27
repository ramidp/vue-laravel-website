<?php

namespace App\Models;

use App\Models\Concerns\IsVisible;
use Illuminate\Database\Eloquent\Model;

class JourneyStep extends Model
{
    use IsVisible;

    protected $fillable = [
        'number',
        'label',
        'image',
        'title',
        'body',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
