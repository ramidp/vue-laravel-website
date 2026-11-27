<?php

namespace App\Models;

use App\Models\Concerns\IsVisible;
use Illuminate\Database\Eloquent\Model;

class WorkItem extends Model
{
    use IsVisible;

    protected $fillable = [
        'image',
        'row',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'row' => 'integer',
            'is_active' => 'boolean',
        ];
    }
}
