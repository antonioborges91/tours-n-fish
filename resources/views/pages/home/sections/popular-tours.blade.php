<section class="popular-tours">

    <div class="container-custom">

        <div class="section-heading">

            <span class="section-subtitle">
                Passeios Populares
            </span>

            <h2 class="section-title">
                Escolha a sua aventura
            </h2>

        </div>

        <div class="popular-tours-grid">

            @forelse($popularTours as $tour)

                <x-tour-card :tour="$tour"/>

            @empty

                <p>
                    Ainda não existem passeios em destaque.
                </p>

            @endforelse

        </div>

        <div class="popular-tours-action">

            <a
                href="{{ route('tours') }}"
                class="btn btn-primary">

                Ver todos os passeios

            </a>

        </div>

    </div>

</section>