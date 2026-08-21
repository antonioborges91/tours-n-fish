@extends('layouts.admin')

@section('content')

<div class="mb-8">

    <h1 class="text-3xl font-bold">
        Editar Período Bloqueado
    </h1>

    <p class="mt-1 text-gray-500">
        Alterar as datas, horas ou motivo deste período bloqueado.
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
        action="{{ route('admin.blocked-periods.update', $blockedPeriod) }}"
        method="POST">

        @csrf
        @method('PUT')

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
                    value="{{ old('start_at', $blockedPeriod->start_at->format('Y-m-d\TH:i')) }}"
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
                    value="{{ old('end_at', $blockedPeriod->end_at->format('Y-m-d\TH:i')) }}"
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
                value="{{ old('reason', $blockedPeriod->reason) }}"
                maxlength="255"
                placeholder="Ex.: Férias, manutenção do barco..."
                class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700">

        </div>

        <div class="mt-6 rounded-lg border border-blue-200 bg-blue-50 p-4">

            <p class="font-semibold text-blue-900">
                Informação
            </p>

            <p class="mt-2 text-sm text-blue-800">
                O período pode corresponder a um dia inteiro ou apenas
                a determinadas horas. O fim deve ser posterior ao início.
            </p>

        </div>

        <div class="mt-6 flex items-center gap-3">

            <button
                type="submit"
                class="admin-btn-primary">

                Guardar Alterações

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