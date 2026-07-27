@extends('layouts.app')

@section('content')

<section class="home-top">

    @include('pages.home.sections.hero')

    @include('pages.home.sections.popular-tours')

    @include('pages.home.sections.about-preview')

</section>

@endsection