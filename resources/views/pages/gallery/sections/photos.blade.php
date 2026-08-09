<section class="gallery-photos">

    <div class="container-custom">

        @if($photos->isNotEmpty())

            <div class="gallery-grid">

                @foreach($photos as $photo)

                    <figure class="gallery-item">

                        <img
                            src="{{ asset('storage/' . $photo->image) }}"
                            alt=""
                            loading="lazy">

                    </figure>

                @endforeach

            </div>

        @else

            <div class="gallery-empty">

                <p>
                    {{ __('gallery.empty') }}
                </p>

            </div>

        @endif

    </div>

</section>