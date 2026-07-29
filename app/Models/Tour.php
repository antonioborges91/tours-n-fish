<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tour extends Model
{
    protected $fillable = [
        'cover_image',
        'max_capacity',
        'featured_home',
        'available',
        'display_order',
    ];

    protected function casts(): array
    {
        return [
            'featured_home' => 'boolean',
            'available' => 'boolean',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function translations(): HasMany
    {
        return $this->hasMany(TourTranslation::class);
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

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function translation(?string $locale = null)
{
    $locale ??= app()->getLocale();

    return $this->translations
        ->firstWhere('locale', $locale)
        ?? $this->translations->first();
}

public function firstOption()
{
    return $this->options->first();
}

    }