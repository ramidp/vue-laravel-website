<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    /**
     * Columns that can be filled with create() / update().
     */
    protected $fillable = [
        'email',
    ];
}
