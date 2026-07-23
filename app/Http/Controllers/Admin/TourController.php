<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTourRequest;
use App\Http\Requests\UpdateTourRequest;
use App\Models\Tour;
use App\Models\TourImage;
use App\Models\TourSchedule;
use App\Models\TourTranslation;
use Illuminate\Support\Facades\Storage;

class TourController extends Controller
{
    public function index()
    {
        $tours = Tour::with('translations')
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
            'schedules',
            'images',
        ]);

        return view('admin.tours.edit', compact('tour'));
    }

    public function update(UpdateTourRequest $request, Tour $tour)
    {
        $data = $request->validated();
         // Atualizar imagem de capa
        if ($request->hasFile('cover_image')) {

            // Apagar imagem antiga
            if ($tour->cover_image && Storage::disk('public')->exists($tour->cover_image)) {
                Storage::disk('public')->delete($tour->cover_image);
            }

            // Guardar nova imagem
            $tour->cover_image = $request
                ->file('cover_image')
                ->store('tours/covers', 'public');

}

        // Atualizar passeio
        $tour->pricing_model = $data['pricing_model'];
        $tour->price = $data['price'];
        $tour->duration = $data['duration'];
        $tour->max_capacity = $data['max_capacity'];
        $tour->featured_home = $request->boolean('featured_home');
        $tour->available = $request->boolean('available');

        $tour->save();

        // Atualizar tradução Português
        $tour->translations()
            ->where('locale', 'pt')
            ->update([
                'name'                  => $data['pt_name'],
                'short_description'     => $data['pt_short_description'],
                'full_description'      => $data['pt_description'],
                'important_information' => $data['pt_information'],
            ]);

        // Atualizar tradução Inglês
        $tour->translations()
            ->where('locale', 'en')
            ->update([
                'name'                  => $data['en_name'],
                'short_description'     => $data['en_short_description'],
                'full_description'      => $data['en_description'],
                'important_information' => $data['en_information'],
            ]);
        // Atualizar horários
        // Apagar todos os horários existentes
        $tour->schedules()->delete();

        // Criar novamente os horários enviados
        if (!empty($data['schedule_start'])) {

            foreach ($data['schedule_start'] as $index => $startTime) {

                if (
                    empty($startTime) ||
                    empty($data['schedule_end'][$index])
                ) {
                    continue;
                }

                TourSchedule::create([
                    'tour_id'       => $tour->id,
                    'start_time'    => $startTime,
                    'end_time'      => $data['schedule_end'][$index],
                    'display_order' => $index,
                ]);
            }
        }
        // Adicionar novas imagens à galeria
        if ($request->hasFile('gallery_images')) {

            $displayOrder = $tour->images()->count();

            foreach ($request->file('gallery_images') as $image) {

                if (!$image) {
                    continue;
                }

                $imagePath = $image->store('tours/gallery', 'public');

                TourImage::create([
                    'tour_id'       => $tour->id,
                    'image'         => $imagePath,
                    'display_order' => $displayOrder++,
                ]);
            }
        }
        return redirect()
            ->route('admin.tours.index')
            ->with('success', 'Passeio atualizado com sucesso.');
    }

    public function store(StoreTourRequest $request)
    {
        $data = $request->validated();

        // Upload da imagem de capa
        $coverImage = $request
            ->file('cover_image')
            ->store('tours/covers', 'public');

        // Criar passeio
        $tour = Tour::create([
            'cover_image'   => $coverImage,
            'duration'      => $data['duration'],
            'pricing_model' => $data['pricing_model'],
            'price'         => $data['price'],
            'max_capacity'  => $data['max_capacity'],
            'featured_home' => $request->boolean('featured_home'),
            'available'     => $request->boolean('available'),
            'display_order' => 0,
        ]);

        // Tradução Português
        TourTranslation::create([
            'tour_id'               => $tour->id,
            'locale'                => 'pt',
            'name'                  => $data['pt_name'],
            'short_description'     => $data['pt_short_description'],
            'full_description'      => $data['pt_description'],
            'important_information' => $data['pt_information'],
        ]);

        // Tradução Inglês
        TourTranslation::create([
            'tour_id'               => $tour->id,
            'locale'                => 'en',
            'name'                  => $data['en_name'],
            'short_description'     => $data['en_short_description'],
            'full_description'      => $data['en_description'],
            'important_information' => $data['en_information'],
        ]);

        // Horários
        if (!empty($data['schedule_start'])) {

            foreach ($data['schedule_start'] as $index => $startTime) {

                if (
                    empty($startTime) ||
                    empty($data['schedule_end'][$index])
                ) {
                    continue;
                }

                TourSchedule::create([
                    'tour_id'       => $tour->id,
                    'start_time'    => $startTime,
                    'end_time'      => $data['schedule_end'][$index],
                    'display_order' => $index,
                ]);
            }
        }

        // Galeria
        if ($request->hasFile('gallery_images')) {

            foreach ($request->file('gallery_images') as $index => $image) {

                if (!$image) {
                    continue;
                }

                $imagePath = $image->store('tours/gallery', 'public');

                TourImage::create([
                    'tour_id'       => $tour->id,
                    'image'         => $imagePath,
                    'display_order' => $index,
                ]);
            }
        }

        return redirect()
            ->route('admin.tours.index')
            ->with('success', 'Passeio criado com sucesso.');
    }
}