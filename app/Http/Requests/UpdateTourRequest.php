<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTourRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            // Informações Gerais
            'cover_image' => 'nullable|image|max:4096',
            'pricing_model' => 'required|in:boat,person',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|string|max:255',
            'max_capacity' => 'required|integer|min:1',

            // Português
            'pt_name' => 'required|string|max:255',
            'pt_short_description' => 'required|string',
            'pt_description' => 'required|string',
            'pt_information' => 'required|string',

            // English
            'en_name' => 'required|string|max:255',
            'en_short_description' => 'required|string',
            'en_description' => 'required|string',
            'en_information' => 'required|string',

            // Horários
            'schedule_start' => 'nullable|array',
            'schedule_start.*' => 'nullable|date_format:H:i',

            'schedule_end' => 'nullable|array',
            'schedule_end.*' => 'nullable|date_format:H:i',

            // Galeria
            'gallery_images' => 'nullable|array|max:5',
            'gallery_images.*' => 'nullable|image|max:4096',

        ];
    }
}