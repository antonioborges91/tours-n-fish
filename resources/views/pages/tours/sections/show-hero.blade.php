@php
    $translation = $tour->translation();
@endphp

<section class="tour-show-hero">

    <div class="tour-show-hero-card">

        <div
            class="tour-show-hero-background"
            style="background-image:url('{{ asset('storage/' . $tour->cover_image) }}')">
        </div>

        <div class="tour-show-hero-gradient"></div>

        <div class="tour-show-hero-content">

            <h1 class="tour-show-hero-title">

                {{ $translation->name }}

            </h1>

            <p class="tour-show-hero-text">

                {{ $translation->short_description }}

            </p>

        </div>

    </div>

</section>