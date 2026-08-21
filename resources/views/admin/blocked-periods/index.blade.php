@extends('layouts.admin')

@section('content')

<div class="flex items-end justify-between">

    <div>

        <h1 class="text-3xl font-bold">
            Períodos Bloqueados
        </h1>

        <p class="mt-1 text-gray-500">
            Gerir os dias e períodos em que não estão disponíveis passeios.
        </p>

    </div>

    <a
        href="{{ route('admin.blocked-periods.create') }}"
        class="admin-btn-primary">

        + Adicionar Período

    </a>

</div>

@if(session('success'))

    <div class="mb-6 mt-6 rounded-lg border border-green-300 bg-green-50 p-4 text-green-700">

        {{ session('success') }}

    </div>

@endif

<div class="mt-8 overflow-hidden rounded-xl border border-gray-200 bg-white">

    <table class="w-full">

        <thead class="bg-gray-100">

            <tr>

                <th class="p-4 text-left">
                    Início
                </th>

                <th class="p-4 text-left">
                    Fim
                </th>

                <th class="p-4 text-left">
                    Motivo
                </th>

                <th class="p-4 text-right">
                    Ações
                </th>

            </tr>

        </thead>

        <tbody>

        @forelse($blockedPeriods as $blockedPeriod)

            <tr class="border-t">

                <td class="p-4">

                    <div class="font-medium text-gray-900">

                        {{ $blockedPeriod->start_at->format('d/m/Y') }}

                    </div>

                    <div class="text-sm text-gray-500">

                        {{ $blockedPeriod->start_at->format('H:i') }}

                    </div>

                </td>

                <td class="p-4">

                    <div class="font-medium text-gray-900">

                        {{ $blockedPeriod->end_at->format('d/m/Y') }}

                    </div>

                    <div class="text-sm text-gray-500">

                        {{ $blockedPeriod->end_at->format('H:i') }}

                    </div>

                </td>

                <td class="p-4">

                    @if($blockedPeriod->reason)

                        {{ $blockedPeriod->reason }}

                    @else

                        <span class="text-gray-400">
                            Sem motivo indicado
                        </span>

                    @endif

                </td>

                <td class="p-4">

                    <div class="flex items-center justify-end gap-2">

                        <a
                            href="{{ route('admin.blocked-periods.edit', $blockedPeriod) }}"
                            class="admin-btn-secondary">

                            Editar

                        </a>

                        <form
                            action="{{ route('admin.blocked-periods.destroy', $blockedPeriod) }}"
                            method="POST"
                            onsubmit="return confirm('Tem a certeza que pretende eliminar este período bloqueado?');">

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="admin-btn-danger">

                                Eliminar

                            </button>

                        </form>

                    </div>

                </td>

            </tr>

        @empty

            <tr>

                <td
                    colspan="4"
                    class="py-12 text-center text-gray-500">

                    Ainda não existem períodos bloqueados.

                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

</div>

@endsection