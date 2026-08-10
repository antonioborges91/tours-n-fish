@extends('layouts.app')

@section('title', __('tours.page_title'))

@section('content')

<section class="tours">

    @include('pages.tours.sections.hero')

    @include('pages.tours.sections.tours-grid')

</section>

@endsection