<?php

namespace App\Models;

use App\Models\Concerns\IsVisible;
use Illuminate\Database\Eloquent\Model;

class EmailShot extends Model
{
    use IsVisible;

    protected $fillable = [
        'image',
        'is_wide',
        'is_dim',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_wide' => 'boolean',
            'is_dim' => 'boolean',
            'is_active' => 'boolean',
        ];
    }
}
