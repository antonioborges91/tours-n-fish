@if($tour->images->count())

<section class="tour-gallery">

    <div class="container-custom">

        <div class="section-heading">

            <span class="section-badge">

                Galeria

            </span>

            <h2 class="section-title">

                Descubra o passeio em imagens

            </h2>

        </div>

        <div class="tour-gallery-grid">

            <div class="tour-gallery-main">

                <img
                    id="tourMainImage"
                    src="{{ asset('storage/'.$tour->images->first()->image) }}"
                    alt="{{ $tour->translation()->name }}"
                >

            </div>

            <div class="tour-gallery-thumbs">

                @foreach($tour->images as $image)

                    <div
                        class="tour-gallery-thumb"
                        data-image="{{ asset('storage/'.$image->image) }}"
                    >

                        <img
                            src="{{ asset('storage/'.$image->image) }}"
                            alt="{{ $tour->translation()->name }}"
                        >

                    </div>

                @endforeach

            </div>

        </div>

    </div>

</section>

@endif