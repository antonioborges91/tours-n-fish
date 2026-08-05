<section class="tour-options">

    <div class="container-custom">

        <div class="section-heading">

            <span class="section-badge">

                {{ __('tours.options.badge') }}

            </span>

            <h2 class="section-title">

                {{ __('tours.options.title') }}

            </h2>

        </div>

        <div class="tour-options-list">

            @foreach($tour->options as $option)

                @php

                    $translation = $option->translation();

                    $duration = $option->duration_minutes;

                    if($duration >= 60){

                        $hours = intdiv($duration,60);

                        $minutes = $duration % 60;

                        $durationText = $minutes
                            ? "{$hours} h {$minutes} min"
                            : "{$hours} h";

                    }else{

                        $durationText = "{$duration} min";

                    }

                @endphp

                <article class="tour-option">

                    <div class="tour-option-main">

                        <h3>

                            {{ $translation->name }}

                        </h3>

                        <div class="tour-option-details">

                            <span>

                                <svg class="meta-icon" xmlns="http://www.w3.org/2000/svg"
                                    width="18" height="18"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round">

                                    <circle cx="12" cy="12" r="10"/>

                                    <polyline points="12 6 12 12 16 14"/>

                                </svg>

                                {{ $durationText }}

                            </span>

                            <span>

                                <svg class="meta-icon" xmlns="http://www.w3.org/2000/svg"
                                    width="18"
                                    height="18"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round">

                                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>

                                    <circle cx="8.5" cy="7" r="4"/>

                                    <path d="M20 8v6"/>

                                    <path d="M23 11h-6"/>

                                </svg>

                                {{ __('tours.options.up_to', ['count' => $tour->max_capacity]) }}

                            </span>

                        </div>

                        @if($option->schedules->count())

                            <div class="tour-option-schedules">

                                <p class="tour-option-schedules-title">

                                    {{ __('tours.options.available_schedules') }}

                                </p>

                                <div class="tour-option-schedule-list">

                                    @foreach($option->schedules as $schedule)

                                        <label class="tour-option-schedule">

                                            <input
                                                type="radio"
                                                name="schedule_{{ $option->id }}"
                                                value="{{ $schedule->id }}"
                                                @checked($loop->first)
                                            >

                                            <span class="tour-option-schedule-card">

                                                {{ substr($schedule->start_time,0,5) }}

                                                —

                                                {{ substr($schedule->end_time,0,5) }}

                                            </span>

                                        </label>

                                    @endforeach

                                </div>

                            </div>

                        @endif

                    </div>

                    <div class="tour-option-book">

                        <span class="tour-option-from">

                            {{ __('tours.options.available_schedules') }}

                        </span>

                        <div class="tour-option-price">

                            €{{ number_format($option->price,0,",",".") }}

                        </div>

                        <span class="tour-option-per">

                            {{ __('tours.options.per_tour') }}

                        </span>

                        <a href="#" class="btn btn-primary">

                            {{ __('tours.options.book') }}

                        </a>

                    </div>

                </article>

            @endforeach

        </div>

    </div>

</section>