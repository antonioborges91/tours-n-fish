@props(['tour'])

@php
    $translation = $tour->translation();
    $option = $tour->firstOption();

    $duration = null;

    if ($option?->duration_minutes) {

        $hours = intdiv($option->duration_minutes, 60);
        $minutes = $option->duration_minutes % 60;

        if ($minutes === 0) {
            $duration = "{$hours} h";
        } else {
            $duration = "{$hours} h {$minutes} min";
        }
    }
@endphp

<article class="tour-card">

    <div class="tour-card-image">

        @if($tour->cover_image)

            <img
                src="{{ asset('storage/' . $tour->cover_image) }}"
                alt="{{ $translation?->name }}">

        @endif

    </div>

    <div class="tour-card-content">

        <h3>
            {{ $translation?->name }}
        </h3>

        <div class="tour-card-meta">

            <span>

                <svg
                    class="meta-icon"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 6v6l4 2"/>

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 22a10 10 0 100-20 10 10 0 000 20z"/>

                </svg>

                {{ $duration }}

            </span>

            <span>

                <svg
                    class="meta-icon"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>

                    <circle
                        cx="9"
                        cy="7"
                        r="4"/>

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M23 21v-2a4 4 0 00-3-3.87"/>

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M16 3.13a4 4 0 010 7.75"/>

                </svg>

                {{ __('home.card.people', ['count' => $tour->max_capacity]) }}

            </span>

        </div>

        <div class="tour-card-footer">

            <div class="tour-card-price">

                <small>
                    {{ __('home.card.from') }}
                </small>

                <strong>
                    €{{ number_format($option?->price ?? 0, 0, ',', '.') }}
                </strong>

                <span>
                    {{ __('home.card.per_trip') }}
                </span>

            </div>

            <a
                href="{{ route('tours.show', $tour) }}"
                class="link-arrow">
                {{ __('home.card.learn_more') }}
            </a>

        </div>

    </div>

</article>