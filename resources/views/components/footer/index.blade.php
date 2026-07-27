<section class="footer-wrapper">

    <footer class="footer">

        <div class="container-custom">

            <div class="footer-grid">

                <div class="footer-brand">

                    <img
                        src="{{ asset('images/logo.webp') }}"
                        alt="Tours N Fish">

                </div>

                <div class="footer-contact">

                    <h3>Contactos</h3>

                    <ul>

                        <li>
                            <x-lucide-phone class="footer-icon"/>
                            +351 000 000 000
                        </li>

                        <li>
                            <x-lucide-mail class="footer-icon"/>
                            geral@toursnfish.pt
                        </li>

                        <li>
                            <x-lucide-map-pin class="footer-icon"/>
                            Ponta Delgada, São Miguel
                        </li>

                    </ul>

                </div>

                <div class="footer-social">

                    <h3>Siga-nos</h3>

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
                        Política de Privacidade
                    </a>

                    <a href="#">
                        Termos e Condições
                    </a>

                </div>

            </div>

        </div>

    </footer>

</section>