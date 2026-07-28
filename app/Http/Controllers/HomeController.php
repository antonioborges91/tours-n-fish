<?php

namespace App\Http\Controllers;

use App\Models\Tour;

class HomeController extends Controller
{
    public function index()
    {
        $popularTours = Tour::with([
                'translations',
                'options',
            ])
            ->where('available', true)
            ->where('featured_home', true)
            ->orderBy('display_order')
            ->take(4)
            ->get();

        return view('pages.home.index', compact('popularTours'));
    }
}