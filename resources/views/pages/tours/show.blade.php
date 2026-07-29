@extends('layouts.app')

@section('title', $tour->translation()->name)

@section('content')

<div class="tour-show">

    @include('pages.tours.sections.show-hero')

    @include('pages.tours.sections.description')

    @include('pages.tours.sections.gallery')

    @include('pages.tours.sections.options')

    @include('pages.tours.sections.information')

</div>

@endsection