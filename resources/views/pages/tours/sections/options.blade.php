<section class="tour-options" id="tour-reservation">

    <div class="container-custom">

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
                        'name' => $translation?->name ?? '',
                        'price' => (float) $option->price,
                        'duration_minutes' => (int) $option->duration_minutes,

                        'schedules' => $option->schedules
                            ->map(function ($schedule) {

                                return [
                                    'id' => $schedule->id,
                                    'start_time' => substr(
                                        $schedule->start_time,
                                        0,
                                        5
                                    ),
                                    'end_time' => substr(
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

            {{-- =====================================================
                 CALENDÁRIO
            ====================================================== --}}

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


            {{-- =====================================================
                 CONFIGURAÇÃO DA RESERVA
            ====================================================== --}}

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
                                $translation = $option->translation();

                                $hours = intdiv(
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
                     RESUMO
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


                    <a
                        href="#"
                        class="btn btn-primary"
                        id="tourReservationContinue"
                    >
                        {{ __('tours.options.continue') }}
                    </a>

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
     * ELEMENTOS
     * ============================================================
     */

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


    /*
     * Verifica se um determinado horário está disponível
     * para a data atualmente selecionada.
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
         * Se o backend não enviou informação para esta data,
         * significa que ela não foi afetada por bloqueios/reservas.
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


                /*
                * A opção só é considerada disponível
                * se tiver pelo menos um horário disponível
                * para a data selecionada.
                */

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


                /*
                * Se não existir nenhum horário disponível,
                * escondemos completamente a opção.
                */

                if (!hasAvailableSchedule) {

                    input.checked = false;

                    input.disabled = true;

                    label.hidden = true;

                    label.classList.add(
                        'is-unavailable'
                    );


                    /*
                    * Se era a opção selecionada,
                    * limpamos a seleção.
                    */

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

                    /*
                    * Existe pelo menos um horário disponível.
                    * Voltamos a mostrar a opção.
                    */

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


        /*
         * IMPORTANTE:
         *
         * Aqui recalculamos quais opções têm
         * pelo menos um horário disponível.
         */

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


        /*
         * Filtrar apenas os horários disponíveis
         * para a data escolhida.
         */

        const availableSchedules =
            selectedOption.schedules.filter(
                schedule =>
                    isScheduleAvailable(
                        selectedOption.id,
                        schedule.id
                    )
            );


        /*
         * Nenhum horário disponível.
         */

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


        /*
         * Mostrar os horários disponíveis.
         */

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
                 * Selecionar automaticamente o primeiro
                 * horário disponível.
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
            selectedOption.price;


        reservationPrice.textContent =
            '€' +
            total.toLocaleString(
                'pt-PT',
                {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }
            );

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
     * CONTINUAR
     * ============================================================
     */

    continueButton.addEventListener(
        'click',
        function (event) {

            event.preventDefault();


            if (
                !selectedDate ||
                !selectedOption ||
                !selectedSchedule
            ) {
                return;
            }


            /*
             * O backend recebe:
             *
             * - tour_option_id
             * - tour_option_schedule_id
             * - booking_date
             * - people
             *
             * O horário é determinado pelo schedule.
             */

            const url =
                `/tours/${tourId}/reserve/` +
                `${selectedOption.id}/` +
                `${selectedSchedule.id}` +
                `?booking_date=${encodeURIComponent(selectedDate)}` +
                `&people=${encodeURIComponent(people)}`;


            window.location.href =
                url;

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