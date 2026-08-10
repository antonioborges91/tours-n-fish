@extends('layouts.app')

@section('title', __('gallery.page_title'))

@section('content')

<section class="gallery">

    @include('pages.gallery.sections.hero')

    @include('pages.gallery.sections.photos')

</section>

@endsection