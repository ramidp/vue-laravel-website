<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    /**
     * Columns that can be filled with create() / update().
     */
    protected $fillable = [
        'title',
        'description',
        'image',
        'link',
        'sort_order',
        'is_active',
    ];

    /**
     * Cast database values to PHP types.
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Scope: only active services, ordered by sort_order.
     * Usage: Service::visible()->get()
     */
    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
