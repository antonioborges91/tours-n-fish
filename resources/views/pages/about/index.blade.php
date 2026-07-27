@extends('layouts.app')

@section('content')

<section class="about">

    @include('pages.about.sections.hero')

    @include('pages.about.sections.story')

</section>

@endsection