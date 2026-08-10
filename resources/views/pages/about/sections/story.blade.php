<section class="about-story">

    <div class="container-custom">

        <div class="section-heading">

            <span class="section-subtitle">
                {{ __('about.story.subtitle') }}
            </span>

            <h2 class="section-title">
                {{ __('about.story.title') }}
            </h2>

        </div>

        <div class="about-story-grid">

            <div class="about-story-content">

                <p>
                    {{ __('about.story.paragraph_1') }}
                </p>

                <p>
                    {{ __('about.story.paragraph_2') }}
                </p>

            </div>

            <div class="about-story-image">

                <img
                    src="{{ asset('images/about/story.webp') }}"
                    alt="{{ __('about.story.image_alt') }}"
                    loading="lazy">

            </div>

        </div>

    </div>

</section>