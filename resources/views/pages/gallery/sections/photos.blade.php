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

    const grid = document.querySelector('.gallery-grid');

    if (!grid) {
        return;
    }


    function resizeGalleryItems() {

    const items = grid.querySelectorAll('.gallery-item');

    const rowHeight = 8;

    const gap = parseFloat(
        getComputedStyle(grid).rowGap
    );


    items.forEach(function (item) {

        const image = item.querySelector('img');

        if (!image) {
            return;
        }


        if (
            !image.naturalWidth ||
            !image.naturalHeight
        ) {
            return;
        }


        /*
         * Detecta se a fotografia é vertical.
         */
        const isPortrait =
            image.naturalHeight > image.naturalWidth;


        item.classList.toggle(
            'is-portrait',
            isPortrait
        );


        /*
         * Como a largura da vertical foi reduzida
         * para 76%, temos de obter a largura real
         * depois dessa alteração.
         */
        const width =
            item.getBoundingClientRect().width;


        if (!width) {
            return;
        }


        const imageHeight =
            width *
            (
                image.naturalHeight /
                image.naturalWidth
            );


        const rowSpan =
            Math.ceil(
                (imageHeight + gap) /
                (rowHeight + gap)
            );


        item.style.gridRowEnd =
            'span ' + rowSpan;

    });

}


    const images = grid.querySelectorAll('img');


    images.forEach(function (image) {

        if (image.complete) {

            resizeGalleryItems();

        } else {

            image.addEventListener(
                'load',
                resizeGalleryItems
            );

        }

    });


    window.addEventListener(
        'resize',
        resizeGalleryItems
    );


    resizeGalleryItems();


    /* =====================================================
       LIGHTBOX
       ===================================================== */

    const lightbox =
        document.getElementById(
            'gallery-lightbox'
        );

    const lightboxImage =
        document.getElementById(
            'gallery-lightbox-image'
        );

    const closeButton =
        document.querySelector(
            '.gallery-lightbox-close'
        );


    if (
        !lightbox ||
        !lightboxImage ||
        !closeButton
    ) {
        return;
    }


    grid.querySelectorAll(
        '[data-gallery-image]'
    ).forEach(function (item) {

        item.addEventListener(
            'click',
            function () {

                lightboxImage.src =
                    item.dataset.galleryImage;

                lightbox.classList.add(
                    'is-open'
                );

                lightbox.setAttribute(
                    'aria-hidden',
                    'false'
                );

                document.body.classList.add(
                    'gallery-lightbox-open'
                );

            }
        );

    });


    function closeLightbox() {

        lightbox.classList.remove(
            'is-open'
        );

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