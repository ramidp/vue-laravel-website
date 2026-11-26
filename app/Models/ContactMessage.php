<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    /**
     * Columns that can be filled with create() / update().
     */
    protected $fillable = [
        'name',
        'email',
        'message',
    ];
}
