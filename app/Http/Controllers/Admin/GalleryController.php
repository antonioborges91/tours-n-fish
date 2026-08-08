<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $photos = Gallery::orderBy('sort_order')->get();

        return view('admin.gallery.index', compact('photos'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => ['required', 'image', 'max:5120'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $path = $request->file('image')->store('gallery', 'public');

        Gallery::create([
            'image' => $path,
            'sort_order' => (Gallery::max('sort_order') ?? 0) + 1,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Fotografia adicionada com sucesso.');
    }

    public function show(Gallery $gallery)
    {
        return redirect()->route('admin.gallery.edit', $gallery);
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.gallery.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'image' => ['nullable', 'image', 'max:5120'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {

            Storage::disk('public')->delete($gallery->image);

            $gallery->image = $request->file('image')->store('gallery', 'public');
        }

        $gallery->is_active = $request->boolean('is_active');

        $gallery->save();

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Fotografia atualizada com sucesso.');
    }

    public function destroy(Gallery $gallery)
    {
        Storage::disk('public')->delete($gallery->image);

        $gallery->delete();

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Fotografia removida com sucesso.');
    }

    public function move(Request $request, Gallery $gallery)
    {
        $direction = $request->validate([
            'direction' => ['required', 'in:up,down'],
        ])['direction'];

        $swap = $direction === 'up'
            ? Gallery::where('sort_order', '<', $gallery->sort_order)
                ->orderByDesc('sort_order')
                ->first()
            : Gallery::where('sort_order', '>', $gallery->sort_order)
                ->orderBy('sort_order')
                ->first();

        if ($swap) {

            [$gallery->sort_order, $swap->sort_order] = [
                $swap->sort_order,
                $gallery->sort_order,
            ];

            $gallery->save();

            $swap->save();
        }

        return back();
    }
}