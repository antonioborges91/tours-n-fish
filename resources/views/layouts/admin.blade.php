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

    <!-- Overlay mobile -->
    <div
        id="admin-menu-overlay"
        class="fixed inset-0 bg-black/50 z-40 hidden"
        aria-hidden="true"
    ></div>

    <!-- Sidebar -->
    <aside
        id="admin-sidebar"
        class="
            fixed inset-y-0 left-0 z-50
            w-64
            bg-slate-900 text-white
            transform -translate-x-full
            transition-transform duration-300 ease-in-out
            lg:static lg:translate-x-0
            lg:flex-shrink-0
        "
    >

        <!-- Cabeçalho da sidebar -->
        <div class="p-6 border-b border-slate-700">

            <div class="flex items-start justify-between gap-4">

                <div>
                    <h1 class="text-xl font-bold">
                        Tours N Fish
                    </h1>

                    <p class="text-sm text-slate-400">
                        Administração
                    </p>
                </div>

                <!-- Fechar menu mobile -->
                <button
                    type="button"
                    id="admin-menu-close"
                    class="
                        lg:hidden
                        text-slate-300
                        hover:text-white
                        text-2xl
                        leading-none
                    "
                    aria-label="Fechar menu"
                >
                    &times;
                </button>

            </div>

        </div>

        <!-- Navegação -->
        <nav class="p-4 space-y-2">

            <a
                href="{{ route('admin.dashboard') }}"
                class="block px-4 py-2 rounded hover:bg-slate-800"
            >
                Dashboard
            </a>

            <a
                href="{{ route('admin.tours.index') }}"
                class="block px-4 py-2 rounded hover:bg-slate-800"
            >
                Passeios
            </a>

            <a
                href="{{ route('admin.gallery.index') }}"
                class="block px-4 py-2 rounded hover:bg-slate-800"
            >
                Galeria
            </a>

            <a
                href="{{ route('admin.blocked-periods.index') }}"
                class="block px-4 py-2 rounded hover:bg-slate-800"
            >
                Bloqueios
            </a>

            <a
                href="{{ route('admin.reservations.index') }}"
                class="block px-4 py-2 rounded hover:bg-slate-800"
            >
                Reservas
            </a>

            <!-- Logout mobile -->
            <div class="pt-4 mt-4 border-t border-slate-700 lg:hidden">

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button
                        type="submit"
                        class="
                            block w-full
                            px-4 py-2
                            rounded
                            text-left
                            text-red-400
                            hover:bg-slate-800
                            hover:text-red-300
                        "
                    >
                        Terminar sessão
                    </button>
                </form>

            </div>

        </nav>

    </aside>

    <!-- Conteúdo -->
    <main class="flex-1 min-w-0">

        <!-- Header -->
        <header class="bg-white border-b">

            <div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-5">

                <div class="flex items-center justify-between gap-4">

                    <!-- Botão menu mobile -->
                    <button
                        type="button"
                        id="admin-menu-open"
                        class="
                            lg:hidden
                            inline-flex
                            items-center
                            justify-center
                            w-10
                            h-10
                            rounded-md
                            border
                            border-gray-200
                            text-gray-700
                            hover:bg-gray-100
                        "
                        aria-label="Abrir menu"
                        aria-expanded="false"
                    >
                        <span class="text-xl leading-none">☰</span>
                    </button>

                    <h2 class="text-lg sm:text-xl font-semibold">
                        Administração
                    </h2>

                    <!-- Informação do admin desktop -->
                    <div class="hidden lg:flex items-center gap-4">

                        <span>
                            {{ Auth::user()->name }}
                        </span>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button
                                type="submit"
                                class="text-red-600 hover:underline"
                            >
                                Terminar sessão
                            </button>
                        </form>

                    </div>

                    <!-- Espaço para equilibrar o header no mobile -->
                    <div class="lg:hidden w-10"></div>

                </div>

                <!-- Admin mobile -->
                <div class="lg:hidden mt-1 ml-14 text-sm text-gray-500">
                    {{ Auth::user()->name }}
                </div>

            </div>

        </header>

        <!-- Conteúdo da página -->
        <div class="p-4 sm:p-6 lg:p-8">
            @yield('content')
        </div>

    </main>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const sidebar = document.getElementById('admin-sidebar');
        const overlay = document.getElementById('admin-menu-overlay');
        const openButton = document.getElementById('admin-menu-open');
        const closeButton = document.getElementById('admin-menu-close');

        function openMenu() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');

            if (openButton) {
                openButton.setAttribute('aria-expanded', 'true');
            }

            document.body.classList.add('overflow-hidden');
        }

        function closeMenu() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');

            if (openButton) {
                openButton.setAttribute('aria-expanded', 'false');
            }

            document.body.classList.remove('overflow-hidden');
        }

        if (openButton) {
            openButton.addEventListener('click', openMenu);
        }

        if (closeButton) {
            closeButton.addEventListener('click', closeMenu);
        }

        if (overlay) {
            overlay.addEventListener('click', closeMenu);
        }

        /*
         * Fecha o menu ao escolher uma página.
         */
        sidebar.querySelectorAll('nav a').forEach(function (link) {
            link.addEventListener('click', closeMenu);
        });

        /*
         * Se a janela passar novamente para desktop,
         * garante que o estado mobile não fica preso.
         */
        window.addEventListener('resize', function () {
            if (window.innerWidth >= 1024) {
                overlay.classList.add('hidden');
                sidebar.classList.remove('-translate-x-full');
                document.body.classList.remove('overflow-hidden');

                if (openButton) {
                    openButton.setAttribute('aria-expanded', 'false');
                }
            }
        });

    });
</script>

</body>
</html>