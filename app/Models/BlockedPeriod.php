<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockedPeriod extends Model
{
    protected $fillable = [
        'start_at',
        'end_at',
        'reason',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];
}