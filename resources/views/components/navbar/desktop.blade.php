<header class="absolute inset-x-0 top-0 z-50 hidden lg:block">

    <div class="container-custom">

        <div class="grid grid-cols-[auto_1fr_auto] items-center py-8 px-10">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="shrink-0" aria-label="Tours N Fish">

                <x-logo />

            </a>

            {{-- Menu --}}
            <nav class="flex justify-center" aria-label="Navegação Principal">

                <ul class="flex items-center gap-10">

                    <li>
                        <a href="{{ route('home') }}"
                           class="{{ request()->routeIs('home') ? 'nav-link nav-link-active' : 'nav-link' }}">
                            Início
                        </a>
                    </li>

                    <li>
                        <a href="#" class="nav-link">
                            Passeios
                        </a>
                    </li>

                    <li>
                        <a href="#" class="nav-link">
                            Sobre Nós
                        </a>
                    </li>

                    <li>
                        <a href="#" class="nav-link">
                            Galeria
                        </a>
                    </li>

                    <li>
                        <a href="#" class="nav-link">
                            Contactos
                        </a>
                    </li>

                </ul>

            </nav>

            {{-- Ações --}}
            <div class="ml-auto flex items-center gap-5 shrink-0">

                @include('components.navbar.language-switch')

                <a href="#" class="btn-primary">
                    Reservar Agora
                </a>

            </div>

        </div>

    </div>

</header>