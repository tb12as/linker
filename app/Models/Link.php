<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Link extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'expire_at' => 'datetime',
        'views_count' => 'integer',
        'is_private' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // TODO : add global scope to check expired_at date
}
