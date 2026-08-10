@extends('layouts.app')

@section('title', __('contact.page_title'))

@section('content')

<section class="contact">

    @include('pages.contact.sections.hero')

    @include('pages.contact.sections.info')

    @include('pages.contact.sections.map')

</section>

@endsection