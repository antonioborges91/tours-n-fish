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
            'cover_image' => 'nullable|image|max:2048',
            'max_capacity' => 'required|integer|min:1',
            'available' => 'nullable|boolean',
            'featured_home' => 'nullable|boolean',

            'pt_name' => 'required|string|max:255',
            'pt_short_description' => 'required|string',
            'pt_description' => 'required|string',
            'pt_information' => 'nullable|string',

            'en_name' => 'required|string|max:255',
            'en_short_description' => 'required|string',
            'en_description' => 'required|string',
            'en_information' => 'nullable|string',

            'options' => 'required|array|min:1',
            'options.*.translations' => 'required|array',
            'options.*.translations.pt' => 'required|array',
            'options.*.translations.pt.name' => 'required|string|max:255',
            'options.*.translations.en' => 'required|array',
            'options.*.translations.en.name' => 'required|string|max:255',
            'options.*.duration_minutes' => 'required|integer|min:1',
            'options.*.price' => 'required|numeric|min:0',
            'options.*.schedules' => 'required|array|min:1',
            'options.*.schedules.*.start_time' => 'required|date_format:H:i',
            'options.*.schedules.*.end_time' => 'required|date_format:H:i',

            'gallery_images' => 'nullable|array|max:5',
            'gallery_images.*' => 'image|max:2048',
            'gallery_replace' => 'nullable|array',
            'gallery_replace.*' => 'nullable|image|max:2048',
        ];
    }
}
