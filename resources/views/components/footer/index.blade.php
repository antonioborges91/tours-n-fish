<section class="footer-wrapper">

    <footer class="footer">

        <div class="container-custom">

            <div class="footer-grid">

                <div class="footer-brand">

                    <img
                        src="{{ asset('images/logo/logo_branco.webp') }}"
                        alt="Tours N Fish">

                </div>

                <div class="footer-contact">

                    <h3>{{ __('footer.contact') }}</h3>

                    <ul>

                        <li>
                            <x-lucide-phone class="footer-icon"/>
                            +351 913 488 511
                        </li>

                        <li>
                            <x-lucide-mail class="footer-icon"/>
                            geral@toursnfish.pt
                        </li>

                        <li>
                            <x-lucide-map-pin class="footer-icon"/>
                            {{ __('footer.location') }}
                        </li>

                    </ul>

                </div>

                <div class="footer-social">

                    <h3>{{ __('footer.follow_us') }}</h3>

                    <div class="footer-social-links">

                        <a href="#" aria-label="Facebook">
                            <x-lucide-facebook/>
                        </a>

                        <a href="#" aria-label="Instagram">
                            <x-lucide-instagram/>
                        </a>

                    </div>

                </div>

            </div>

            <div class="footer-bottom">

                <span>
                    © {{ date('Y') }} Tours N Fish
                </span>

                <div class="footer-links">

                    <a href="#">
                        {{ __('footer.privacy_policy') }}
                    </a>

                    <a href="#">
                        {{ __('footer.terms_conditions') }}
                    </a>

                </div>

            </div>

        </div>

    </footer>

</section>