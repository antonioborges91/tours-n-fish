<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        Tours N Fish | @yield('title', 'Tours N Fish')
    </title>

    <meta name="description" content="@yield('description', 'Passeios de barco, pesca desportiva e experiências marítimas nos Açores.')">

    <meta name="author" content="Tours N Fish">

    <!-- Favicons -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x21.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x11.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-slate-50 text-slate-900 font-[Poppins]">

    @include('components.navbar.index')

    <main>
        @yield('content')
    </main>

    @include('components.footer.index')

    @stack('scripts')

</body>

</html>