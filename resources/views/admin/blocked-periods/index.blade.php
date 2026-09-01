@extends('layouts.admin')

@section('content')

<div class="admin-page admin-blocked-periods-page">

    <div class="admin-page-header">

        <div>
            <h1>Períodos Bloqueados</h1>

            <p>
                Gerir os dias e períodos em que não estão disponíveis passeios.
            </p>
        </div>

        <a
            href="{{ route('admin.blocked-periods.create') }}"
            class="admin-blocked-add-button"
        >
            + Adicionar Período
        </a>

    </div>

    @if(session('success'))

        <div class="admin-alert admin-alert-success">
            {{ session('success') }}
        </div>

    @endif

    <div class="admin-blocked-table-card">

        <div class="admin-blocked-table-wrap">

            <table class="admin-blocked-table">

                <thead>

                    <tr>
                        <th>Início</th>
                        <th>Fim</th>
                        <th>Motivo</th>
                        <th class="is-right">Ações</th>
                    </tr>

                </thead>

                <tbody>

                @forelse($blockedPeriods as $blockedPeriod)

                    <tr>

                        <td>

                            <div class="admin-blocked-date">
                                {{ $blockedPeriod->start_at->format('d/m/Y') }}
                            </div>

                            <div class="admin-blocked-time">
                                {{ $blockedPeriod->start_at->format('H:i') }}
                            </div>

                        </td>

                        <td>

                            <div class="admin-blocked-date">
                                {{ $blockedPeriod->end_at->format('d/m/Y') }}
                            </div>

                            <div class="admin-blocked-time">
                                {{ $blockedPeriod->end_at->format('H:i') }}
                            </div>

                        </td>

                        <td>

                            @if($blockedPeriod->reason)

                                <div class="admin-blocked-reason">
                                    {{ $blockedPeriod->reason }}
                                </div>

                            @else

                                <span class="admin-blocked-no-reason">
                                    Sem motivo indicado
                                </span>

                            @endif

                        </td>

                        <td class="is-right">

                            <div class="admin-blocked-actions">

                                <a
                                    href="{{ route('admin.blocked-periods.edit', $blockedPeriod) }}"
                                    class="admin-reservation-action"
                                >
                                    Editar
                                </a>

                                <form
                                    action="{{ route('admin.blocked-periods.destroy', $blockedPeriod) }}"
                                    method="POST"
                                    onsubmit="return confirm('Tem a certeza que pretende eliminar este período bloqueado?');"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="admin-reservation-action admin-reservation-action-delete"
                                    >
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
                            class="admin-blocked-empty"
                        >
                            Ainda não existem períodos bloqueados.
                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection