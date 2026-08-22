<section class="tour-options" id="tour-reservation">

    <div class="container-custom">

        {{-- =====================================================
             CABEÇALHO
        ====================================================== --}}

        <div class="section-heading">
            <span class="section-badge">
                {{ __('tours.options.badge') }}
            </span>

            <h2 class="section-title">
                {{ __('tours.options.title') }}
            </h2>
        </div>


        @php
            $unavailableDates = collect($unavailableDates ?? [])
                ->map(
                    fn ($date) =>
                        \Carbon\Carbon::parse($date)->format('Y-m-d')
                )
                ->values()
                ->all();

            $reservationOptions = $tour->options
                ->map(function ($option) {

                    $translation = $option->translation();

                    return [
                        'id' => $option->id,

                        'name' =>
                            $translation?->name ?? '',

                        'price' =>
                            (float) $option->price,

                        'duration_minutes' =>
                            (int) $option->duration_minutes,

                        'schedules' =>
                            $option->schedules
                                ->map(function ($schedule) {

                                    return [
                                        'id' =>
                                            $schedule->id,

                                        'start_time' =>
                                            substr(
                                                $schedule->start_time,
                                                0,
                                                5
                                            ),

                                        'end_time' =>
                                            substr(
                                                $schedule->end_time,
                                                0,
                                                5
                                            ),
                                    ];

                                })
                                ->values()
                                ->all(),
                    ];

                })
                ->values()
                ->all();
        @endphp


        <div
            class="tour-reservation-selector"
            data-tour-id="{{ $tour->id }}"
            data-max-capacity="{{ $tour->max_capacity }}"
        >


            {{-- =================================================
                 ESTADO 1
                 ESCOLHA DA EXPERIÊNCIA
            ================================================== --}}

            <div
                class="tour-reservation-selection"
                id="tourReservationSelection"
            >

                {{-- =================================================
                     CALENDÁRIO
                ================================================== --}}

                <div class="tour-calendar-panel">

                    <div class="tour-calendar-header">

                        <button
                            type="button"
                            class="tour-calendar-nav"
                            id="tourCalendarPrev"
                            aria-label="Mês anterior"
                        >
                            ‹
                        </button>

                        <h3 id="tourCalendarMonth"></h3>

                        <button
                            type="button"
                            class="tour-calendar-nav"
                            id="tourCalendarNext"
                            aria-label="Mês seguinte"
                        >
                            ›
                        </button>

                    </div>


                    <div class="tour-calendar-weekdays">

                        <span>
                            {{ __('tours.options.calendar.mon') }}
                        </span>

                        <span>
                            {{ __('tours.options.calendar.tue') }}
                        </span>

                        <span>
                            {{ __('tours.options.calendar.wed') }}
                        </span>

                        <span>
                            {{ __('tours.options.calendar.thu') }}
                        </span>

                        <span>
                            {{ __('tours.options.calendar.fri') }}
                        </span>

                        <span>
                            {{ __('tours.options.calendar.sat') }}
                        </span>

                        <span>
                            {{ __('tours.options.calendar.sun') }}
                        </span>

                    </div>


                    <div
                        class="tour-calendar-grid"
                        id="tourCalendarGrid"
                    ></div>


                    <div class="tour-calendar-legend">

                        <span>
                            <i
                                class="tour-calendar-dot tour-calendar-dot-available"
                            ></i>

                            {{ __('tours.options.calendar.available') }}
                        </span>

                        <span>
                            <i
                                class="tour-calendar-dot tour-calendar-dot-unavailable"
                            ></i>

                            {{ __('tours.options.calendar.unavailable') }}
                        </span>

                    </div>

                </div>


                {{-- =================================================
                     CONFIGURAÇÃO DA RESERVA
                ================================================== --}}

                <div class="tour-reservation-options">

                    {{-- DATA ESCOLHIDA --}}

                    <div class="tour-reservation-selected-date">

                        <span class="tour-reservation-label">
                            {{ __('tours.options.calendar.selected_date') }}
                        </span>

                        <strong id="selectedDateLabel">
                            {{ __('tours.options.calendar.choose_date') }}
                        </strong>

                    </div>


                    {{-- =================================================
                         DURAÇÃO / OPÇÃO
                    ================================================== --}}

                    <div
                        class="tour-reservation-step"
                        id="tourDurationStep"
                        hidden
                    >

                        <h3>
                            {{ __('tours.options.duration.title') }}
                        </h3>


                        <div class="tour-duration-options">

                            @foreach($tour->options as $option)

                                @php
                                    $translation =
                                        $option->translation();

                                    $hours =
                                        intdiv(
                                            $option->duration_minutes,
                                            60
                                        );

                                    $minutes =
                                        $option->duration_minutes % 60;

                                    if ($minutes > 0) {

                                        $durationText =
                                            "{$hours} h {$minutes} min";

                                    } else {

                                        $durationText =
                                            "{$hours} h";

                                    }
                                @endphp


                                <label
                                    class="tour-duration-option"
                                >

                                    <input
                                        type="radio"
                                        name="tour_option_id"
                                        value="{{ $option->id }}"
                                    >

                                    <span class="tour-duration-card">

                                        <strong>
                                            {{ $translation?->name }}
                                        </strong>

                                        <small>
                                            {{ $durationText }}
                                        </small>

                                        <span class="tour-duration-price">
                                            €{{ number_format(
                                                $option->price,
                                                0,
                                                ',',
                                                '.'
                                            ) }}
                                        </span>

                                    </span>

                                </label>

                            @endforeach

                        </div>

                    </div>


                    {{-- =================================================
                         HORÁRIOS
                    ================================================== --}}

                    <div
                        class="tour-reservation-step"
                        id="tourScheduleStep"
                        hidden
                    >

                        <h3>
                            {{ __('tours.options.schedule.title') }}
                        </h3>


                        <div
                            class="tour-schedule-options"
                            id="tourScheduleOptions"
                        ></div>

                    </div>


                    {{-- =================================================
                         NÚMERO DE PESSOAS
                    ================================================== --}}

                    <div
                        class="tour-reservation-step"
                        id="tourPeopleStep"
                        hidden
                    >

                        <h3>
                            {{ __('tours.options.people.title') }}
                        </h3>


                        <div class="tour-people-control">

                            <button
                                type="button"
                                id="tourPeopleMinus"
                                aria-label="{{ __('tours.options.people.decrease') }}"
                            >
                                −
                            </button>

                            <span id="tourPeopleValue">
                                1
                            </span>

                            <button
                                type="button"
                                id="tourPeoplePlus"
                                aria-label="{{ __('tours.options.people.increase') }}"
                            >
                                +
                            </button>

                        </div>


                        <p class="tour-people-help">
                            {{ __('tours.options.people.maximum', [
                                'count' => $tour->max_capacity
                            ]) }}
                        </p>

                    </div>


                    {{-- =================================================
                         RESUMO DA ESCOLHA
                    ================================================== --}}

                    <div
                        class="tour-reservation-summary"
                        id="tourReservationSummary"
                        hidden
                    >

                        <div>

                            <span>
                                {{ __('tours.options.summary.total') }}
                            </span>

                            <strong id="tourReservationPrice">
                                €0
                            </strong>

                        </div>


                        <button
                            type="button"
                            class="btn btn-primary"
                            id="tourReservationContinue"
                        >
                            {{ __('tours.options.continue') }}
                        </button>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                 ESTADO 2
                 CONFIRMAÇÃO + DADOS DO CLIENTE
            ====================================================== --}}

            <div
                class="tour-reservation-confirmation"
                id="tourReservationConfirmation"
                hidden
            >

                {{-- =================================================
                     RESUMO
                ================================================== --}}

                <div class="tour-reservation-confirmation-summary">

                    <div class="tour-reservation-confirmation-header">

                        <span class="section-badge">
                            Reserva
                        </span>

                        <h3>
                            Confirme a sua reserva
                        </h3>

                        <p>
                            Verifique os dados do passeio antes de enviar
                            o seu pedido.
                        </p>

                    </div>


                    <div class="tour-reservation-confirmation-details">

                        <div class="tour-reservation-detail">

                            <span>
                                Passeio
                            </span>

                            <strong>
                                {{ $tour->translation()->name }}
                            </strong>

                        </div>


                        <div class="tour-reservation-detail">

                            <span>
                                Opção
                            </span>

                            <strong id="confirmationOption">
                                —
                            </strong>

                        </div>


                        <div class="tour-reservation-detail">

                            <span>
                                Data
                            </span>

                            <strong id="confirmationDate">
                                —
                            </strong>

                        </div>


                        <div class="tour-reservation-detail">

                            <span>
                                Horário
                            </span>

                            <strong id="confirmationSchedule">
                                —
                            </strong>

                        </div>


                        <div class="tour-reservation-detail">

                            <span>
                                Pessoas
                            </span>

                            <strong id="confirmationPeople">
                                —
                            </strong>

                        </div>

                    </div>


                    <div class="tour-reservation-confirmation-price">

                        <div>

                            <span>
                                Total do passeio
                            </span>

                            <strong id="confirmationTotal">
                                €0
                            </strong>

                        </div>


                        <div>

                            <span>
                                Sinal de 10%
                            </span>

                            <strong id="confirmationDeposit">
                                €0
                            </strong>

                        </div>

                    </div>


                    <button
                        type="button"
                        class="btn btn-secondary"
                        id="tourReservationBack"
                    >
                        ← Voltar e alterar a seleção
                    </button>

                </div>


                {{-- =================================================
                     FORMULÁRIO
                ================================================== --}}

                <div class="tour-reservation-confirmation-form">

                    <div class="tour-reservation-confirmation-header">

                        <h3>
                            Os seus dados
                        </h3>

                        <p>
                            Preencha os seus dados para solicitar a reserva.
                        </p>

                    </div>


                    <form
                        method="POST"
                        action="{{ route('reservations.store') }}"
                        id="tourReservationForm"
                    >

                        @csrf


                        {{-- =================================================
                             CAMPOS OCULTOS
                        ================================================== --}}

                        <input
                            type="hidden"
                            name="tour_option_id"
                            id="reservationTourOptionId"
                        >

                        <input
                            type="hidden"
                            name="tour_option_schedule_id"
                            id="reservationScheduleId"
                        >

                        <input
                            type="hidden"
                            name="booking_date"
                            id="reservationBookingDate"
                        >

                        <input
                            type="hidden"
                            name="participants"
                            id="reservationParticipants"
                        >


                        {{-- =================================================
                             NOME
                        ================================================== --}}

                        <div class="reservation-inline-field">

                            <label for="reservationCustomerName">
                                Nome
                            </label>

                            <input
                                type="text"
                                id="reservationCustomerName"
                                name="customer_name"
                                autocomplete="name"
                                required
                            >

                            <p
                                class="reservation-form-error"
                                data-error-for="customer_name"
                                hidden
                            ></p>

                        </div>


                        {{-- =================================================
                             EMAIL
                        ================================================== --}}

                        <div class="reservation-inline-field">

                            <label for="reservationCustomerEmail">
                                Email
                            </label>

                            <input
                                type="email"
                                id="reservationCustomerEmail"
                                name="customer_email"
                                autocomplete="email"
                                required
                            >

                            <p
                                class="reservation-form-error"
                                data-error-for="customer_email"
                                hidden
                            ></p>

                        </div>


                        {{-- =================================================
                             TELEFONE
                        ================================================== --}}

                        <div class="reservation-inline-field">

                            <label for="reservationCustomerPhone">
                                Telefone
                            </label>

                            <input
                                type="tel"
                                id="reservationCustomerPhone"
                                name="customer_phone"
                                autocomplete="tel"
                                required
                            >

                            <p
                                class="reservation-form-error"
                                data-error-for="customer_phone"
                                hidden
                            ></p>

                        </div>


                        {{-- =================================================
                             OBSERVAÇÕES
                        ================================================== --}}

                        <div class="reservation-inline-field">

                            <label for="reservationCustomerMessage">
                                Observações
                            </label>

                            <textarea
                                id="reservationCustomerMessage"
                                name="customer_message"
                                rows="4"
                                placeholder="Alguma informação que considere importante?"
                            ></textarea>

                            <p
                                class="reservation-form-error"
                                data-error-for="customer_message"
                                hidden
                            ></p>

                        </div>


                        {{-- =================================================
                             AVISO
                        ================================================== --}}

                        <div class="tour-reservation-confirmation-notice">

                            <strong>
                                Antes de enviar
                            </strong>

                            <p>
                                O envio deste formulário não confirma
                                imediatamente a reserva. O pedido ficará
                                sujeito à disponibilidade e à confirmação
                                do pagamento do sinal.
                            </p>

                        </div>


                        {{-- =================================================
                             ERRO GERAL
                        ================================================== --}}

                        <div
                            class="tour-reservation-form-error"
                            id="tourReservationFormError"
                            hidden
                        ></div>


                        {{-- =================================================
                             AÇÕES
                        ================================================== --}}

                        <div class="tour-reservation-confirmation-actions">

                            <button
                                type="submit"
                                class="btn btn-primary"
                                id="tourReservationSubmit"
                            >
                                Enviar pedido de reserva
                            </button>

                        </div>

                    </form>

                </div>

            </div>


            {{-- =====================================================
                 ESTADO 3
                 SUCESSO
            ====================================================== --}}

            <div
                class="tour-reservation-success"
                id="tourReservationSuccess"
                hidden
            >

                <div class="tour-reservation-success-content">

                    <span class="section-badge">
                        Reserva
                    </span>

                    <h3>
                        Pedido de reserva enviado
                    </h3>

                    <p>
                        Recebemos o seu pedido de reserva com sucesso.
                        Entraremos em contacto consigo com as instruções
                        para pagamento do sinal.
                    </p>

                </div>

            </div>

        </div>

    </div>

</section>


@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    const selector =
        document.querySelector(
            '.tour-reservation-selector'
        );

    if (!selector) {
        return;
    }


    /*
     * ============================================================
     * ELEMENTOS — SELEÇÃO
     * ============================================================
     */

    const selection =
        document.getElementById(
            'tourReservationSelection'
        );

    const confirmation =
        document.getElementById(
            'tourReservationConfirmation'
        );

    const success =
        document.getElementById(
            'tourReservationSuccess'
        );


    const calendarGrid =
        document.getElementById(
            'tourCalendarGrid'
        );

    const calendarMonth =
        document.getElementById(
            'tourCalendarMonth'
        );

    const previousButton =
        document.getElementById(
            'tourCalendarPrev'
        );

    const nextButton =
        document.getElementById(
            'tourCalendarNext'
        );

    const selectedDateLabel =
        document.getElementById(
            'selectedDateLabel'
        );

    const durationStep =
        document.getElementById(
            'tourDurationStep'
        );

    const scheduleStep =
        document.getElementById(
            'tourScheduleStep'
        );

    const peopleStep =
        document.getElementById(
            'tourPeopleStep'
        );

    const summary =
        document.getElementById(
            'tourReservationSummary'
        );

    const scheduleOptions =
        document.getElementById(
            'tourScheduleOptions'
        );

    const peopleValue =
        document.getElementById(
            'tourPeopleValue'
        );

    const peopleMinus =
        document.getElementById(
            'tourPeopleMinus'
        );

    const peoplePlus =
        document.getElementById(
            'tourPeoplePlus'
        );

    const reservationPrice =
        document.getElementById(
            'tourReservationPrice'
        );

    const continueButton =
        document.getElementById(
            'tourReservationContinue'
        );

    const backButton =
        document.getElementById(
            'tourReservationBack'
        );


    /*
     * ============================================================
     * ELEMENTOS — CONFIRMAÇÃO
     * ============================================================
     */

    const confirmationOption =
        document.getElementById(
            'confirmationOption'
        );

    const confirmationDate =
        document.getElementById(
            'confirmationDate'
        );

    const confirmationSchedule =
        document.getElementById(
            'confirmationSchedule'
        );

    const confirmationPeople =
        document.getElementById(
            'confirmationPeople'
        );

    const confirmationTotal =
        document.getElementById(
            'confirmationTotal'
        );

    const confirmationDeposit =
        document.getElementById(
            'confirmationDeposit'
        );


    /*
     * ============================================================
     * ELEMENTOS — FORMULÁRIO
     * ============================================================
     */

    const reservationForm =
        document.getElementById(
            'tourReservationForm'
        );

    const reservationSubmit =
        document.getElementById(
            'tourReservationSubmit'
        );

    const formError =
        document.getElementById(
            'tourReservationFormError'
        );


    const reservationTourOptionId =
        document.getElementById(
            'reservationTourOptionId'
        );

    const reservationScheduleId =
        document.getElementById(
            'reservationScheduleId'
        );

    const reservationBookingDate =
        document.getElementById(
            'reservationBookingDate'
        );

    const reservationParticipants =
        document.getElementById(
            'reservationParticipants'
        );


    /*
     * ============================================================
     * DADOS
     * ============================================================
     */

    const tourId =
        selector.dataset.tourId;

    const maxCapacity =
        parseInt(
            selector.dataset.maxCapacity,
            10
        );

    const unavailableDates =
        @json($unavailableDates);

    const options =
        @json($reservationOptions);

    const scheduleAvailability =
        @json($scheduleAvailability ?? []);


    /*
     * ============================================================
     * ESTADO
     * ============================================================
     */

    let currentMonth =
        new Date(
            new Date().getFullYear(),
            new Date().getMonth(),
            1
        );

    let selectedDate = null;

    let selectedOption = null;

    let selectedSchedule = null;

    let people = 1;


    /*
     * ============================================================
     * HELPERS
     * ============================================================
     */

    function formatDate(date) {

        const year =
            date.getFullYear();

        const month =
            String(
                date.getMonth() + 1
            ).padStart(2, '0');

        const day =
            String(
                date.getDate()
            ).padStart(2, '0');

        return `${year}-${month}-${day}`;
    }


    function isPast(date) {

        const today =
            new Date();

        today.setHours(
            0,
            0,
            0,
            0
        );

        return date < today;
    }


    function formatCurrency(value) {

        return '€' +
            Number(value).toLocaleString(
                'pt-PT',
                {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }
            );
    }


    function formatSelectedDate(dateString) {

        if (!dateString) {
            return '—';
        }

        const date =
            new Date(
                `${dateString}T00:00:00`
            );

        return date.toLocaleDateString(
            '{{ app()->getLocale() }}',
            {
                day: '2-digit',
                month: 'long',
                year: 'numeric'
            }
        );
    }


    function getDeposit(value) {

        return Number(value) * 0.10;
    }


    /*
     * ============================================================
     * DISPONIBILIDADE DE HORÁRIOS
     * ============================================================
     */

    function isScheduleAvailable(
        optionId,
        scheduleId,
        dateString = selectedDate
    ) {

        if (!dateString) {
            return true;
        }


        const dateAvailability =
            scheduleAvailability[dateString];


        /*
         * Se o backend não enviou informação
         * para esta data, significa que ela não
         * foi afetada por bloqueios/reservas.
         */

        if (!dateAvailability) {
            return true;
        }


        const key =
            `${optionId}:${scheduleId}`;


        if (
            Object.prototype.hasOwnProperty.call(
                dateAvailability,
                key
            )
        ) {
            return dateAvailability[key] === true;
        }


        return true;
    }


    /*
     * ============================================================
     * RESET APÓS ALTERAR DATA
     * ============================================================
     */

    function resetAfterDateChange() {

        selectedOption = null;

        selectedSchedule = null;


        document
            .querySelectorAll(
                'input[name="tour_option_id"]'
            )
            .forEach(input => {

                input.checked = false;

            });


        scheduleOptions.innerHTML = '';


        durationStep.hidden = false;

        scheduleStep.hidden = true;

        peopleStep.hidden = true;

        summary.hidden = true;

    }


    /*
     * ============================================================
     * ATUALIZAR DISPONIBILIDADE DAS OPÇÕES
     * ============================================================
     */

    function updateOptionAvailability() {

        document
            .querySelectorAll(
                'input[name="tour_option_id"]'
            )
            .forEach(input => {

                const option =
                    options.find(
                        option =>
                            option.id == input.value
                    );

                if (!option) {
                    return;
                }


                const hasAvailableSchedule =
                    option.schedules.some(
                        schedule =>
                            isScheduleAvailable(
                                option.id,
                                schedule.id
                            )
                    );


                const label =
                    input.closest(
                        '.tour-duration-option'
                    );


                if (!label) {
                    return;
                }


                if (!hasAvailableSchedule) {

                    input.checked = false;

                    input.disabled = true;

                    label.hidden = true;

                    label.classList.add(
                        'is-unavailable'
                    );


                    if (
                        selectedOption &&
                        selectedOption.id == option.id
                    ) {

                        selectedOption = null;

                        selectedSchedule = null;

                        scheduleOptions.innerHTML = '';

                        scheduleStep.hidden = true;

                        peopleStep.hidden = true;

                        summary.hidden = true;

                    }

                } else {

                    input.disabled = false;

                    label.hidden = false;

                    label.classList.remove(
                        'is-unavailable'
                    );

                }

            });

    }


    /*
     * ============================================================
     * CALENDÁRIO
     * ============================================================
     */

    function renderCalendar() {

        calendarGrid.innerHTML = '';


        const year =
            currentMonth.getFullYear();

        const month =
            currentMonth.getMonth();


        const monthName =
            currentMonth.toLocaleDateString(
                '{{ app()->getLocale() }}',
                {
                    month: 'long',
                    year: 'numeric'
                }
            );


        calendarMonth.textContent =
            monthName.charAt(0).toUpperCase() +
            monthName.slice(1);


        const firstDay =
            new Date(
                year,
                month,
                1
            );


        let firstWeekday =
            firstDay.getDay();


        /*
         * Domingo passa para o fim,
         * porque o calendário começa à segunda-feira.
         */

        firstWeekday =
            firstWeekday === 0
                ? 6
                : firstWeekday - 1;


        const daysInMonth =
            new Date(
                year,
                month + 1,
                0
            ).getDate();


        /*
         * Espaços antes do primeiro dia.
         */

        for (
            let i = 0;
            i < firstWeekday;
            i++
        ) {

            const emptyDay =
                document.createElement(
                    'span'
                );

            emptyDay.className =
                'tour-calendar-day tour-calendar-day-empty';

            calendarGrid.appendChild(
                emptyDay
            );

        }


        /*
         * Dias do mês.
         */

        for (
            let day = 1;
            day <= daysInMonth;
            day++
        ) {

            const date =
                new Date(
                    year,
                    month,
                    day
                );


            const dateString =
                formatDate(date);


            const button =
                document.createElement(
                    'button'
                );


            button.type = 'button';

            button.className =
                'tour-calendar-day';

            button.textContent =
                day;


            const unavailable =
                unavailableDates.includes(
                    dateString
                );


            if (
                isPast(date) ||
                unavailable
            ) {

                button.disabled = true;

                button.classList.add(
                    'is-unavailable'
                );

            } else {

                button.classList.add(
                    'is-available'
                );


                button.addEventListener(
                    'click',
                    function () {

                        selectDate(
                            dateString,
                            date
                        );

                    }
                );

            }


            if (
                selectedDate === dateString
            ) {

                button.classList.add(
                    'is-selected'
                );

            }


            calendarGrid.appendChild(
                button
            );

        }

    }


    /*
     * ============================================================
     * SELECIONAR DATA
     * ============================================================
     */

    function selectDate(
        dateString,
        date
    ) {

        selectedDate =
            dateString;


        resetAfterDateChange();


        selectedDateLabel.textContent =
            date.toLocaleDateString(
                '{{ app()->getLocale() }}',
                {
                    day: '2-digit',
                    month: 'long',
                    year: 'numeric'
                }
            );


        updateOptionAvailability();


        renderCalendar();

    }


    /*
     * ============================================================
     * SELECIONAR OPÇÃO
     * ============================================================
     */

    document
        .querySelectorAll(
            'input[name="tour_option_id"]'
        )
        .forEach(input => {

            input.addEventListener(
                'change',
                function () {

                    selectedOption =
                        options.find(
                            option =>
                                option.id ==
                                this.value
                        );


                    selectedSchedule =
                        null;


                    scheduleStep.hidden =
                        false;

                    peopleStep.hidden =
                        true;

                    summary.hidden =
                        true;


                    renderSchedules();

                }
            );

        });


    /*
     * ============================================================
     * HORÁRIOS
     * ============================================================
     */

    function renderSchedules() {

        scheduleOptions.innerHTML = '';


        if (
            !selectedOption ||
            !selectedOption.schedules.length
        ) {

            scheduleOptions.innerHTML =
                `<p class="tour-schedule-empty">
                    {{ __('tours.options.schedule.none') }}
                </p>`;

            return;
        }


        const availableSchedules =
            selectedOption.schedules.filter(
                schedule =>
                    isScheduleAvailable(
                        selectedOption.id,
                        schedule.id
                    )
            );


        if (!availableSchedules.length) {

            scheduleOptions.innerHTML =
                `<p class="tour-schedule-empty">
                    {{ __('tours.options.schedule.none') }}
                </p>`;


            scheduleStep.hidden = false;

            peopleStep.hidden = true;

            summary.hidden = true;

            selectedSchedule = null;

            return;
        }


        availableSchedules.forEach(
            (schedule, index) => {

                const label =
                    document.createElement(
                        'label'
                    );


                label.className =
                    'tour-schedule-option';


                const input =
                    document.createElement(
                        'input'
                    );


                input.type = 'radio';

                input.name =
                    'tour_option_schedule_id';

                input.value =
                    schedule.id;


                const card =
                    document.createElement(
                        'span'
                    );


                card.className =
                    'tour-schedule-card';


                card.innerHTML =
                    `<strong>
                        ${schedule.start_time} — ${schedule.end_time}
                    </strong>`;


                label.appendChild(input);

                label.appendChild(card);

                scheduleOptions.appendChild(
                    label
                );


                input.addEventListener(
                    'change',
                    function () {

                        selectedSchedule =
                            schedule;


                        peopleStep.hidden =
                            false;

                        summary.hidden =
                            false;


                        updateSummary();

                    }
                );


                /*
                 * Selecionar automaticamente
                 * o primeiro horário disponível.
                 */

                if (index === 0) {

                    input.checked = true;


                    selectedSchedule =
                        schedule;


                    peopleStep.hidden =
                        false;

                    summary.hidden =
                        false;


                    updateSummary();

                }

            }
        );

    }


    /*
     * ============================================================
     * RESUMO
     * ============================================================
     */

    function updateSummary() {

        if (
            !selectedDate ||
            !selectedOption ||
            !selectedSchedule
        ) {

            summary.hidden = true;

            return;
        }


        /*
         * O preço é por passeio,
         * não por pessoa.
         */

        const total =
            Number(
                selectedOption.price
            );


        reservationPrice.textContent =
            formatCurrency(total);

    }


    /*
     * ============================================================
     * PESSOAS
     * ============================================================
     */

    peopleMinus.addEventListener(
        'click',
        function () {

            if (people <= 1) {
                return;
            }


            people--;

            peopleValue.textContent =
                people;

        }
    );


    peoplePlus.addEventListener(
        'click',
        function () {

            if (
                people >= maxCapacity
            ) {
                return;
            }


            people++;

            peopleValue.textContent =
                people;

        }
    );


    /*
     * ============================================================
     * PREPARAR CONFIRMAÇÃO
     * ============================================================
     */

    function prepareConfirmation() {

        if (
            !selectedDate ||
            !selectedOption ||
            !selectedSchedule
        ) {
            return false;
        }


        /*
         * Dados que serão enviados ao backend.
         */

        reservationTourOptionId.value =
            selectedOption.id;

        reservationScheduleId.value =
            selectedSchedule.id;

        reservationBookingDate.value =
            selectedDate;

        reservationParticipants.value =
            people;


        /*
         * Resumo visual.
         */

        confirmationOption.textContent =
            selectedOption.name;


        confirmationDate.textContent =
            formatSelectedDate(
                selectedDate
            );


        confirmationSchedule.textContent =
            `${selectedSchedule.start_time} — ${selectedSchedule.end_time}`;


        confirmationPeople.textContent =
            people;


        const total =
            Number(
                selectedOption.price
            );


        confirmationTotal.textContent =
            formatCurrency(total);


        confirmationDeposit.textContent =
            formatCurrency(
                getDeposit(total)
            );


        return true;

    }


    /*
     * ============================================================
     * CONTINUAR
     * ============================================================
     */

    continueButton.addEventListener(
        'click',
        function () {

            if (!prepareConfirmation()) {
                return;
            }


            selection.hidden =
                true;

            confirmation.hidden =
                false;

            success.hidden =
                true;


            /*
             * Levamos o utilizador para o início
             * do bloco de reserva.
             */

            document
                .getElementById(
                    'tour-reservation'
                )
                ?.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });

        }
    );


    /*
     * ============================================================
     * VOLTAR À SELEÇÃO
     * ============================================================
     */

    backButton.addEventListener(
        'click',
        function () {

            confirmation.hidden =
                true;

            success.hidden =
                true;

            selection.hidden =
                false;


            /*
             * Mantemos a seleção atual.
             * O utilizador pode simplesmente alterar
             * data, opção, horário ou pessoas.
             */

            renderCalendar();

        }
    );


    /*
     * ============================================================
     * LIMPAR ERROS
     * ============================================================
     */

    function clearFormErrors() {

        formError.hidden = true;

        formError.textContent = '';


        document
            .querySelectorAll(
                '.reservation-form-error'
            )
            .forEach(error => {

                error.hidden = true;

                error.textContent = '';

            });

    }


    /*
     * ============================================================
     * MOSTRAR ERROS
     * ============================================================
     */

    function showFormErrors(errors) {

        clearFormErrors();


        let firstError = null;


        Object.entries(errors || {})
            .forEach(
                ([field, messages]) => {

                    const error =
                        document.querySelector(
                            `[data-error-for="${field}"]`
                        );


                    if (!error) {
                        return;
                    }


                    error.textContent =
                        Array.isArray(messages)
                            ? messages[0]
                            : messages;


                    error.hidden = false;


                    if (!firstError) {
                        firstError = error;
                    }

                }
            );


        if (firstError) {

            firstError.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });

            return;

        }


        formError.textContent =
            'Não foi possível enviar o pedido. Verifique os dados e tente novamente.';

        formError.hidden =
            false;

    }


    /*
     * ============================================================
     * ENVIO DA RESERVA
     * ============================================================
     */

    reservationForm.addEventListener(
        'submit',
        async function (event) {

            event.preventDefault();


            clearFormErrors();


            if (
                !selectedDate ||
                !selectedOption ||
                !selectedSchedule
            ) {

                formError.textContent =
                    'A seleção da reserva ficou incompleta. Volte atrás e confirme a data, opção e horário.';

                formError.hidden =
                    false;

                return;

            }


            /*
             * Garantimos novamente os valores ocultos.
             */

            reservationTourOptionId.value =
                selectedOption.id;

            reservationScheduleId.value =
                selectedSchedule.id;

            reservationBookingDate.value =
                selectedDate;

            reservationParticipants.value =
                people;


            reservationSubmit.disabled =
                true;


            const originalButtonText =
                reservationSubmit.textContent;


            reservationSubmit.textContent =
                'A enviar...';


            try {

                const formData =
                    new FormData(
                        reservationForm
                    );


                const response =
                    await fetch(
                        reservationForm.action,
                        {
                            method: 'POST',

                            body: formData,

                            headers: {
                                'X-Requested-With':
                                    'XMLHttpRequest',

                                'Accept':
                                    'text/html'
                            },

                            credentials:
                                'same-origin'
                        }
                    );


                /*
                 * O backend atual faz redirect depois
                 * de criar a reserva.
                 *
                 * Se o redirect final for para uma página
                 * diferente da página atual, consideramos
                 * o pedido enviado com sucesso.
                 */

                if (
                    response.ok &&
                    response.url !== window.location.href
                ) {

                    confirmation.hidden =
                        true;

                    selection.hidden =
                        true;

                    success.hidden =
                        false;


                    success.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });


                    /*
                     * Por enquanto mantemos a mensagem
                     * durante alguns segundos e voltamos
                     * ao estado inicial.
                     */

                    setTimeout(
                        function () {

                            window.location.reload();

                        },
                        5000
                    );


                    return;

                }


                /*
                 * Se o servidor nos devolveu a própria página,
                 * muito provavelmente houve validação/rejeição.
                 *
                 * O backend atual ainda não devolve JSON de erros.
                 */

                formError.textContent =
                    'Não foi possível enviar o pedido. Verifique os dados introduzidos e tente novamente.';

                formError.hidden =
                    false;


            } catch (error) {

                console.error(
                    'Erro ao enviar reserva:',
                    error
                );


                formError.textContent =
                    'Ocorreu um erro ao enviar o pedido. Tente novamente.';

                formError.hidden =
                    false;

            } finally {

                reservationSubmit.disabled =
                    false;

                reservationSubmit.textContent =
                    originalButtonText;

            }

        }
    );


    /*
     * ============================================================
     * NAVEGAÇÃO DO CALENDÁRIO
     * ============================================================
     */

    previousButton.addEventListener(
        'click',
        function () {

            currentMonth =
                new Date(
                    currentMonth.getFullYear(),
                    currentMonth.getMonth() - 1,
                    1
                );


            renderCalendar();

        }
    );


    nextButton.addEventListener(
        'click',
        function () {

            currentMonth =
                new Date(
                    currentMonth.getFullYear(),
                    currentMonth.getMonth() + 1,
                    1
                );


            renderCalendar();

        }
    );


    /*
     * ============================================================
     * INICIALIZAÇÃO
     * ============================================================
     */

    renderCalendar();

});
</script>

@endpush