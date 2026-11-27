<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceItem extends Model
{
    protected $fillable = [
        'service_group_id',
        'name',
        'column',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'column' => 'integer',
        ];
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(ServiceGroup::class, 'service_group_id');
    }
}
