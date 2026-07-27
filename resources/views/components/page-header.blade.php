<section class="page-header">

    <div class="container-custom">

        @isset($breadcrumb)

            <div class="page-breadcrumb">

                {{ $breadcrumb }}

            </div>

        @endisset

        <h1 class="page-title">

            {{ $title }}

        </h1>

        @isset($subtitle)

            <p class="page-description">

                {{ $subtitle }}

            </p>

        @endisset

    </div>

</section>