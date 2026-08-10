@extends('layouts.app')

@section('title', __('about.page_title'))

@section('content')

<section class="about">

    @include('pages.about.sections.hero')

    @include('pages.about.sections.story')

</section>

@endsection