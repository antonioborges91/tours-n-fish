<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TourOptionTranslation extends Model
{
    protected $fillable = [
        'tour_option_id',
        'locale',
        'name',
    ];

    public function option(): BelongsTo
    {
        return $this->belongsTo(TourOption::class, 'tour_option_id');
    }
}