@extends('layouts.admin')

@section('content')

<div class="flex items-center justify-between mb-8">

    <div>
        <h1 class="text-3xl font-bold">
            Novo Passeio
        </h1>

        <p class="mt-1 text-gray-500">
            Criar um novo passeio.
        </p>
    </div>

    <a href="{{ route('admin.tours.index') }}"
       class="admin-btn-secondary">
        ← Voltar
    </a>

</div>

<form action="{{ route('admin.tours.store') }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf
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
                    Imagem de Capa
                </label>

                <input
                    type="file"
                    name="cover_image"
                    class="form-input">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <label class="form-label">
                    Capacidade Máxima
                </label>

                <input
                    type="number"
                    name="max_capacity"
                    class="form-input">
            </div>

        </div>

            <div class="flex items-center gap-8">

                <label class="flex items-center gap-2">

                    <input
                        type="checkbox"
                        name="available"
                        value="1"
                        class="form-checkbox">

                    Disponível

                </label>

                <label class="flex items-center gap-2">

                    <input
                        type="checkbox"
                        name="featured_home"
                        value="1"
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
                    class="form-input">
            </div>

            <div>
                <label class="form-label">
                    Descrição Curta
                </label>

                <textarea
                    name="pt_short_description"
                    rows="3"
                    class="form-input"></textarea>
            </div>

            <div>
                <label class="form-label">
                    Descrição
                </label>

                <textarea
                    name="pt_description"
                    rows="6"
                    class="form-input"></textarea>
            </div>

            <div>
                <label class="form-label">
                    Informações
                </label>

                <textarea
                    name="pt_information"
                    rows="6"
                    class="form-input"></textarea>
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
                    class="form-input">
            </div>

            <div>
                <label class="form-label">
                    Short Description
                </label>

                <textarea
                    name="en_short_description"
                    rows="3"
                    class="form-input"></textarea>
            </div>

            <div>
                <label class="form-label">
                    Description
                </label>

                <textarea
                    name="en_description"
                    rows="6"
                    class="form-input"></textarea>
            </div>

            <div>
                <label class="form-label">
                    Information
                </label>

                <textarea
                    name="en_information"
                    rows="6"
                    class="form-input"></textarea>
            </div>

        </div>

    </div>

 {{-- Opções --}}
<div class="bg-white rounded-lg shadow p-8 mb-8">

    <div class="flex items-center justify-between mb-6">

        <div>

            <h2 class="text-xl font-semibold">
                Opções
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Cada passeio pode ter uma ou várias opções (ex.: Meio Dia, Dia Inteiro...).
            </p>

        </div>

        <button
            type="button"
            id="add-option"
            class="admin-btn-primary">

            + Adicionar Opção

        </button>

    </div>

    <div id="options-container">

        <p
            id="no-options"
            class="text-gray-500">

            Ainda não existem opções.

        </p>

    </div>
<template id="option-template">

    <div class="option-card border rounded-lg p-6 mb-6 bg-gray-50">

        <div class="flex items-center justify-between mb-6">

            <h3 class="text-lg font-semibold">
                Opção
            </h3>

            <button
                type="button"
                class="remove-option admin-btn-secondary">

                Remover

            </button>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

            <div>

                <label class="form-label">
                    Nome (PT)
                </label>

                <input
                    type="text"
                    data-name="pt_name"
                    class="form-input">

            </div>

            <div>

                <label class="form-label">
                    Nome (EN)
                </label>

                <input
                    type="text"
                    data-name="en_name"
                    class="form-input">

            </div>

            <div>

                <label class="form-label">
                    Duração (minutos)
                </label>

                <input
                    type="number"
                    min="1"
                    data-name="duration_minutes"
                    class="form-input">

            </div>

            <div>

                <label class="form-label">
                    Preço (€)
                </label>

                <input
                    type="number"
                    step="0.01"
                    min="0"
                    data-name="price"
                    class="form-input">

            </div>

        </div>

        <hr class="my-6">

        <div class="flex items-center justify-between mb-4">

            <h4 class="font-semibold">
                Horários
            </h4>

            <button
                type="button"
                class="add-option-schedule admin-btn-primary">

                + Horário

            </button>

        </div>

        <div class="option-schedules">

            <p class="text-gray-500 no-option-schedules">

                Ainda não existem horários.

            </p>

        </div>

    </div>

</template>

<template id="schedule-template">

    <div class="schedule-row grid grid-cols-12 gap-4 items-end mb-4">

        <div class="col-span-5">

            <label class="form-label">
                Hora Início
            </label>

            <input
                type="time"
                data-field="start_time"
                class="form-input">

        </div>

        <div class="col-span-5">

            <label class="form-label">
                Hora Fim
            </label>

            <input
                type="time"
                data-field="end_time"
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

</template>
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

            <p id="no-images" class="text-gray-500">
                Ainda não existem imagens.
            </p>

        </div>

        <template id="gallery-image-template">

            <div class="gallery-row flex items-end gap-4 mb-4">

                <div class="flex-1">

                    <label class="form-label">
                        Imagem
                    </label>

                    <input
                        type="file"
                        name="gallery[]"
                        class="form-input"
                        accept="image/*">

                </div>

                <button
                    type="button"
                    class="admin-btn-danger remove-image">

                    Remover

                </button>

            </div>

        </template>

    </div>

    <div class="flex justify-end gap-4">

        <a href="{{ route('admin.tours.index') }}"
           class="admin-btn-secondary">
            Cancelar
        </a>

        <button
            type="submit"
            class="admin-btn-primary">

            Guardar Passeio

        </button>

    </div>

</form>

@endsection
