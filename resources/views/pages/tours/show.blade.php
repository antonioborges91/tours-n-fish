@extends('layouts.app')

@section('title', $tour->translation()->name)

@section('content')

<div class="tour-show">

    @include('pages.tours.sections.show-hero')

    @include('pages.tours.sections.description')

    @include('pages.tours.sections.options')

    @include('pages.tours.sections.gallery')

    @include('pages.tours.sections.information')

</div>
@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', () => {

    const mainImage = document.getElementById('tourMainImage');

    const thumbs = document.querySelectorAll('.tour-gallery-thumb');

    thumbs.forEach((thumb) => {

        thumb.addEventListener('click', () => {

            mainImage.src = thumb.dataset.image;

            thumbs.forEach(item => item.classList.remove('active'));

            thumb.classList.add('active');

        });

    });

    if (thumbs.length) {

        thumbs[0].classList.add('active');

    }

});

</script>

@endpush
@endsection