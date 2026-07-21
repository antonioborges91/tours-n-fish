<section class="hero">

    <div class="container-custom">

        <div class="hero-card">

            {{-- Background --}}
            <div
                class="hero-background"
                style="background-image: url('{{ asset('images/hero/hero.webp') }}');">
            </div>

            {{-- Gradient --}}
            <div class="hero-gradient"></div>

            {{-- Conteúdo --}}
            <div class="hero-content">

                <h1 class="hero-title">
                    Viva o mar.<br>
                    <span>Sinta&nbsp;os&nbsp;Açores.</span>
                </h1>

                <p class="hero-text">
                    Passeios de pesca e atividades marítimas nas águas mais autênticas do Atlântico.
                </p>

                <div class="hero-actions">

                    <a href="#" class="btn-secondary">
                        Explorar Passeios

                        <x-lucide-chevron-right class="btn-icon w-4 h-4" />
                    </a>

                </div>

            </div>

        </div>
        @include('pages.home.components.hero-features')
    </div>

</section>