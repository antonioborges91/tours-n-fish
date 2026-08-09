@extends('layouts.app')

@section('content')

<section class="gallery">

    @include('pages.gallery.sections.hero')

    @include('pages.gallery.sections.photos')

</section>

@endsection