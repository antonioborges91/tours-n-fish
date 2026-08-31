<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\BlockedPeriod;

class Reservation extends Model
{
    protected $fillable = [
        'public_token',

        'reservation_number',

        'tour_id',
        'tour_option_id',
        'tour_option_schedule_id',

        'booking_date',
        'start_at',
        'end_at',
        'participants',

        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_message',
        'locale',

        'deposit_percentage',
        'deposit_amount',
        'total_amount',
        'payment_deadline_at',


        'status',

        'payment_proof',
        'payment_submitted_at',

        'confirmed_at',
        'cancelled_at',
    ];

    protected function casts(): array
    {
        return [
            'booking_date' => 'date',

            'payment_submitted_at' => 'datetime',
            'payment_deadline_at' => 'datetime',
            'confirmed_at' => 'datetime',
            'cancelled_at' => 'datetime',

            'participants' => 'integer',

            'total_amount' => 'decimal:2',
            'deposit_percentage' => 'decimal:2',
            'deposit_amount' => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Reservation $reservation) {

            if (empty($reservation->public_token)) {
                $reservation->public_token = Str::random(64);
            }

        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relações
    |--------------------------------------------------------------------------
    */

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    public function option(): BelongsTo
    {
        return $this->belongsTo(
            TourOption::class,
            'tour_option_id'
        );
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(
            TourOptionSchedule::class,
            'tour_option_schedule_id'
        );
    }

    public function blockedPeriods(): HasMany
    {
        return $this->hasMany(
            BlockedPeriod::class,
            'reservation_id'
        );
    }   
}