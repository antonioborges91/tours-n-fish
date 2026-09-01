@extends('layouts.admin')

@section('content')

<div class="admin-page admin-blocked-periods-page">

    <div class="admin-page-header">

        <div>
            <h1>Editar Período Bloqueado</h1>

            <p>
                Alterar as datas, horas ou motivo deste período bloqueado.
            </p>
        </div>

    </div>

    @if ($errors->any())

        <div class="admin-blocked-error">

            <ul>

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <div class="admin-blocked-form-card">

        <form
            action="{{ route('admin.blocked-periods.update', $blockedPeriod) }}"
            method="POST"
        >

            @csrf
            @method('PUT')

            <div class="admin-blocked-form-grid">

                <div class="admin-blocked-form-field">

                    <label for="start_at">
                        Início
                    </label>

                    <input
                        type="datetime-local"
                        name="start_at"
                        id="start_at"
                        value="{{ old('start_at', $blockedPeriod->start_at->format('Y-m-d\TH:i')) }}"
                        required
                    >

                </div>

                <div class="admin-blocked-form-field">

                    <label for="end_at">
                        Fim
                    </label>

                    <input
                        type="datetime-local"
                        name="end_at"
                        id="end_at"
                        value="{{ old('end_at', $blockedPeriod->end_at->format('Y-m-d\TH:i')) }}"
                        required
                    >

                </div>

            </div>

            <div class="admin-blocked-form-field admin-blocked-form-field-full">

                <label for="reason">
                    Motivo
                    <span>(opcional)</span>
                </label>

                <input
                    type="text"
                    name="reason"
                    id="reason"
                    value="{{ old('reason', $blockedPeriod->reason) }}"
                    maxlength="255"
                    placeholder="Ex.: Férias, manutenção do barco..."
                >

            </div>

            <div class="admin-blocked-info">

                <p class="admin-blocked-info-title">
                    Informação
                </p>

                <p class="admin-blocked-info-text">
                    O período pode corresponder a um dia inteiro ou apenas
                    a determinadas horas. O fim deve ser posterior ao início.
                </p>

            </div>

            <div class="admin-blocked-form-actions">

                <button
                    type="submit"
                    class="admin-btn-primary"
                >
                    Guardar Alterações
                </button>

                <a
                    href="{{ route('admin.blocked-periods.index') }}"
                    class="admin-btn-secondary"
                >
                    Cancelar
                </a>

            </div>

        </form>

    </div>

</div>

@endsection