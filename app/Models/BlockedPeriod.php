<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Reservation;

class BlockedPeriod extends Model
{
    protected $fillable = [
        'reservation_id',
        'start_at',
        'end_at',
        'reason',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(
            Reservation::class,
            'reservation_id'
        );
    }
}