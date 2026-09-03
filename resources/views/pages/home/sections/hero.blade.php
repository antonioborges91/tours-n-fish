<section class="hero">

    <div class="hero-card">

        <div
            class="hero-background"
            style="background-image:url('{{ asset('images/hero/hero.webp') }}')">
        </div>

        <div class="hero-gradient"></div>

        <div class="hero-content">

            <h1 class="hero-title">
                {{ __('home.hero_title_1') }}<br>
                <span>{{ __('home.hero_title_2') }}</span>
            </h1>

            <p class="hero-text">
                {{ __('home.hero_text') }}
            </p>

            <div class="hero-actions">

                <a href="{{ route('tours') }}" class="btn-secondary">
                    {{ __('home.explore') }}

                    <x-lucide-chevron-right class="btn-icon w-4 h-4"/>
                </a>

            </div>

        </div>

    </div>

    @include('pages.home.components.hero-features')

</section>