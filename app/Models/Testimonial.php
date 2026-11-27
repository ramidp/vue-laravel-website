<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    /**
     * Columns that can be filled with create() / update().
     */
    protected $fillable = [
        'name',
        'role',
        'quote',
        'photo',
        'photo_position',
        'logo',
        'logo_alt',
        'logo_width',
        'logo_height',
        'logo_blend',
        'logo_crop',
        'sort_order',
        'is_active',
    ];

    /**
     * Cast database values to PHP types.
     */
    protected $casts = [
        'is_active' => 'boolean',
        'logo_width' => 'integer',
        'logo_height' => 'integer',
        'logo_crop' => 'array',
    ];

    /**
     * Scope: only active testimonials, ordered by sort_order.
     * Usage: Testimonial::visible()->get()
     */
    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
};
