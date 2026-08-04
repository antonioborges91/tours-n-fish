<section class="popular-tours">

    <div class="container-custom">

        <div class="section-heading">

            <span class="section-subtitle">
                {{ __('home.popular_badge') }}
            </span>

            <h2 class="section-title">
                {{ __('home.popular_title') }}
            </h2>

        </div>

        <div class="popular-tours-grid">

            @forelse($popularTours as $tour)

                <x-tour-card :tour="$tour"/>

            @empty

                <p>
                    {{ __('home.no_featured_tours') }}
                </p>

            @endforelse

        </div>

        <div class="popular-tours-action">

            <a
                href="{{ route('tours') }}"
                class="btn-secondary">

                {{ __('home.view_all') }}

            </a>

        </div>

    </div>

</section>