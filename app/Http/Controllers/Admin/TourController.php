<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTourRequest;
use App\Http\Requests\UpdateTourRequest;
use App\Models\Tour;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TourController extends Controller
{
    public function index()
    {
        $tours = Tour::with([
            'translations',
            'options',
        ])
            ->orderBy('display_order')
            ->get();

        return view('admin.tours.index', compact('tours'));
    }

    public function create()
    {
        return view('admin.tours.create');
    }

    public function edit(Tour $tour)
    {
        $tour->load([
            'translations',
            'images',
            'options.translations',
            'options.schedules',
        ]);

        return view('admin.tours.edit', compact('tour'));
    }

    public function update(UpdateTourRequest $request, Tour $tour)
    {
        $data = $request->validated();

        if ($request->hasFile('cover_image')) {
            if ($tour->cover_image && Storage::disk('public')->exists($tour->cover_image)) {
                Storage::disk('public')->delete($tour->cover_image);
            }

            $tour->cover_image = $request->file('cover_image')->store('tours/covers', 'public');
        }

        DB::transaction(function () use ($data, $request, $tour) {
            $tour->update([
                'cover_image' => $tour->cover_image,
                'max_capacity' => $data['max_capacity'],
                'featured_home' => $request->boolean('featured_home'),
                'available' => $request->boolean('available'),
            ]);

            $tour->translations()->where('locale', 'pt')->update([
                'name' => $data['pt_name'],
                'short_description' => $data['pt_short_description'],
                'full_description' => $data['pt_description'],
                'important_information' => $data['pt_information'],
            ]);

            $tour->translations()->where('locale', 'en')->update([
                'name' => $data['en_name'],
                'short_description' => $data['en_short_description'],
                'full_description' => $data['en_description'],
                'important_information' => $data['en_information'],
            ]);

            $options = $tour->options()->with(['schedules', 'translations'])->get();

            foreach ($options as $option) {
                $option->schedules()->delete();
            }

            foreach ($options as $option) {
                $option->translations()->delete();
            }

            $tour->options()->delete();

            foreach ($data['options'] as $optionIndex => $optionData) {
                $option = $tour->options()->create([
                    'duration_minutes' => $optionData['duration_minutes'],
                    'price' => $optionData['price'],
                    'display_order' => $optionIndex,
                ]);

                $option->translations()->createMany([
                    ['locale' => 'pt', 'name' => $optionData['translations']['pt']['name']],
                    ['locale' => 'en', 'name' => $optionData['translations']['en']['name']],
                ]);

                foreach ($optionData['schedules'] as $scheduleIndex => $scheduleData) {
                    $option->schedules()->create([
                        'start_time' => $scheduleData['start_time'],
                        'end_time' => $scheduleData['end_time'],
                        'display_order' => $scheduleIndex,
                    ]);
                }
            }
            
            if ($request->filled('gallery_delete')) {

                foreach ($request->gallery_delete as $imageId) {

                    $galleryImage = $tour->images()->find($imageId);

                    if (! $galleryImage) {
                        continue;
                    }

                    if (
                        $galleryImage->image &&
                        Storage::disk('public')->exists($galleryImage->image)
                    ) {
                        Storage::disk('public')->delete($galleryImage->image);
                    }

                    $galleryImage->delete();

                }

            }
            if ($request->hasFile('gallery_replace')) {
                foreach ($request->file('gallery_replace') as $imageId => $newImage) {
                    if (!$newImage) {
                        continue;
                    }

                    $galleryImage = $tour->images()->find($imageId);

                    if (!$galleryImage) {
                        continue;
                    }

                    if ($galleryImage->image && Storage::disk('public')->exists($galleryImage->image)) {
                        Storage::disk('public')->delete($galleryImage->image);
                    }

                    $galleryImage->update([
                        'image' => $newImage->store('tours/gallery', 'public'),
                    ]);
                }
            }

            if ($request->hasFile('gallery_images')) {
                $displayOrder = $tour->images()->count();

                foreach ($request->file('gallery_images') as $image) {
                    if (!$image) {
                        continue;
                    }

                    $tour->images()->create([
                        'image' => $image->store('tours/gallery', 'public'),
                        'display_order' => $displayOrder++,
                    ]);
                }
            }
        });

        return redirect()
            ->route('admin.tours.index')
            ->with('success', 'Passeio atualizado com sucesso.');
    }

    public function store(StoreTourRequest $request)
    {
        $data = $request->validated();

        $coverImage = null;
        if ($request->hasFile('cover_image')) {
            $coverImage = $request->file('cover_image')->store('tours/covers', 'public');
        }

        $galleryImagePaths = [];
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                if ($image) {
                    $galleryImagePaths[] = $image->store('tours/gallery', 'public');
                }
            }
        }

        $featuredHome = $request->boolean('featured_home');
        $available = $request->boolean('available');
        $displayOrder = (Tour::max('display_order') ?? -1) + 1;

        DB::transaction(function () use (
            $data,
            $coverImage,
            $galleryImagePaths,
            $featuredHome,
            $available,
            $displayOrder
        ) {
            $tour = Tour::create([
                'cover_image' => $coverImage,
                'max_capacity' => $data['max_capacity'],
                'featured_home' => $featuredHome,
                'available' => $available,
                'display_order' => $displayOrder,
            ]);

            $tour->translations()->createMany([
                [
                    'locale' => 'pt',
                    'name' => $data['pt_name'],
                    'short_description' => $data['pt_short_description'],
                    'full_description' => $data['pt_description'],
                    'important_information' => $data['pt_information'],
                ],
                [
                    'locale' => 'en',
                    'name' => $data['en_name'],
                    'short_description' => $data['en_short_description'],
                    'full_description' => $data['en_description'],
                    'important_information' => $data['en_information'],
                ],
            ]);

            foreach ($data['options'] as $optionIndex => $optionData) {
                $option = $tour->options()->create([
                    'duration_minutes' => $optionData['duration_minutes'],
                    'price' => $optionData['price'],
                    'display_order' => $optionIndex,
                ]);

                $option->translations()->createMany([
                    ['locale' => 'pt', 'name' => $optionData['translations']['pt']['name']],
                    ['locale' => 'en', 'name' => $optionData['translations']['en']['name']],
                ]);

                foreach ($optionData['schedules'] as $scheduleIndex => $scheduleData) {
                    $option->schedules()->create([
                        'start_time' => $scheduleData['start_time'],
                        'end_time' => $scheduleData['end_time'],
                        'display_order' => $scheduleIndex,
                    ]);
                }
            }

            foreach ($galleryImagePaths as $displayOrder => $imagePath) {
                $tour->images()->create([
                    'image' => $imagePath,
                    'display_order' => $displayOrder,
                ]);
            }
        });

        return redirect()
            ->route('admin.tours.index')
            ->with('success', 'Passeio criado com sucesso.');
    }
   public function move(Tour $tour)
    {
        $direction = request('direction');

        if ($direction === 'up') {

            $swap = Tour::where('display_order', '<', $tour->display_order)
                ->orderByDesc('display_order')
                ->first();

        } else {

            $swap = Tour::where('display_order', '>', $tour->display_order)
                ->orderBy('display_order')
                ->first();

        }

        if ($swap) {

            $currentOrder = $tour->display_order;

            $tour->update([
                'display_order' => $swap->display_order,
            ]);

            $swap->update([
                'display_order' => $currentOrder,
            ]);

        }

        return redirect()->route('admin.tours.index');
    }
    public function destroy(Tour $tour)
    {
        DB::transaction(function () use ($tour) {

            // Apagar imagem de capa
            if (
                $tour->cover_image &&
                Storage::disk('public')->exists($tour->cover_image)
            ) {
                Storage::disk('public')->delete($tour->cover_image);
            }

            // Apagar imagens da galeria
            foreach ($tour->images as $image) {

                if (
                    $image->image &&
                    Storage::disk('public')->exists($image->image)
                ) {
                    Storage::disk('public')->delete($image->image);
                }

            }

            // Eliminar o passeio
            $tour->delete();
            Tour::orderBy('display_order')
                ->get()
                ->each(function ($tour, $index) {

                    $tour->update([
                        'display_order' => $index,
                    ]);

                });

        });

        return redirect()
            ->route('admin.tours.index')
            ->with('success', 'Passeio eliminado com sucesso.');
    }
}
