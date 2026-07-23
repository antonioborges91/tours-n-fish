<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tour extends Model
{
    protected $fillable = [
        'cover_image',
        'duration',
        'pricing_model',
        'price',
        'max_capacity',
        'featured_home',
        'available',
        'display_order',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'featured_home' => 'boolean',
            'available' => 'boolean',
        ];
    }

    public function translations(): HasMany
    {
        return $this->hasMany(TourTranslation::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(TourSchedule::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(TourImage::class);
    }

    public function options(): HasMany
    {
        return $this->hasMany(TourOption::class)
            ->orderBy('display_order');
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
}