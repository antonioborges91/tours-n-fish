<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTourRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules.
     */
    public function rules(): array
    {
        return [

            // Informações Gerais
            'cover_image' => 'nullable|image|max:2048',

            'pricing_model' => 'required|in:boat,person',

            'price' => 'required|numeric|min:0',

            'duration' => 'required|string|max:100',

            'max_capacity' => 'required|integer|min:1',

            'available' => 'nullable|boolean',

            'featured_home' => 'nullable|boolean',

            // Português
            'pt_name' => 'required|string|max:255',

            'pt_short_description' => 'required|string',

            'pt_description' => 'required|string',

            'pt_information' => 'nullable|string',

            // English
            'en_name' => 'required|string|max:255',

            'en_short_description' => 'required|string',

            'en_description' => 'required|string',

            'en_information' => 'nullable|string',

            // Horários
            'schedule_start' => 'nullable|array',

            'schedule_start.*' => 'nullable|date_format:H:i',

            'schedule_end' => 'nullable|array',

            'schedule_end.*' => 'nullable|date_format:H:i',

            // Galeria
            'gallery_images' => 'nullable|array|max:5',

            'gallery_images.*' => 'image|max:2048',

        ];
    }
}