@extends('layouts.admin')

@section('content')

<div class="admin-page admin-blocked-periods-page">

    <div class="admin-page-header">

        <div>
            <h1>Novo Período Bloqueado</h1>

            <p>
                Indicar um período em que não será possível realizar passeios.
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
            action="{{ route('admin.blocked-periods.store') }}"
            method="POST"
        >

            @csrf

            <div class="admin-blocked-form-grid">

                <div class="admin-blocked-form-field">

                    <label for="start_at">
                        Início
                    </label>

                    <input
                        type="datetime-local"
                        name="start_at"
                        id="start_at"
                        value="{{ old('start_at') }}"
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
                        value="{{ old('end_at') }}"
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
                    value="{{ old('reason') }}"
                    maxlength="255"
                    placeholder="Ex.: Férias, manutenção do barco..."
                >

            </div>

            <div class="admin-blocked-info">

                <p class="admin-blocked-info-title">
                    Como funciona
                </p>

                <p class="admin-blocked-info-text">
                    Pode bloquear um dia inteiro ou apenas algumas horas.
                    Basta indicar a data e hora de início e de fim.
                </p>

                <div class="admin-blocked-info-examples">

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

            <div class="admin-blocked-form-actions">

                <button
                    type="submit"
                    class="admin-btn-primary"
                >
                    Guardar
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