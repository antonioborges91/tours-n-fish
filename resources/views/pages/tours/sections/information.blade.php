@php

    $sections = [];
    $current = null;

    $lines = preg_split('/\r\n|\r|\n/', $tour->translation()->important_information ?? '');

    foreach ($lines as $line) {

        $line = trim($line);

        if ($line === '') {
            continue;
        }

        // Novo título
        if (str_ends_with($line, ':')) {

            if ($current) {
                $sections[] = $current;
            }

            $current = [
                'title' => rtrim($line, ':'),
                'items' => [],
            ];

            continue;
        }

        if (!$current) {
            continue;
        }

        $current['items'][] = ltrim($line, "-• ");
    }

    if ($current) {
        $sections[] = $current;
    }

@endphp

@if(count($sections))

<section class="tour-information section-last">

    <div class="container-custom">

        <div class="section-heading">

            <span class="section-badge">

                Informações

            </span>

            <h2 class="section-title">

                Tudo o que precisa de saber

            </h2>

        </div>

        <div class="tour-information-grid">

            @foreach($sections as $section)

                <article class="tour-information-card">

                    <h3>

                        {{ $section['title'] }}

                    </h3>

                    <ul>

                        @foreach($section['items'] as $item)

                            <li>

                                {{ $item }}

                            </li>

                        @endforeach

                    </ul>

                </article>

            @endforeach

        </div>

    </div>

</section>

@endif