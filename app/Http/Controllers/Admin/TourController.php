<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTourRequest;
use App\Models\Tour;

class TourController extends Controller
{
    public function index()
    {
        return view('admin.tours.index');
    }

    public function create()
    {
        return view('admin.tours.create');
    }

    public function store(StoreTourRequest $request)
    {
        $data = $request->validated();

        $path = $request->file('cover_image')->store('tours/covers', 'public');

        $tour = Tour::create([
            'cover_image'    => $path,
            'duration'       => $data['duration'],
            'pricing_model'  => $data['pricing_model'],
            'price'          => $data['price'],
            'max_capacity'   => $data['max_capacity'],
            'featured_home'  => $request->boolean('featured_home'),
            'available'      => $request->boolean('available'),
            'display_order'  => 0,
        ]);

        dd($tour);
    }
}