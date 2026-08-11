<header
    class="lg:hidden relative w-full z-50"
    x-data="{ open: false }"
>
    {{-- Mobile Navbar --}}
    <div class="flex items-center justify-between px-5 py-2 bg-white shadow-sm">

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
            class="flex items-center justify-center text-[var(--color-primary-dark)]"
            aria-label="Abrir menu"
            @click="open = !open"
            :aria-expanded="open.toString()"
        >
            <svg
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
        </button>

    </div>

    {{-- Mobile Menu --}}
    <nav
        x-show="open"
        x-transition
        class="bg-white shadow-md"
        aria-label="Navegação mobile"
    >
        <ul class="flex flex-col px-5 py-3">

            <li>
                <a
                    href="{{ route('home') }}"
                    class="nav-link block py-2"
                >
                    {{ __('navigation.home') }}
                </a>
            </li>

            <li>
                <a
                    href="{{ route('tours') }}"
                    class="nav-link block py-2"
                >
                    {{ __('navigation.tours') }}
                </a>
            </li>

            <li>
                <a
                    href="{{ route('about') }}"
                    class="nav-link block py-2"
                >
                    {{ __('navigation.about') }}
                </a>
            </li>

            <li>
                <a
                    href="{{ route('gallery') }}"
                    class="nav-link block py-2"
                >
                    {{ __('navigation.gallery') }}
                </a>
            </li>

            <li>
                <a
                    href="{{ route('contact') }}"
                    class="nav-link block py-2"
                >
                    {{ __('navigation.contact') }}
                </a>
            </li>

            <li class="pt-2">
                <a
                    href="#"
                    class="btn-primary w-full justify-center"
                >
                    {{ __('navigation.book_now') }}
                </a>
            </li>

        </ul>
    </nav>
</header>