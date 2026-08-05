<section class="tour-description">

    <div class="container-custom">

        <span class="section-badge">

            {{ __('tours.description.badge') }}

        </span>

        <div class="tour-description-text">

            {!! nl2br(e($tour->translation()->full_description)) !!}

        </div>

    </div>

</section>