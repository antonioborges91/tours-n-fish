@extends('layouts.admin')

@section('content')

<div class="max-w-3xl">

    <div class="mb-8">

        <h1 class="text-3xl font-bold">
            Editar Fotografia
        </h1>

        <p class="mt-1 text-gray-500">
            Atualizar a fotografia da galeria.
        </p>

    </div>

    @if ($errors->any())

        <div class="mb-6 rounded-lg border border-red-300 bg-red-50 p-4 text-red-700">

            <ul class="list-disc pl-5 space-y-1">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">

        <form
            action="{{ route('admin.gallery.update', $gallery) }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="mb-6">

                <label
                    class="mb-3 block text-sm font-semibold text-gray-900">

                    Fotografia atual

                </label>

                <div class="mb-6">

                    <img
                        src="{{ asset('storage/' . $gallery->image) }}"
                        alt="Fotografia da galeria"
                        class="h-64 w-auto max-w-full rounded-xl border border-gray-200 object-contain">

                </div>

                <label
                    for="image"
                    class="mb-2 block text-sm font-semibold text-gray-900">

                    Substituir fotografia

                </label>

                <input
                    type="file"
                    name="image"
                    id="image"
                    accept="image/jpeg,image/png,image/webp"
                    class="block w-full rounded-lg border border-gray-300 bg-white text-sm text-gray-700
                           file:mr-4 file:rounded-lg file:border-0
                           file:bg-gray-100 file:px-4 file:py-2
                           file:text-sm file:font-medium
                           hover:file:bg-gray-200">

                <p class="mt-2 text-sm text-gray-500">
                    Deixe vazio para manter a fotografia atual.
                </p>

                <div class="mt-4 rounded-lg border border-blue-200 bg-blue-50 p-4">

                    <p class="font-semibold text-blue-900">
                        Recomendações para a fotografia
                    </p>

                    <ul class="mt-2 space-y-1 text-sm text-blue-800">

                        <li>
                            • Horizontal: <strong>3:2</strong>
                        </li>

                        <li>
                            • Vertical: <strong>2:3</strong> ou <strong>4:5</strong>
                        </li>

                        <li>
                            • Recomendado: <strong>1800 px ou mais no lado maior</strong>
                        </li>

                        <li>
                            • Mínimo indicado: <strong>1200 px no lado maior</strong>
                        </li>

                        <li>
                            • Tamanho máximo do ficheiro: <strong>5 MB</strong>
                        </li>

                    </ul>

                    <p class="mt-3 text-xs text-blue-700">
                        A fotografia pode ser horizontal ou vertical.
                        A proporção original será preservada na galeria.
                    </p>

                </div>

                <div
                    id="image-info"
                    class="mt-4 hidden rounded-lg border border-gray-200 bg-gray-50 p-4">

                    <p class="text-sm font-semibold text-gray-900">
                        Informação da nova imagem
                    </p>

                    <div
                        id="image-details"
                        class="mt-2 text-sm text-gray-600">
                    </div>

                </div>

            </div>

            <div class="mb-6">

                <label class="flex items-center gap-3">

                    <input
                        type="checkbox"
                        name="is_active"
                        value="1"
                        @checked($gallery->is_active)
                        class="h-4 w-4 rounded border-gray-300">

                    <span class="text-sm font-medium text-gray-900">
                        Ativa
                    </span>

                </label>

                <p class="mt-1 ml-7 text-sm text-gray-500">
                    Apenas fotografias ativas serão mostradas na galeria pública.
                </p>

            </div>

            <div class="flex items-center gap-3">

                <button
                    type="submit"
                    class="admin-btn-primary">

                    Guardar

                </button>

                <a
                    href="{{ route('admin.gallery.index') }}"
                    class="admin-btn-secondary">

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

        info.classList.add('hidden');
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

        info.classList.remove('hidden');

    };

    image.src = URL.createObjectURL(file);

});

</script>

@endsection