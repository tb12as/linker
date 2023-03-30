<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    protected $casts = [
        'expire_at' => 'datetime',
        'views_count' => 'integer',
        'is_private' => 'boolean'
    ];

    // TODO : add global scope to check expired_at date
}
