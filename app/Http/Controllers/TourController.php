<?php

namespace App\Http\Controllers;

use App\Models\Tour;

class TourController extends Controller
{
    public function index()
    {
        $tours = Tour::query()
            ->where('available', true)
            ->with([
                'translations',
                'options.translations',
            ])
            ->orderBy('display_order')
            ->get();

        return view('pages.tours.index', compact('tours'));
    }

    public function show(Tour $tour)
{
    $tour->load([
        'translations',
        'images',
        'options.translations',
        'options.schedules',
    ]);

    return view('pages.tours.show', compact('tour'));
}
}