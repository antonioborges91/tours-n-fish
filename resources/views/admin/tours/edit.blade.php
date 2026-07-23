@extends('layouts.admin')

@section('content')

@php
    $pt = $tour->translations->firstWhere('locale', 'pt');
    $en = $tour->translations->firstWhere('locale', 'en');
@endphp

<div class="flex items-center justify-between mb-8">

    <div>

        <h1 class="text-3xl font-bold">
            Editar Passeio
        </h1>

        <p class="mt-1 text-gray-500">
            Editar informações do passeio.
        </p>

    </div>

    <a href="{{ route('admin.tours.index') }}"
       class="admin-btn-secondary">

        ← Voltar

    </a>

</div>

<form
    action="{{ route('admin.tours.update', $tour) }}"
    method="POST"
    enctype="multipart/form-data">

    @csrf

    @method('PUT')

    @if ($errors->any())

        <div class="mb-6 rounded-lg border border-red-300 bg-red-50 p-4">

            <ul class="list-disc pl-5 text-red-700">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    {{-- Informações Gerais --}}
    <div class="bg-white rounded-lg shadow p-8 mb-8">

        <h2 class="text-xl font-semibold mb-6">
            Informações Gerais
        </h2>

        <div class="grid grid-cols-1 gap-6">

            <div>

                <label class="form-label">
                    Imagem de Capa Atual
                </label>

                @if ($tour->cover_image)

                    <img
                        src="{{ asset('storage/' . $tour->cover_image) }}"
                        alt="Imagem de Capa"
                        class="w-64 rounded-lg border mb-4">

                @endif

                <label class="form-label">
                    Nova Imagem de Capa
                </label>

                <input
                    type="file"
                    name="cover_image"
                    class="form-input">

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>

                    <label class="form-label">
                        Modelo de Preço
                    </label>

                    <select
                        name="pricing_model"
                        class="form-select">

                        <option
                            value="boat"
                            @selected(old('pricing_model', $tour->pricing_model) == 'boat')>
                            Barco
                        </option>

                        <option
                            value="person"
                            @selected(old('pricing_model', $tour->pricing_model) == 'person')>
                            Pessoa
                        </option>

                    </select>

                </div>

                <div>

                    <label class="form-label">
                        Preço (€)
                    </label>

                    <input
                        type="number"
                        name="price"
                        step="0.01"
                        value="{{ old('price', $tour->price) }}"
                        class="form-input">

                </div>

                <div>

                    <label class="form-label">
                        Duração
                    </label>

                    <input
                        type="text"
                        name="duration"
                        value="{{ old('duration', $tour->duration) }}"
                        class="form-input">

                </div>

                <div>

                    <label class="form-label">
                        Capacidade Máxima
                    </label>

                    <input
                        type="number"
                        name="max_capacity"
                        value="{{ old('max_capacity', $tour->max_capacity) }}"
                        class="form-input">

                </div>

            </div>

            <div class="flex items-center gap-8">

                <label class="flex items-center gap-2">

                    <input
                        type="checkbox"
                        name="available"
                        value="1"
                        @checked(old('available', $tour->available))
                        class="form-checkbox">

                    Disponível

                </label>

                <label class="flex items-center gap-2">

                    <input
                        type="checkbox"
                        name="featured_home"
                        value="1"
                        @checked(old('featured_home', $tour->featured_home))
                        class="form-checkbox">

                    Destacado na Home

                </label>

            </div>

        </div>

    </div>

    {{-- Português --}}
    <div class="bg-white rounded-lg shadow p-8 mb-8">

        <h2 class="text-xl font-semibold mb-6">
            Português
        </h2>

        <div class="space-y-6">

            <div>

                <label class="form-label">
                    Nome
                </label>

                <input
                    type="text"
                    name="pt_name"
                    value="{{ old('pt_name', $pt?->name) }}"
                    class="form-input">

            </div>

            <div>

                <label class="form-label">
                    Descrição Curta
                </label>

                <textarea
                    name="pt_short_description"
                    rows="3"
                    class="form-input">{{ old('pt_short_description', $pt?->short_description) }}</textarea>

            </div>

            <div>

                <label class="form-label">
                    Descrição
                </label>

                <textarea
                    name="pt_description"
                    rows="6"
                    class="form-input">{{ old('pt_description', $pt?->full_description) }}</textarea>

            </div>

            <div>

                <label class="form-label">
                    Informações
                </label>

                <textarea
                    name="pt_information"
                    rows="6"
                    class="form-input">{{ old('pt_information', $pt?->important_information) }}</textarea>

            </div>

        </div>

    </div>

    {{-- English --}}
    <div class="bg-white rounded-lg shadow p-8 mb-8">

        <h2 class="text-xl font-semibold mb-6">
            English
        </h2>

        <div class="space-y-6">

            <div>

                <label class="form-label">
                    Name
                </label>

                <input
                    type="text"
                    name="en_name"
                    value="{{ old('en_name', $en?->name) }}"
                    class="form-input">

            </div>

            <div>

                <label class="form-label">
                    Short Description
                </label>

                <textarea
                    name="en_short_description"
                    rows="3"
                    class="form-input">{{ old('en_short_description', $en?->short_description) }}</textarea>

            </div>

            <div>

                <label class="form-label">
                    Description
                </label>

                <textarea
                    name="en_description"
                    rows="6"
                    class="form-input">{{ old('en_description', $en?->full_description) }}</textarea>

            </div>

            <div>

                <label class="form-label">
                    Information
                </label>

                <textarea
                    name="en_information"
                    rows="6"
                    class="form-input">{{ old('en_information', $en?->important_information) }}</textarea>

            </div>

        </div>

    </div>

   {{-- Horários --}}
    <div class="bg-white rounded-lg shadow p-8 mb-8">

        <div class="flex items-center justify-between mb-6">

            <h2 class="text-xl font-semibold">
                Horários
            </h2>

            <button
                type="button"
                id="add-schedule"
                class="admin-btn-primary">

                + Adicionar Horário

            </button>

        </div>

        <div id="schedule-container">

            @forelse ($tour->schedules as $index => $schedule)

                <div class="grid grid-cols-12 gap-4 items-end mb-4">

                    <div class="col-span-5">

                        <label class="form-label">
                            Hora Início
                        </label>

                        <input
                            type="time"
                            name="schedule_start[]"
                            value="{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}"
                            class="form-input">

                    </div>

                    <div class="col-span-5">

                        <label class="form-label">
                            Hora Fim
                        </label>

                        <input
                            type="time"
                            name="schedule_end[]"
                            value="{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}"
                            class="form-input">

                    </div>

                    <div class="col-span-2">

                        <button
                            type="button"
                            class="admin-btn-danger remove-schedule">

                            Remover

                        </button>

                    </div>

                </div>

            @empty

                <p id="no-schedules" class="text-gray-500">
                    Ainda não existem horários.
                </p>

            @endforelse

        </div>

    </div>

    {{-- Galeria --}}
<div class="bg-white rounded-lg shadow p-8 mb-8">

    <div class="flex items-center justify-between mb-6">

        <h2 class="text-xl font-semibold">
            Galeria
        </h2>

        <button
            type="button"
            id="add-image"
            class="admin-btn-primary">

            + Adicionar Imagem

        </button>

    </div>

    <div id="gallery-container">

        @forelse ($tour->images as $image)

            <div class="gallery-row flex items-end gap-4 mb-4">

                <div>

                    <img
                        src="{{ asset('storage/' . $image->image) }}"
                        alt="Imagem da Galeria"
                        class="w-40 h-28 object-cover rounded-lg border">

                </div>

                <div class="flex-1">

                    <label class="form-label">
                        Substituir Imagem
                    </label>

                    <input
                        type="file"
                        name="gallery_replace[{{ $image->id }}]"
                        class="form-input"
                        accept="image/*">

                </div>

                <button
                    type="button"
                    class="admin-btn-danger remove-image">

                    Remover

                </button>

            </div>

        @empty

            <p id="no-images" class="text-gray-500">
                Ainda não existem imagens.
            </p>

        @endforelse

    </div>

</div>

<div class="flex justify-end gap-4">

    <a
        href="{{ route('admin.tours.index') }}"
        class="admin-btn-secondary">

        Cancelar

    </a>

    <button
        type="submit"
        class="admin-btn-primary">

        Guardar Alterações

    </button>

</div>

</form>

@endsection