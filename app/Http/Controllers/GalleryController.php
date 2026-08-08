<?php

namespace App\Http\Controllers;

use App\Models\Gallery;

class GalleryController extends Controller
{
    public function index()
    {
        $photos = Gallery::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('pages.gallery.index', compact('photos'));
    }
}