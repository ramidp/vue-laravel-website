<?php

namespace App\Models;

use App\Models\Concerns\IsVisible;
use Illuminate\Database\Eloquent\Model;

class HeaderLink extends Model
{
    use IsVisible;

    protected $fillable = [
        'label',
        'url',
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
