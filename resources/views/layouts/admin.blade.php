<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Administração</title>

    @vite([
    'resources/css/app.css',
    'resources/js/admin.js'
    ])
</head>

<body class="bg-gray-100">

<div class="min-h-screen flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-slate-900 text-white">

        <div class="p-6 border-b border-slate-700">
            <h1 class="text-xl font-bold">
                Tours N Fish
            </h1>

            <p class="text-sm text-slate-400">
                Administração
            </p>
        </div>

        <nav class="p-4 space-y-2">

            <a href="{{ route('admin.dashboard') }}"
               class="block px-4 py-2 rounded hover:bg-slate-800">
                Dashboard
            </a>

            <a href="{{ route('admin.tours.index') }}"
               class="block px-4 py-2 rounded hover:bg-slate-800">
                Passeios
            </a>

            <a href="{{ route('admin.gallery.index') }}"
               class="block px-4 py-2 rounded hover:bg-slate-800">
                Galeria
            </a>

            <a href="{{ route('admin.blocked-periods.index') }}"
               class="block px-4 py-2 rounded hover:bg-slate-800">
                Bloqueios
            </a>

            <a href="{{ route('admin.reservations.index') }}"
               class="block px-4 py-2 rounded hover:bg-slate-800">
                Reservas
            </a>

        </nav>

    </aside>

    <!-- Conteúdo -->
    <main class="flex-1">

        <header class="bg-white border-b">

            <div class="px-8 py-5 flex justify-between items-center">

                <h2 class="text-xl font-semibold">
                    Administração
                </h2>

                <div class="flex items-center gap-4">

                    <span>
                        {{ Auth::user()->name }}
                    </span>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button class="text-red-600 hover:underline">
                            Terminar sessão
                        </button>
                    </form>

                </div>

            </div>

        </header>

        <div class="p-8">
            @yield('content')
        </div>

    </main>

</div>

</body>
</html>