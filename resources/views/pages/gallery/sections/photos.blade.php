<div class="container-custom">

    @if($photos->isNotEmpty())

        <div class="gallery-grid">

            @foreach($photos as $photo)

                <button
                    type="button"
                    class="gallery-item"
                    data-gallery-image="{{ asset('storage/' . $photo->image) }}"
                    aria-label="Abrir fotografia em tamanho maior">

                    <img
                        src="{{ asset('storage/' . $photo->image) }}"
                        alt=""
                        loading="lazy">

                </button>

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


<div
    id="gallery-lightbox"
    class="gallery-lightbox"
    aria-hidden="true">

    <button
        type="button"
        class="gallery-lightbox-close"
        aria-label="Fechar fotografia">

        ×

    </button>

    <img
        id="gallery-lightbox-image"
        src=""
        alt="">

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const items = document.querySelectorAll(
        '[data-gallery-image]'
    );

    const lightbox = document.getElementById(
        'gallery-lightbox'
    );

    const lightboxImage = document.getElementById(
        'gallery-lightbox-image'
    );

    const closeButton = document.querySelector(
        '.gallery-lightbox-close'
    );


    if (!lightbox || !lightboxImage || !closeButton) {
        return;
    }


    items.forEach(function (item) {

        item.addEventListener('click', function () {

            lightboxImage.src =
                item.dataset.galleryImage;

            lightbox.classList.add('is-open');

            lightbox.setAttribute(
                'aria-hidden',
                'false'
            );

            document.body.classList.add(
                'gallery-lightbox-open'
            );

        });

    });


    function closeLightbox() {

        lightbox.classList.remove('is-open');

        lightbox.setAttribute(
            'aria-hidden',
            'true'
        );

        document.body.classList.remove(
            'gallery-lightbox-open'
        );

        lightboxImage.src = '';

    }


    closeButton.addEventListener(
        'click',
        closeLightbox
    );


    lightbox.addEventListener(
        'click',
        function (event) {

            if (event.target === lightbox) {
                closeLightbox();
            }

        }
    );


    document.addEventListener(
        'keydown',
        function (event) {

            if (event.key === 'Escape') {
                closeLightbox();
            }

        }
    );

});

</script>