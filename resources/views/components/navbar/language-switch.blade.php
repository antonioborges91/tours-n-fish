<div class="language-switch">

    @if(app()->getLocale() === 'pt')

        <span class="active">PT</span>

        <span class="divider"></span>

        <a href="{{ route('language.switch', 'en') }}">EN</a>

    @else

        <a href="{{ route('language.switch', 'pt') }}">PT</a>

        <span class="divider"></span>

        <span class="active">EN</span>

    @endif

</div>