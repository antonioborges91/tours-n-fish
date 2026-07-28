@props(['tour'])

@php
    $translation = $tour->translation();
    $option = $tour->firstOption();
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

                ⏱

                {{ $option?->duration_minutes }} min

            </span>

            <span>

                👥 Até {{ $tour->max_capacity }} pessoas

            </span>

        </div>

        <div class="tour-card-footer">

            <div class="tour-card-price">

                <small>

                    Desde

                </small>

                <strong>

                    €{{ number_format($option?->price ?? 0, 0, ',', '.') }}

                </strong>

                <span>

                    / passeio

                </span>

            </div>

            <a
                href="#"
                class="link-arrow">

                Saber mais

            </a>

        </div>

    </div>

</article>