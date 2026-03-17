<div class="widget-site-logo">
    @if($logo = theme_option('site_logo'))
        <a href="{{ route('public.index') }}">
            <img src="{{ RvMedia::getImageUrl($logo) }}" alt="{{ theme_option('site_title') }}" class="site-logo">
        </a>
    @else
        <a href="{{ route('public.index') }}">
            <h2>{{ theme_option('site_title') }}</h2>
        </a>
    @endif
</div>