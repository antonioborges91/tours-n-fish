@extends('layouts.app')

@section('title', 'Passeios')

@section('content')

<section class="tours">

    @include('pages.tours.sections.hero')

    @include('pages.tours.sections.tours-grid')

</section>

@endsection