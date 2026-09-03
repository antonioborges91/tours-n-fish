@extends('layouts.admin')

@section('content')

<div class="admin-page admin-tours-page">

    <div class="admin-page-header">

        <div>
            <h1>Novo Passeio</h1>

            <p>
                Criar um novo passeio.
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
        action="{{ route('admin.tours.store') }}"
        method="POST"
        enctype="multipart/form-data"
    >

        @csrf

        @if ($errors->any())

            <div class="admin-alert admin-alert-error">

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>

        @endif

        {{-- Informações Gerais --}}

        <div class="admin-tours-form-card">

            <div class="admin-tours-section-header">
                <h2>Informações Gerais</h2>
            </div>

            <div class="admin-tours-form-grid">

                <div class="admin-tours-form-field admin-tours-form-field-full">

                    <label
                        for="cover_image"
                        class="admin-tours-form-label"
                    >
                        Imagem de Capa
                    </label>

                    <input
                        type="file"
                        name="cover_image"
                        id="cover_image"
                        class="admin-tours-file-input"
                        accept="image/jpeg,image/png,image/webp"
                    >

                    <div class="admin-tours-recommendations">

                        <p class="admin-tours-recommendations-title">
                            Recomendações para a imagem de capa
                        </p>

                        <ul class="admin-tours-recommendations-list">

                            <li>
                                • Formato recomendado:
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
                            Esta imagem será utilizada como capa do passeio
                            na Home, na página de passeios e na página de detalhe.
                        </p>

                    </div>

                    <div
                        id="cover-image-info"
                        class="admin-tours-image-info hidden"
                    >

                        <p class="admin-tours-image-info-title">
                            Informação da imagem
                        </p>

                        <div
                            id="cover-image-details"
                            class="admin-tours-image-details"
                        ></div>

                    </div>

                </div>

                <div class="admin-tours-form-field">

                    <label
                        for="max_capacity"
                        class="admin-tours-form-label"
                    >
                        Capacidade Máxima
                    </label>

                    <input
                        type="number"
                        name="max_capacity"
                        id="max_capacity"
                        min="1"
                        value="{{ old('max_capacity') }}"
                        class="admin-tours-form-input"
                    >

                </div>

                <div class="admin-tours-form-field admin-tours-form-options">

                    <label class="admin-tours-checkbox-option">

                        <input
                            type="checkbox"
                            name="available"
                            value="1"
                            @checked(old('available'))
                            class="admin-tours-checkbox"
                        >

                        <span>Disponível</span>

                    </label>

                    <label class="admin-tours-checkbox-option">

                        <input
                            type="checkbox"
                            name="featured_home"
                            value="1"
                            @checked(old('featured_home'))
                            class="admin-tours-checkbox"
                        >

                        <span>Destacado na Home</span>

                    </label>

                </div>

            </div>

        </div>


        {{-- Português --}}

        <div class="admin-tours-form-card">

            <div class="admin-tours-section-header">
                <h2>Português</h2>
            </div>

            <div class="admin-tours-form-fields">

                <div class="admin-tours-form-field">

                    <label class="admin-tours-form-label">
                        Nome
                    </label>

                    <input
                        type="text"
                        name="pt_name"
                        value="{{ old('pt_name') }}"
                        class="admin-tours-form-input"
                    >

                </div>

                <div class="admin-tours-form-field">

                    <label class="admin-tours-form-label">
                        Descrição Curta
                    </label>

                    <textarea
                        name="pt_short_description"
                        rows="3"
                        class="admin-tours-form-input"
                    >{{ old('pt_short_description') }}</textarea>

                </div>

                <div class="admin-tours-form-field">

                    <label class="admin-tours-form-label">
                        Descrição
                    </label>

                    <textarea
                        name="pt_description"
                        rows="6"
                        class="admin-tours-form-input"
                    >{{ old('pt_description') }}</textarea>

                </div>

                <div class="admin-tours-form-field">

                    <label class="admin-tours-form-label">
                        Informações
                    </label>

                    <textarea
                        name="pt_information"
                        rows="6"
                        class="admin-tours-form-input"
                    >{{ old('pt_information') }}</textarea>

                </div>

            </div>

        </div>


        {{-- English --}}

        <div class="admin-tours-form-card">

            <div class="admin-tours-section-header">
                <h2>English</h2>
            </div>

            <div class="admin-tours-form-fields">

                <div class="admin-tours-form-field">

                    <label class="admin-tours-form-label">
                        Name
                    </label>

                    <input
                        type="text"
                        name="en_name"
                        value="{{ old('en_name') }}"
                        class="admin-tours-form-input"
                    >

                </div>

                <div class="admin-tours-form-field">

                    <label class="admin-tours-form-label">
                        Short Description
                    </label>

                    <textarea
                        name="en_short_description"
                        rows="3"
                        class="admin-tours-form-input"
                    >{{ old('en_short_description') }}</textarea>

                </div>

                <div class="admin-tours-form-field">

                    <label class="admin-tours-form-label">
                        Description
                    </label>

                    <textarea
                        name="en_description"
                        rows="6"
                        class="admin-tours-form-input"
                    >{{ old('en_description') }}</textarea>

                </div>

                <div class="admin-tours-form-field">

                    <label class="admin-tours-form-label">
                        Information
                    </label>

                    <textarea
                        name="en_information"
                        rows="6"
                        class="admin-tours-form-input"
                    >{{ old('en_information') }}</textarea>

                </div>

            </div>

        </div>


        {{-- Opções --}}

        <div class="admin-tours-form-card">

            <div class="admin-tours-section-header admin-tours-section-header-actions">

                <div>
                    <h2>Opções</h2>

                    <p>
                        Cada passeio pode ter uma ou várias opções
                        (ex.: Meio Dia, Dia Inteiro...).
                    </p>
                </div>

                <button
                    type="button"
                    id="add-option"
                    class="admin-btn-primary"
                >
                    + Adicionar Opção
                </button>

            </div>

            <div id="options-container">

                <p
                    id="no-options"
                    class="admin-tours-empty-message"
                >
                    Ainda não existem opções.
                </p>

            </div>

        </div>


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

                <div class="admin-tours-divider"></div>

                <div class="admin-tours-schedule-header">

                    <h4>Horários</h4>

                    <button
                        type="button"
                        class="add-option-schedule admin-btn-primary"
                    >
                        + Horário
                    </button>

                </div>

                <div class="option-schedules">

                    <p class="admin-tours-empty-message no-option-schedules">
                        Ainda não existem horários.
                    </p>

                </div>

            </div>

        </template>


        <template id="schedule-template">

            <div class="schedule-row admin-tours-schedule-row">

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

                <div class="admin-tours-schedule-remove">

                    <button
                        type="button"
                        class="admin-btn-danger remove-schedule"
                    >
                        Remover
                    </button>

                </div>

            </div>

        </template>


        {{-- Galeria --}}

        <div class="admin-tours-form-card">

            <div class="admin-tours-section-header admin-tours-section-header-actions">

                <div>
                    <h2>Galeria</h2>

                    <p>
                        Fotografias adicionais deste passeio.
                    </p>
                </div>

                <button
                    type="button"
                    id="add-image"
                    class="admin-btn-primary"
                >
                    + Adicionar Imagem
                </button>

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
                    As fotografias podem ser horizontais ou verticais.
                    A proporção original será preservada na galeria.
                </p>

            </div>

            <div id="gallery-container">

                <p
                    id="no-images"
                    class="admin-tours-empty-message"
                >
                    Ainda não existem imagens.
                </p>

            </div>

        </div>


        <template id="gallery-image-template">

            <div class="gallery-row admin-tours-gallery-row">

                <div>

                    <label class="admin-tours-form-label">
                        Imagem
                    </label>

                    <input
                        type="file"
                        name="gallery_images[]"
                        class="admin-tours-file-input gallery-image-input"
                        accept="image/jpeg,image/png,image/webp"
                    >

                    <div class="gallery-image-info admin-tours-image-info hidden">

                        <div class="gallery-image-details admin-tours-image-details"></div>

                    </div>

                </div>

                <button
                    type="button"
                    class="admin-btn-danger remove-image"
                >
                    Remover
                </button>

            </div>

        </template>


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
                Guardar Passeio
            </button>

        </div>

    </form>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | Validação visual da imagem de capa
    |--------------------------------------------------------------------------
    */

    const coverInput = document.getElementById('cover_image');
    const coverInfo = document.getElementById('cover-image-info');
    const coverDetails = document.getElementById('cover-image-details');

    if (coverInput) {

        coverInput.addEventListener('change', function () {

            const file = this.files[0];

            if (!file) {

                coverInfo.classList.add('hidden');
                coverDetails.innerHTML = '';

                return;
            }

            analyseImage(
                file,
                coverInfo,
                coverDetails,
                true
            );

        });

    }


    /*
    |--------------------------------------------------------------------------
    | Adicionar imagens da galeria
    |--------------------------------------------------------------------------
    */

    const addImageButton = document.getElementById('add-image');
    const galleryContainer = document.getElementById('gallery-container');
    const galleryTemplate = document.getElementById('gallery-image-template');
    const noImages = document.getElementById('no-images');

    if (addImageButton) {

        addImageButton.addEventListener('click', function () {

            if (noImages) {
                noImages.remove();
            }

            const clone = galleryTemplate.content.cloneNode(true);

            galleryContainer.appendChild(clone);

        });

    }


    /*
    |--------------------------------------------------------------------------
    | Analisar imagens da galeria
    |--------------------------------------------------------------------------
    */

    document.addEventListener('change', function (event) {

        if (!event.target.classList.contains('gallery-image-input')) {
            return;
        }

        const input = event.target;
        const file = input.files[0];

        const info = input.parentElement.querySelector('.gallery-image-info');
        const details = input.parentElement.querySelector('.gallery-image-details');

        if (!file) {

            info.classList.add('hidden');
            details.innerHTML = '';

            return;
        }

        analyseImage(
            file,
            info,
            details,
            false
        );

    });


    /*
    |--------------------------------------------------------------------------
    | Remover imagem da galeria
    |--------------------------------------------------------------------------
    */

    document.addEventListener('click', function (event) {

        const button = event.target.closest('.remove-image');

        if (!button) {
            return;
        }

        const row = button.closest('.gallery-row');

        if (row) {
            row.remove();
        }

        if (!galleryContainer.querySelector('.gallery-row')) {

            const emptyMessage = document.createElement('p');

            emptyMessage.id = 'no-images';

            emptyMessage.className = 'admin-tours-empty-message';

            emptyMessage.textContent = 'Ainda não existem imagens.';

            galleryContainer.appendChild(emptyMessage);

        }

    });


    /*
    |--------------------------------------------------------------------------
    | Função de análise das imagens
    |--------------------------------------------------------------------------
    */

    function analyseImage(file, infoElement, detailsElement, isCover) {

        const maxSize = 5 * 1024 * 1024;

        let messages = [];

        if (file.size > maxSize) {

            messages.push(
                '<span class="font-semibold text-red-600">⚠ O ficheiro ultrapassa os 5 MB.</span>'
            );

        }

        const image = new Image();

        image.onload = function () {

            const width = image.width;
            const height = image.height;

            const longSide = Math.max(width, height);

            const ratio = width / height;

            let ratioText = '';

            let ratioWarning = false;

            if (isCover) {

                const difference = Math.abs(ratio - 1.5);

                if (difference < 0.08) {

                    ratioText = '3:2 — recomendado';

                } else {

                    ratioText = 'Formato diferente de 3:2';

                    ratioWarning = true;

                }

            } else {

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

            if (ratioWarning) {

                messages.push(
                    '<span class="font-semibold text-amber-600">⚠ Para a capa recomendamos o formato 3:2 horizontal.</span>'
                );

            }

            if (longSide < 1200) {

                messages.push(
                    '<span class="font-semibold text-red-600">⚠ Resolução abaixo do mínimo indicado (1200 px no lado maior).</span>'
                );

            } else if (longSide < 1800) {

                messages.push(
                    '<span class="text-amber-600">⚠ A resolução funciona, mas recomendamos 1800 px ou mais no lado maior.</span>'
                );

            } else {

                messages.push(
                    '<span class="text-green-600">✓ Resolução adequada.</span>'
                );

            }

            detailsElement.innerHTML =

                '<div class="space-y-1">' +

                    '<div>' +
                        '<strong>Dimensões:</strong> ' +
                        width + ' × ' + height + ' px' +
                    '</div>' +

                    '<div>' +
                        '<strong>Orientação:</strong> ' +
                        ratioText +
                    '</div>' +

                    '<div>' +
                        '<strong>Tamanho:</strong> ' +
                        (file.size / 1024 / 1024).toFixed(2) +
                        ' MB' +
                    '</div>' +

                    '<div class="pt-1">' +
                        messages.join('<br>') +
                    '</div>' +

                '</div>';

            infoElement.classList.remove('hidden');

        };

        image.src = URL.createObjectURL(file);

    }

});

</script>

@endsection