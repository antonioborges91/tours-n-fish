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
        class="gallery-lightbox-prev"
        aria-label="Fotografia anterior">

        ←

    </button>

    <img
        id="gallery-lightbox-image"
        src=""
        alt="">

    <button
        type="button"
        class="gallery-lightbox-next"
        aria-label="Fotografia seguinte">

        →

    </button>

    <button
        type="button"
        class="gallery-lightbox-close"
        aria-label="Fechar fotografia">

        ×

    </button>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const grid = document.querySelector('.gallery-grid');

    if (!grid) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Gallery Grid
    |--------------------------------------------------------------------------
    */

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
             * para 76%, obtemos a largura real depois
             * dessa alteração.
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


    /*
    |--------------------------------------------------------------------------
    | Lightbox
    |--------------------------------------------------------------------------
    */

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

    const previousButton =
        document.querySelector(
            '.gallery-lightbox-prev'
        );

    const nextButton =
        document.querySelector(
            '.gallery-lightbox-next'
        );


    if (
        !lightbox ||
        !lightboxImage ||
        !closeButton ||
        !previousButton ||
        !nextButton
    ) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Gallery Images
    |--------------------------------------------------------------------------
    */

    const galleryItems =
        Array.from(
            grid.querySelectorAll(
                '[data-gallery-image]'
            )
        );


    let currentIndex = 0;


    /*
    |--------------------------------------------------------------------------
    | Show Image
    |--------------------------------------------------------------------------
    */

    function showImage(index) {

        if (!galleryItems.length) {
            return;
        }


        /*
         * Navegação circular:
         *
         * primeira ← última
         * última → primeira
         */

        if (index < 0) {
            index = galleryItems.length - 1;
        }

        if (index >= galleryItems.length) {
            index = 0;
        }


        currentIndex = index;


        const item =
            galleryItems[currentIndex];

        const imageUrl =
            item.dataset.galleryImage;


        if (!imageUrl) {
            return;
        }


        lightboxImage.src = imageUrl;


        const thumbnail =
            item.querySelector('img');


        if (
            thumbnail &&
            thumbnail.alt
        ) {

            lightboxImage.alt =
                thumbnail.alt;

        } else {

            lightboxImage.alt =
                'Fotografia da galeria';

        }


        /*
         * Pré-carrega a fotografia anterior
         * e a seguinte.
         */

        preloadImage(
            currentIndex - 1
        );

        preloadImage(
            currentIndex + 1
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Preload Image
    |--------------------------------------------------------------------------
    */

    function preloadImage(index) {

        if (index < 0) {
            index = galleryItems.length - 1;
        }

        if (index >= galleryItems.length) {
            index = 0;
        }


        const item =
            galleryItems[index];


        if (!item) {
            return;
        }


        const imageUrl =
            item.dataset.galleryImage;


        if (!imageUrl) {
            return;
        }


        const image =
            new Image();


        image.src = imageUrl;

    }


    /*
    |--------------------------------------------------------------------------
    | Open Lightbox
    |--------------------------------------------------------------------------
    */

    function openLightbox(index) {

        showImage(index);


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


        nextButton.focus();

    }


    /*
    |--------------------------------------------------------------------------
    | Close Lightbox
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | Open Image
    |--------------------------------------------------------------------------
    */

    galleryItems.forEach(
        function (item, index) {

            item.addEventListener(
                'click',
                function () {

                    openLightbox(index);

                }
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Previous
    |--------------------------------------------------------------------------
    */

    previousButton.addEventListener(
        'click',
        function (event) {

            event.stopPropagation();

            showImage(
                currentIndex - 1
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Next
    |--------------------------------------------------------------------------
    */

    nextButton.addEventListener(
        'click',
        function (event) {

            event.stopPropagation();

            showImage(
                currentIndex + 1
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Close Button
    |--------------------------------------------------------------------------
    */

    closeButton.addEventListener(
        'click',
        function (event) {

            event.stopPropagation();

            closeLightbox();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Click Outside Image
    |--------------------------------------------------------------------------
    */

    lightbox.addEventListener(
        'click',
        function (event) {

            if (
                event.target === lightbox
            ) {

                closeLightbox();

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Keyboard Navigation
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'keydown',
        function (event) {

            if (
                !lightbox.classList.contains(
                    'is-open'
                )
            ) {
                return;
            }


            /*
             * ESC → fechar
             */

            if (
                event.key === 'Escape'
            ) {

                event.preventDefault();

                closeLightbox();

                return;

            }


            /*
             * ← → fotografia anterior
             */

            if (
                event.key === 'ArrowLeft'
            ) {

                event.preventDefault();

                showImage(
                    currentIndex - 1
                );

                return;

            }


            /*
             * ← → fotografia seguinte
             */

            if (
                event.key === 'ArrowRight'
            ) {

                event.preventDefault();

                showImage(
                    currentIndex + 1
                );

            }

        }
    );

});

</script>