<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    protected $fillable = [
        'image',
        'title',
        'description',
        'display_order',
        'featured_home',
        'visible',
    ];

    protected function casts(): array
    {
        return [
            'display_order' => 'integer',
            'featured_home' => 'boolean',
            'visible' => 'boolean',
        ];
    }
}