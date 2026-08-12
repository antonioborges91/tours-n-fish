<header
    class="lg:hidden relative w-full z-50"
    x-data="{ open: false }"
    @keydown.escape.window="open = false"
>

    {{-- Mobile Navbar --}}
    <div class="mobile-navbar flex items-center justify-between px-5 py-2 bg-white shadow-sm">

        {{-- Logo --}}
        <a
            href="{{ route('home') }}"
            class="mobile-navbar-logo"
            aria-label="Tours N Fish"
        >
            <img
                src="{{ asset('images/logo/logo.svg') }}"
                alt="Tours N Fish"
            >
        </a>

        {{-- Menu Button --}}
        <button
            id="mobile-menu-button"
            type="button"
            class="mobile-menu-button flex items-center justify-center text-[var(--color-primary-dark)]"
            aria-label="Abrir menu"
            @click="open = !open"
            :aria-expanded="open.toString()"
        >
            {{-- Hamburger --}}
            <svg
                x-show="!open"
                xmlns="http://www.w3.org/2000/svg"
                class="h-7 w-7"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                aria-hidden="true"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16"
                />
            </svg>

            {{-- Close --}}
            <svg
                x-show="open"
                x-cloak
                xmlns="http://www.w3.org/2000/svg"
                class="h-7 w-7"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                aria-hidden="true"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M6 6l12 12M18 6L6 18"
                />
            </svg>
        </button>

    </div>


    {{-- Overlay --}}
    <div
        x-show="open"
        x-cloak
        x-transition:enter="transition-opacity duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="mobile-menu-overlay"
        @click="open = false"
        aria-hidden="true"
    ></div>


    {{-- Mobile Side Menu --}}
    <nav
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-250"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="mobile-side-menu"
        aria-label="Navegação mobile"
    >

        {{-- Menu Header --}}
        <div class="mobile-side-menu-header">

            <span>Menu</span>

            <button
                type="button"
                class="mobile-side-menu-close"
                aria-label="Fechar menu"
                @click="open = false"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M6 6l12 12M18 6L6 18"
                    />
                </svg>
            </button>

        </div>


        {{-- Navigation --}}
        <ul class="mobile-side-menu-links">

            <li>
                <a
                    href="{{ route('home') }}"
                    class="nav-link block py-2 {{ request()->routeIs('home') ? 'nav-link-active' : '' }}"
                >
                    {{ __('navigation.home') }}
                </a>
            </li>

            <li>
                <a
                    href="{{ route('tours') }}"
                    class="nav-link block py-2 {{ request()->routeIs('tours') ? 'nav-link-active' : '' }}"
                >
                    {{ __('navigation.tours') }}
                </a>
            </li>

            <li>
                <a
                    href="{{ route('about') }}"
                    class="nav-link block py-2 {{ request()->routeIs('about') ? 'nav-link-active' : '' }}"
                >
                    {{ __('navigation.about') }}
                </a>
            </li>

            <li>
                <a
                    href="{{ route('gallery') }}"
                    class="nav-link block py-2 {{ request()->routeIs('gallery') ? 'nav-link-active' : '' }}"
                >
                    {{ __('navigation.gallery') }}
                </a>
            </li>

            <li>
                <a
                    href="{{ route('contact') }}"
                    class="nav-link block py-2 {{ request()->routeIs('contact') ? 'nav-link-active' : '' }}"
                >
                    {{ __('navigation.contact') }}
                </a>
            </li>

        </ul>


        {{-- Menu Footer --}}
        <div class="mobile-side-menu-footer">

            {{-- Idioma --}}
            <div class="mobile-side-menu-language">
                @include('components.navbar.language-switch')
            </div>

            {{-- Reservar --}}
            <a
                href="#"
                class="btn-primary mobile-side-menu-book"
                @click="open = false"
            >
                {{ __('navigation.book_now') }}
            </a>

            {{-- Frase --}}
            <span class="mobile-side-menu-note">
                Viva o mar. Sinta os Açores.
            </span>

        </div>

    </nav>

</header>