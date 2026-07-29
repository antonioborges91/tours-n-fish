<section class="tours-page">

    <div class="container-custom">

        <div class="popular-tours-grid">

            @forelse($tours as $tour)

                <x-tour-card :tour="$tour" />

            @empty

                <p>

                    Não existem passeios disponíveis de momento.

                </p>

            @endforelse

        </div>

    </div>

</section>