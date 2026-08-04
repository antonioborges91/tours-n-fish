<section class="about-preview">

    <div class="about-preview-image">

        <img
            src="{{ asset('images/about/about-preview.webp') }}"
            alt="Tours N Fish">

    </div>

    <div class="about-preview-content">

        <span class="section-subtitle">
            {{ __('home.about_badge') }}
        </span>

        <h2 class="section-title about-title">
            {{ __('home.about_title') }}
        </h2>

        <p class="about-text">
            {{ __('home.about_text') }}
        </p>

        <a
            href="{{ route('about') }}"
            class="link-arrow">

            {{ __('home.about_link') }} →

        </a>

    </div>

</section>