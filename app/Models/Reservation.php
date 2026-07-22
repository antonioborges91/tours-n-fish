<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    protected $fillable = [
        'reservation_reference',
        'tour_id',
        'tour_schedule_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_country',
        'locale',
        'notes',
        'reservation_date',
        'people',
        'total_price',
        'deposit_amount',
        'remaining_amount',
        'payment_proof',
        'payment_proof_uploaded_at',
        'deposit_payment_method',
        'final_payment_method',
        'final_payment_amount',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'reservation_date' => 'date',
            'payment_proof_uploaded_at' => 'datetime',
            'people' => 'integer',
            'total_price' => 'decimal:2',
            'deposit_amount' => 'decimal:2',
            'remaining_amount' => 'decimal:2',
            'final_payment_amount' => 'decimal:2',
        ];
    }

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(TourSchedule::class, 'tour_schedule_id');
    }
}