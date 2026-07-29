<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TourOption extends Model
{
    protected $fillable = [
        'tour_id',
        'duration_minutes',
        'price',
        'display_order',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(TourOptionTranslation::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(TourOptionSchedule::class)
            ->orderBy('display_order');
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function translation(?string $locale = null): ?TourOptionTranslation
    {
        $locale ??= app()->getLocale();

        return $this->translations
            ->firstWhere('locale', $locale)
            ?? $this->translations->first();
    }
}