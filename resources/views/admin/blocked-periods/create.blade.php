@extends('layouts.admin')

@section('content')

<div class="mb-8">

    <h1 class="text-3xl font-bold">
        Novo Período Bloqueado
    </h1>

    <p class="mt-1 text-gray-500">
        Indicar um período em que não será possível realizar passeios.
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
        action="{{ route('admin.blocked-periods.store') }}"
        method="POST">

        @csrf

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

            <div>

                <label
                    for="start_at"
                    class="mb-2 block text-sm font-semibold text-gray-900">

                    Início

                </label>

                <input
                    type="datetime-local"
                    name="start_at"
                    id="start_at"
                    value="{{ old('start_at') }}"
                    required
                    class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700">

            </div>

            <div>

                <label
                    for="end_at"
                    class="mb-2 block text-sm font-semibold text-gray-900">

                    Fim

                </label>

                <input
                    type="datetime-local"
                    name="end_at"
                    id="end_at"
                    value="{{ old('end_at') }}"
                    required
                    class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700">

            </div>

        </div>

        <div class="mt-6">

            <label
                for="reason"
                class="mb-2 block text-sm font-semibold text-gray-900">

                Motivo
                <span class="font-normal text-gray-500">
                    (opcional)
                </span>

            </label>

            <input
                type="text"
                name="reason"
                id="reason"
                value="{{ old('reason') }}"
                maxlength="255"
                placeholder="Ex.: Férias, manutenção do barco..."
                class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700">

        </div>

        <div class="mt-6 rounded-lg border border-blue-200 bg-blue-50 p-4">

            <p class="font-semibold text-blue-900">
                Como funciona
            </p>

            <p class="mt-2 text-sm text-blue-800">
                Pode bloquear um dia inteiro ou apenas algumas horas.
                Basta indicar a data e hora de início e de fim.
            </p>

            <div class="mt-3 space-y-1 text-sm text-blue-800">

                <p>
                    <strong>Dia inteiro:</strong>
                    25/08/2026 00:00 → 26/08/2026 00:00
                </p>

                <p>
                    <strong>Apenas tarde:</strong>
                    25/08/2026 13:00 → 25/08/2026 18:00
                </p>

            </div>

        </div>

        <div class="mt-6 flex items-center gap-3">

            <button
                type="submit"
                class="admin-btn-primary">

                Guardar

            </button>

            <a
                href="{{ route('admin.blocked-periods.index') }}"
                class="admin-btn-secondary">

                Cancelar

            </a>

        </div>

    </form>

</div>

@endsection