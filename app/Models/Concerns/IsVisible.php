<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait IsVisible
{
    /**
     * Active records in the order a client set.
     */
    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
