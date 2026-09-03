@extends('layouts.admin')

@section('content')

<div class="admin-page admin-gallery-page">

    <div class="admin-page-header">

        <div>
            <h1>Nova Fotografia</h1>

            <p>
                Adicionar uma fotografia à galeria.
            </p>
        </div>

    </div>

    @if ($errors->any())

        <div class="admin-gallery-error">

            <ul>

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <div class="admin-gallery-form-card">

        <form
            action="{{ route('admin.gallery.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf

            <div class="admin-gallery-form-section">

                <div class="admin-gallery-form-field">

                    <label for="image">
                        Fotografia
                    </label>

                    <input
                        type="file"
                        name="image"
                        id="image"
                        accept="image/jpeg,image/png,image/webp"
                        required
                    >

                </div>

                <div class="admin-gallery-info">

                    <p class="admin-gallery-info-title">
                        Recomendações para a fotografia
                    </p>

                    <ul class="admin-gallery-info-list">

                        <li>
                            Horizontal: <strong>3:2</strong>
                        </li>

                        <li>
                            Vertical: <strong>2:3</strong> ou <strong>4:5</strong>
                        </li>

                        <li>
                            Recomendado: <strong>1800 px ou mais no lado maior</strong>
                        </li>

                        <li>
                            Mínimo indicado: <strong>1200 px no lado maior</strong>
                        </li>

                        <li>
                            Tamanho máximo do ficheiro: <strong>5 MB</strong>
                        </li>

                    </ul>

                    <p class="admin-gallery-info-description">
                        A fotografia pode ser horizontal ou vertical.
                        A proporção original será preservada na galeria.
                    </p>

                </div>

                <div
                    id="image-info"
                    class="admin-gallery-image-info is-hidden"
                >

                    <p class="admin-gallery-image-info-title">
                        Informação da imagem
                    </p>

                    <div
                        id="image-details"
                        class="admin-gallery-image-details"
                    ></div>

                </div>

            </div>

            <div class="admin-gallery-active-field">

                <label class="admin-gallery-checkbox-label">

                    <input
                        type="checkbox"
                        name="is_active"
                        value="1"
                        checked
                    >

                    <span>
                        Ativa
                    </span>

                </label>

                <p>
                    Apenas fotografias ativas serão mostradas na galeria pública.
                </p>

            </div>

            <div class="admin-gallery-form-actions">

                <button
                    type="submit"
                    class="admin-btn-primary"
                >
                    Guardar
                </button>

                <a
                    href="{{ route('admin.gallery.index') }}"
                    class="admin-btn-secondary"
                >
                    Cancelar
                </a>

            </div>

        </form>

    </div>

</div>

<script>

document.getElementById('image').addEventListener('change', function (event) {

    const file = event.target.files[0];

    const info = document.getElementById('image-info');
    const details = document.getElementById('image-details');

    if (!file) {

        info.classList.add('is-hidden');
        details.innerHTML = '';

        return;
    }

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
        const shortSide = Math.min(width, height);

        const ratio = width / height;

        let ratioText = '';

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

        if (longSide < 1200) {

            messages.push(
                '<span class="font-semibold text-amber-600">⚠ Resolução abaixo do mínimo indicado (1200 px no lado maior).</span>'
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

        details.innerHTML =
            '<div class="space-y-1">' +
                '<div><strong>Dimensões:</strong> ' +
                    width + ' × ' + height + ' px' +
                '</div>' +

                '<div><strong>Orientação:</strong> ' +
                    ratioText +
                '</div>' +

                '<div><strong>Tamanho:</strong> ' +
                    (file.size / 1024 / 1024).toFixed(2) + ' MB' +
                '</div>' +

                '<div class="pt-1">' +
                    messages.join('<br>') +
                '</div>' +
            '</div>';

        info.classList.remove('is-hidden');

    };

    image.src = URL.createObjectURL(file);

});

</script>

@endsection