<section class="popular-tours">

    <div class="container-custom">

        <div class="section-heading">

            <span class="section-subtitle">
                Passeios Populares
            </span>

            <h2 class="section-title">
                Escolha a sua aventura
            </h2>

        </div>

        <div class="popular-tours-grid">

            @for($i = 0; $i < 4; $i++)

                <article class="tour-card">

                    <div class="tour-card-image"></div>

                    <div class="tour-card-content">

                        <h3>Nome do Passeio</h3>

                        <div class="tour-card-meta">

                            <span>⏱ 3 h</span>

                            <span>👥 Até 6 pessoas</span>

                        </div>

                        <div class="tour-card-footer">

                            <div>

                                <small>Desde</small>

                                <strong>
                                    €45
                                    <span>/ pessoa</span>
                                </strong>

                            </div>

                            <a href="#">
                                Saber mais →
                            </a>

                        </div>

                    </div>

                </article>

            @endfor

        </div>

        <div class="popular-tours-action">

            <a href="#" class="btn btn-primary">
                Ver todos os passeios
            </a>

        </div>

    </div>

</section>