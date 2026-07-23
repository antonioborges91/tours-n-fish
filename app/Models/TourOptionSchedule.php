<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TourOptionSchedule extends Model
{
    protected $fillable = [
        'tour_option_id',
        'start_time',
        'end_time',
        'display_order',
    ];

    public function option(): BelongsTo
    {
        return $this->belongsTo(TourOption::class, 'tour_option_id');
    }
}