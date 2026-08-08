@extends('layouts.app')

@section('title', __('navigation.gallery'))

@section('content')

<section class="gallery-page">

    {{-- Hero --}}

    <section class="gallery-hero">

        <div class="gallery-hero-card">

            <div
                class="gallery-hero-background"
                style="background-image: url('{{ asset('images/gallery/hero.webp') }}')">
            </div>

            <div class="gallery-hero-gradient"></div>

            <div class="gallery-hero-content">

                <h1 class="gallery-hero-title">

                    {{ __('gallery.hero.title') }}<br>

                    <span>{{ __('gallery.hero.highlight') }}</span>

                </h1>

                <p class="gallery-hero-text">

                    {{ __('gallery.hero.text') }}

                </p>

            </div>

        </div>

    </section>


    {{-- Fotografias --}}

    <section class="gallery-content">

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

</section>

@endsection