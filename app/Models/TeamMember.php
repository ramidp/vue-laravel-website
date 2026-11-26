<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    /**
     * Columns that can be filled with create() / update().
     */
    protected $fillable = [
        'name',
        'role',
        'photo',
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
     * Scope: only active members, ordered by sort_order.
     * Usage: TeamMember::visible()->get()
     */
    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    /**
     * Accessor: initials used as fallback when there is no photo.
     * Usage in Blade: {{ $member->initials }}
     */
    public function getInitialsAttribute(): string
    {
        return collect(explode(' ', $this->name))
            ->map(fn ($word) => mb_substr($word, 0, 1))
            ->take(2)
            ->implode('');
    }
}
