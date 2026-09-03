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
                            {{ __('navigation.home') }}
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('tours') }}"
                           class="{{ request()->routeIs('tours') ? 'nav-link nav-link-active' : 'nav-link' }}">
                            {{ __('navigation.tours') }}
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('about') }}"
                           class="{{ request()->routeIs('about') ? 'nav-link nav-link-active' : 'nav-link' }}">
                            {{ __('navigation.about') }}
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('gallery') }}"
                           class="{{ request()->routeIs('gallery') ? 'nav-link nav-link-active' : 'nav-link' }}">
                            {{ __('navigation.gallery') }}
                        </a>
                    </li>

                    <li>
                        <a
                            href="{{ route('contact') }}"
                            class="{{ request()->routeIs('contact') ? 'nav-link nav-link-active' : 'nav-link' }}">

                            {{ __('navigation.contact') }}

                        </a>
                    </li>

                </ul>

            </nav>

            {{-- Ações --}}
            <div class="ml-auto flex items-center gap-5 shrink-0">

                @include('components.navbar.language-switch')

                <a href="{{ route('tours') }}" class="btn-primary">
                    {{ __('navigation.book_now') }}
                </a>

            </div>

        </div>

    </div>

</header>