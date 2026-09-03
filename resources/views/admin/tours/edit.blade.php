@extends('layouts.admin')

@section('content')

@php
    $pt = $tour->translations->firstWhere('locale', 'pt');
    $en = $tour->translations->firstWhere('locale', 'en');
@endphp

<div class="admin-page admin-tours-page">

    <div class="admin-page-header">

        <div>
            <h1>Editar Passeio</h1>

            <p>
                Editar informações do passeio.
            </p>
        </div>

        <a
            href="{{ route('admin.tours.index') }}"
            class="admin-btn-secondary"
        >
            ← Voltar
        </a>

    </div>


    <form
        id="tour-form"
        action="{{ route('admin.tours.update', $tour) }}"
        method="POST"
        enctype="multipart/form-data"
    >

        @csrf
        @method('PUT')


        {{-- ERROS --}}

        @if ($errors->any())

            <div class="admin-alert admin-alert-error">

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>

        @endif


        {{-- ========================================================= --}}
        {{-- INFORMAÇÕES GERAIS --}}
        {{-- ========================================================= --}}

        <div class="admin-tours-form-card">

            <div class="admin-tours-section-header">
                <div>
                    <h2>Informações Gerais</h2>
                </div>
            </div>


            <div class="admin-tours-form-fields">


                {{-- CAPA --}}

                <div class="admin-tours-form-field-full">

                    <label class="admin-tours-form-label">
                        Imagem de Capa Atual
                    </label>


                    @if ($tour->cover_image)

                        <img
                            src="{{ asset('storage/' . $tour->cover_image) }}"
                            alt="Imagem de Capa"
                            class="admin-tours-current-cover"
                        >

                    @endif


                    <label
                        for="cover_image"
                        class="admin-tours-form-label"
                    >
                        Nova Imagem de Capa
                    </label>


                    <input
                        type="file"
                        name="cover_image"
                        id="cover_image"
                        class="admin-tours-file-input"
                        accept="image/jpeg,image/png,image/webp"
                    >


                    <p class="admin-tours-form-help">
                        Deixe vazio para manter a imagem atual.
                    </p>


                    <div class="admin-tours-recommendations">

                        <p class="admin-tours-recommendations-title">
                            Recomendações para a imagem de capa
                        </p>

                        <ul class="admin-tours-recommendations-list">

                            <li>
                                • Proporção recomendada:
                                <strong>3:2 horizontal</strong>
                            </li>

                            <li>
                                • Resolução recomendada:
                                <strong>1800 × 1200 px ou superior</strong>
                            </li>

                            <li>
                                • Mínimo indicado:
                                <strong>1200 × 800 px</strong>
                            </li>

                            <li>
                                • Tamanho máximo do ficheiro:
                                <strong>5 MB</strong>
                            </li>

                        </ul>

                        <p class="admin-tours-recommendations-note">
                            Esta imagem é utilizada como capa do passeio
                            na Home, na página de Passeios e na página
                            de detalhe do passeio.
                        </p>

                    </div>


                    <div
                        id="cover-image-info"
                        class="admin-tours-image-info hidden"
                    >

                        <p class="admin-tours-image-info-title">
                            Informação da nova imagem
                        </p>

                        <div
                            id="cover-image-details"
                            class="admin-tours-image-info-details"
                        ></div>

                    </div>

                </div>


                {{-- CAPACIDADE --}}

                <div class="admin-tours-form-grid">

                    <div class="admin-tours-form-field">

                        <label class="admin-tours-form-label">
                            Capacidade Máxima
                        </label>

                        <input
                            type="number"
                            name="max_capacity"
                            value="{{ old('max_capacity', $tour->max_capacity) }}"
                            class="admin-tours-form-input"
                        >

                    </div>

                </div>


                {{-- ESTADOS --}}

                <div class="admin-tours-checkbox-options">

                    <label class="admin-tours-checkbox-option">

                        <input
                            type="checkbox"
                            name="available"
                            value="1"
                            @checked(old('available', $tour->available))
                            class="admin-tours-checkbox"
                        >

                        <span>Disponível</span>

                    </label>


                    <label class="admin-tours-checkbox-option">

                        <input
                            type="checkbox"
                            name="featured_home"
                            value="1"
                            @checked(old('featured_home', $tour->featured_home))
                            class="admin-tours-checkbox"
                        >

                        <span>Destacado na Home</span>

                    </label>

                </div>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- PORTUGUÊS --}}
        {{-- ========================================================= --}}

        <div class="admin-tours-form-card">

            <div class="admin-tours-section-header">
                <div>
                    <h2>Português</h2>
                </div>
            </div>


            <div class="admin-tours-form-fields">

                <div class="admin-tours-form-field-full">

                    <label class="admin-tours-form-label">
                        Nome
                    </label>

                    <input
                        type="text"
                        name="pt_name"
                        value="{{ old('pt_name', $pt?->name) }}"
                        class="admin-tours-form-input"
                    >

                </div>


                <div class="admin-tours-form-field-full">

                    <label class="admin-tours-form-label">
                        Descrição Curta
                    </label>

                    <textarea
                        name="pt_short_description"
                        rows="3"
                        class="admin-tours-form-input"
                    >{{ old('pt_short_description', $pt?->short_description) }}</textarea>

                </div>


                <div class="admin-tours-form-field-full">

                    <label class="admin-tours-form-label">
                        Descrição
                    </label>

                    <textarea
                        name="pt_description"
                        rows="6"
                        class="admin-tours-form-input"
                    >{{ old('pt_description', $pt?->full_description) }}</textarea>

                </div>


                <div class="admin-tours-form-field-full">

                    <label class="admin-tours-form-label">
                        Informações
                    </label>

                    <textarea
                        name="pt_information"
                        rows="6"
                        class="admin-tours-form-input"
                    >{{ old('pt_information', $pt?->important_information) }}</textarea>

                </div>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- ENGLISH --}}
        {{-- ========================================================= --}}

        <div class="admin-tours-form-card">

            <div class="admin-tours-section-header">
                <div>
                    <h2>English</h2>
                </div>
            </div>


            <div class="admin-tours-form-fields">

                <div class="admin-tours-form-field-full">

                    <label class="admin-tours-form-label">
                        Name
                    </label>

                    <input
                        type="text"
                        name="en_name"
                        value="{{ old('en_name', $en?->name) }}"
                        class="admin-tours-form-input"
                    >

                </div>


                <div class="admin-tours-form-field-full">

                    <label class="admin-tours-form-label">
                        Short Description
                    </label>

                    <textarea
                        name="en_short_description"
                        rows="3"
                        class="admin-tours-form-input"
                    >{{ old('en_short_description', $en?->short_description) }}</textarea>

                </div>


                <div class="admin-tours-form-field-full">

                    <label class="admin-tours-form-label">
                        Description
                    </label>

                    <textarea
                        name="en_description"
                        rows="6"
                        class="admin-tours-form-input"
                    >{{ old('en_description', $en?->full_description) }}</textarea>

                </div>


                <div class="admin-tours-form-field-full">

                    <label class="admin-tours-form-label">
                        Information
                    </label>

                    <textarea
                        name="en_information"
                        rows="6"
                        class="admin-tours-form-input"
                    >{{ old('en_information', $en?->important_information) }}</textarea>

                </div>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- OPÇÕES --}}
        {{-- ========================================================= --}}

        <div class="admin-tours-form-card">

            <div class="admin-tours-section-header">

                <div>
                    <h2>Opções</h2>

                    <p>
                        Cada passeio pode ter uma ou várias opções
                        (ex.: Meio Dia, Dia Inteiro...).
                    </p>
                </div>


                <div class="admin-tours-section-header-actions">

                    <button
                        type="button"
                        id="add-option"
                        class="admin-btn-primary"
                    >
                        + Adicionar Opção
                    </button>

                </div>

            </div>


            <div id="options-container">

                @forelse ($tour->options as $optionIndex => $option)

                    @php
                        $optionPt = $option->translations->firstWhere('locale', 'pt');
                        $optionEn = $option->translations->firstWhere('locale', 'en');
                    @endphp


                    <div
                        class="admin-tours-option-card"
                        data-option-index="{{ $optionIndex }}"
                    >

                        <div class="admin-tours-option-header">

                            <h3>
                                Opção {{ $optionIndex + 1 }}
                            </h3>


                            <button
                                type="button"
                                class="remove-option admin-btn-secondary"
                            >
                                Remover
                            </button>

                        </div>


                        <div class="admin-tours-form-grid">


                            <div class="admin-tours-form-field">

                                <label class="admin-tours-form-label">
                                    Nome (PT)
                                </label>

                                <input
                                    type="text"
                                    name="options[{{ $optionIndex }}][translations][pt][name]"
                                    value="{{ old("options.$optionIndex.translations.pt.name", $optionPt?->name) }}"
                                    class="admin-tours-form-input"
                                >

                            </div>


                            <div class="admin-tours-form-field">

                                <label class="admin-tours-form-label">
                                    Nome (EN)
                                </label>

                                <input
                                    type="text"
                                    name="options[{{ $optionIndex }}][translations][en][name]"
                                    value="{{ old("options.$optionIndex.translations.en.name", $optionEn?->name) }}"
                                    class="admin-tours-form-input"
                                >

                            </div>


                            <div class="admin-tours-form-field">

                                <label class="admin-tours-form-label">
                                    Duração (minutos)
                                </label>

                                <input
                                    type="number"
                                    min="1"
                                    name="options[{{ $optionIndex }}][duration_minutes]"
                                    value="{{ old("options.$optionIndex.duration_minutes", $option->duration_minutes) }}"
                                    class="admin-tours-form-input"
                                >

                            </div>


                            <div class="admin-tours-form-field">

                                <label class="admin-tours-form-label">
                                    Preço (€)
                                </label>

                                <input
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    name="options[{{ $optionIndex }}][price]"
                                    value="{{ old("options.$optionIndex.price", $option->price) }}"
                                    class="admin-tours-form-input"
                                >

                            </div>

                        </div>


                        <div class="admin-tours-option-divider"></div>


                        <div class="admin-tours-schedule-header">

                            <h4>Horários</h4>

                            <button
                                type="button"
                                class="add-option-schedule admin-btn-primary"
                            >
                                + Horário
                            </button>

                        </div>


                        <div class="admin-tours-option-schedules">

                            @forelse ($option->schedules as $scheduleIndex => $schedule)

                                <div
                                    class="admin-tours-schedule-row"
                                    data-schedule-index="{{ $scheduleIndex }}"
                                >

                                    <div class="admin-tours-form-field">

                                        <label class="admin-tours-form-label">
                                            Hora Início
                                        </label>

                                        <input
                                            type="time"
                                            name="options[{{ $optionIndex }}][schedules][{{ $scheduleIndex }}][start_time]"
                                            value="{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}"
                                            class="admin-tours-form-input"
                                        >

                                    </div>


                                    <div class="admin-tours-form-field">

                                        <label class="admin-tours-form-label">
                                            Hora Fim
                                        </label>

                                        <input
                                            type="time"
                                            name="options[{{ $optionIndex }}][schedules][{{ $scheduleIndex }}][end_time]"
                                            value="{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}"
                                            class="admin-tours-form-input"
                                        >

                                    </div>


                                    <div class="admin-tours-schedule-action">

                                        <button
                                            type="button"
                                            class="admin-btn-danger remove-schedule"
                                        >
                                            Remover
                                        </button>

                                    </div>

                                </div>

                            @empty

                                <p class="admin-tours-empty-message no-option-schedules">
                                    Ainda não existem horários.
                                </p>

                            @endforelse

                        </div>

                    </div>

                @empty

                    <p
                        id="no-options"
                        class="admin-tours-empty-message"
                    >
                        Ainda não existem opções.
                    </p>

                @endforelse

            </div>


            {{-- TEMPLATE OPÇÃO --}}

            <template id="option-template">

                <div class="admin-tours-option-card">

                    <div class="admin-tours-option-header">

                        <h3>Opção</h3>

                        <button
                            type="button"
                            class="remove-option admin-btn-secondary"
                        >
                            Remover
                        </button>

                    </div>


                    <div class="admin-tours-form-grid">

                        <div class="admin-tours-form-field">

                            <label class="admin-tours-form-label">
                                Nome (PT)
                            </label>

                            <input
                                type="text"
                                data-name="pt_name"
                                class="admin-tours-form-input"
                            >

                        </div>


                        <div class="admin-tours-form-field">

                            <label class="admin-tours-form-label">
                                Nome (EN)
                            </label>

                            <input
                                type="text"
                                data-name="en_name"
                                class="admin-tours-form-input"
                            >

                        </div>


                        <div class="admin-tours-form-field">

                            <label class="admin-tours-form-label">
                                Duração (minutos)
                            </label>

                            <input
                                type="number"
                                min="1"
                                data-name="duration_minutes"
                                class="admin-tours-form-input"
                            >

                        </div>


                        <div class="admin-tours-form-field">

                            <label class="admin-tours-form-label">
                                Preço (€)
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                data-name="price"
                                class="admin-tours-form-input"
                            >

                        </div>

                    </div>


                    <div class="admin-tours-option-divider"></div>


                    <div class="admin-tours-schedule-header">

                        <h4>Horários</h4>

                        <button
                            type="button"
                            class="add-option-schedule admin-btn-primary"
                        >
                            + Horário
                        </button>

                    </div>


                    <div class="admin-tours-option-schedules">

                        <p class="admin-tours-empty-message no-option-schedules">
                            Ainda não existem horários.
                        </p>

                    </div>

                </div>

            </template>


            {{-- TEMPLATE HORÁRIO --}}

            <template id="schedule-template">

                <div class="admin-tours-schedule-row">

                    <div class="admin-tours-form-field">

                        <label class="admin-tours-form-label">
                            Hora Início
                        </label>

                        <input
                            type="time"
                            data-field="start_time"
                            class="admin-tours-form-input"
                        >

                    </div>


                    <div class="admin-tours-form-field">

                        <label class="admin-tours-form-label">
                            Hora Fim
                        </label>

                        <input
                            type="time"
                            data-field="end_time"
                            class="admin-tours-form-input"
                        >

                    </div>


                    <div class="admin-tours-schedule-action">

                        <button
                            type="button"
                            class="admin-btn-danger remove-schedule"
                        >
                            Remover
                        </button>

                    </div>

                </div>

            </template>

        </div>


        {{-- ========================================================= --}}
        {{-- GALERIA --}}
        {{-- ========================================================= --}}

        <div class="admin-tours-form-card">

            <div class="admin-tours-section-header">

                <div>

                    <h2>Galeria</h2>

                    <p>
                        Fotografias adicionais deste passeio.
                    </p>

                </div>


                <div class="admin-tours-section-header-actions">

                    <button
                        type="button"
                        id="add-image"
                        class="admin-btn-primary"
                    >
                        + Adicionar Imagem
                    </button>

                </div>

            </div>


            <div class="admin-tours-recommendations">

                <p class="admin-tours-recommendations-title">
                    Recomendações para as fotografias
                </p>


                <ul class="admin-tours-recommendations-list">

                    <li>
                        • Horizontal:
                        <strong>3:2</strong>
                    </li>

                    <li>
                        • Vertical:
                        <strong>2:3</strong> ou <strong>4:5</strong>
                    </li>

                    <li>
                        • Resolução recomendada:
                        <strong>1800 px ou mais no lado maior</strong>
                    </li>

                    <li>
                        • Mínimo indicado:
                        <strong>1200 px no lado maior</strong>
                    </li>

                    <li>
                        • Tamanho máximo:
                        <strong>5 MB por fotografia</strong>
                    </li>

                </ul>


                <p class="admin-tours-recommendations-note">

                    A galeria pode misturar fotografias horizontais
                    e verticais. A proporção original será preservada.

                </p>

            </div>


            <div id="gallery-container">

                @forelse ($tour->images as $image)

                    <div
                        class="admin-tours-gallery-row"
                        data-image-id="{{ $image->id }}"
                    >

                        <div class="admin-tours-gallery-preview">

                            <img
                                src="{{ asset('storage/' . $image->image) }}"
                                alt="Imagem da Galeria"
                                class="admin-tours-gallery-thumbnail"
                            >

                        </div>


                        <div class="admin-tours-gallery-field">

                            <label class="admin-tours-form-label">
                                Substituir Imagem
                            </label>


                            <input
                                type="file"
                                name="gallery_replace[{{ $image->id }}]"
                                class="admin-tours-file-input gallery-image-input"
                                accept="image/jpeg,image/png,image/webp"
                            >


                            <p class="admin-tours-form-help">
                                Deixe vazio para manter a imagem atual.
                            </p>


                            <div
                                class="gallery-image-info admin-tours-image-info hidden"
                            >

                                <p class="admin-tours-image-info-title">
                                    Informação da nova imagem
                                </p>


                                <div class="gallery-image-details admin-tours-image-info-details"></div>

                            </div>

                        </div>


                        <div class="admin-tours-gallery-action">

                            <button
                                type="button"
                                class="admin-btn-danger remove-image"
                            >
                                Remover
                            </button>

                        </div>

                    </div>

                @empty

                    <p
                        id="no-images"
                        class="admin-tours-empty-message"
                    >
                        Ainda não existem imagens.
                    </p>

                @endforelse

            </div>


            {{-- TEMPLATE NOVA IMAGEM --}}

            <template id="gallery-image-template">

                <div class="admin-tours-gallery-row">

                    <div class="admin-tours-gallery-field">

                        <label class="admin-tours-form-label">
                            Imagem
                        </label>


                        <input
                            type="file"
                            name="gallery_images[]"
                            class="admin-tours-file-input gallery-image-input"
                            accept="image/jpeg,image/png,image/webp"
                        >


                        <div
                            class="gallery-image-info admin-tours-image-info hidden"
                        >

                            <p class="admin-tours-image-info-title">
                                Informação da imagem
                            </p>


                            <div class="gallery-image-details admin-tours-image-info-details"></div>

                        </div>

                    </div>


                    <div class="admin-tours-gallery-action">

                        <button
                            type="button"
                            class="admin-btn-danger remove-image"
                        >
                            Remover
                        </button>

                    </div>

                </div>

            </template>

        </div>


        {{-- ========================================================= --}}
        {{-- BOTÕES --}}
        {{-- ========================================================= --}}

        <div class="admin-tours-form-actions">

            <a
                href="{{ route('admin.tours.index') }}"
                class="admin-btn-secondary"
            >
                Cancelar
            </a>


            <button
                type="submit"
                class="admin-btn-primary"
            >
                Guardar Alterações
            </button>

        </div>

    </form>

</div>


{{-- ============================================================= --}}
{{-- ANÁLISE DAS IMAGENS --}}
{{-- ============================================================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {


    function analyseImage(file, infoElement, detailsElement, type)
    {

        if (!file) {

            infoElement.classList.add('hidden');
            detailsElement.innerHTML = '';

            return;
        }


        const image = new Image();


        image.onload = function ()
        {

            const width = image.width;
            const height = image.height;

            const longSide = Math.max(width, height);

            const ratio = width / height;


            let ratioText = '';

            let ratioClass = 'text-green-600';


            /*
             * CAPA
             */

            if (type === 'cover') {

                if (Math.abs(ratio - 1.5) < 0.08) {

                    ratioText = '3:2 — recomendado';

                } else {

                    ratioText = 'Outro formato';
                    ratioClass = 'text-amber-600';

                }

            }


            /*
             * GALERIA
             */

            else {

                if (width >= height) {

                    if (Math.abs(ratio - 1.5) < 0.08) {

                        ratioText = '3:2 — recomendado';

                    } else {

                        ratioText = 'Horizontal';

                    }

                } else {

                    if (Math.abs(ratio - (2 / 3)) < 0.05) {

                        ratioText = '2:3 — recomendado';

                    } else if (Math.abs(ratio - 0.8) < 0.05) {

                        ratioText = '4:5 — recomendado';

                    } else {

                        ratioText = 'Vertical';

                    }

                }

            }


            /*
             * RESOLUÇÃO
             */

            let resolutionText = '';
            let resolutionClass = '';


            if (longSide < 1200) {

                resolutionText =
                    '⚠ Abaixo do mínimo indicado: 1200 px no lado maior.';

                resolutionClass = 'text-red-600 font-semibold';

            } else if (longSide < 1800) {

                resolutionText =
                    '⚠ Aceitável, mas recomendamos 1800 px ou mais no lado maior.';

                resolutionClass = 'text-amber-600';

            } else {

                resolutionText =
                    '✓ Resolução adequada.';

                resolutionClass = 'text-green-600';

            }


            /*
             * TAMANHO DO FICHEIRO
             */

            const sizeMb =
                file.size / 1024 / 1024;


            let sizeText = '';
            let sizeClass = '';


            if (sizeMb > 5) {

                sizeText =
                    '⚠ O ficheiro ultrapassa os 5 MB.';

                sizeClass =
                    'text-red-600 font-semibold';

            } else {

                sizeText =
                    '✓ Tamanho do ficheiro adequado.';

                sizeClass =
                    'text-green-600';

            }


            /*
             * RESULTADO
             */

            detailsElement.innerHTML = `

                <div class="space-y-1">

                    <div>
                        <strong>Dimensões:</strong>
                        ${width} × ${height} px
                    </div>

                    <div class="${ratioClass}">
                        <strong>Proporção:</strong>
                        ${ratioText}
                    </div>

                    <div class="${resolutionClass}">
                        ${resolutionText}
                    </div>

                    <div>
                        <strong>Tamanho:</strong>
                        ${sizeMb.toFixed(2)} MB
                    </div>

                    <div class="${sizeClass}">
                        ${sizeText}
                    </div>

                </div>

            `;


            infoElement.classList.remove('hidden');


            URL.revokeObjectURL(image.src);

        };


        image.src = URL.createObjectURL(file);

    }


    /*
     * ============================================================
     * IMAGEM DE CAPA
     * ============================================================
     */

    const coverInput =
        document.getElementById('cover_image');


    if (coverInput) {

        coverInput.addEventListener('change', function ()
        {

            const file = this.files[0];

            const info =
                document.getElementById('cover-image-info');

            const details =
                document.getElementById('cover-image-details');


            analyseImage(
                file,
                info,
                details,
                'cover'
            );

        });

    }


    /*
     * ============================================================
     * IMAGENS DA GALERIA
     * ============================================================
     */

    document.addEventListener('change', function (event)
    {

        if (
            !event.target.classList.contains(
                'gallery-image-input'
            )
        ) {

            return;

        }


        const input = event.target;

        const file = input.files[0];


        const row =
            input.closest('.admin-tours-gallery-row');


        if (!row) {
            return;
        }


        const info =
            row.querySelector('.gallery-image-info');


        const details =
            row.querySelector('.gallery-image-details');


        if (!info || !details) {
            return;
        }


        analyseImage(
            file,
            info,
            details,
            'gallery'
        );

    });


});

</script>


@endsection