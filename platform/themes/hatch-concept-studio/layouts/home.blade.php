@php
    use Botble\Theme\Facades\Theme;
 Theme::addBodyAttributes(['class' => 'home-page']);
    Theme::asset()
        // ->container('before_header')
        // ->container('after_header')
        ->usePath(false)
        ->add('home-locomotive-css', 'themes/hatch-concept-studio/css/locomotive-scroll.css')
        ->add('home-swiper-css', 'themes/hatch-concept-studio/css/swiper-bundle.min.css')
        ->add('home-slider-3d-css', 'themes/hatch-concept-studio/css/slider3D.css')
        ->add('home-style-css', 'themes/hatch-concept-studio/css/style.css')
        ->add('home-sections-css', 'themes/hatch-concept-studio/css/home-sections.css');
@endphp


{!! Theme::partial('header') !!}









<span class="click_graphics at mouseMove_hover" data-speed="2">
    <img width="100%" src="{{ Theme::asset()->url('imgs/click_graphics/at.png') }}"
        alt="Creative agency Dubai social media marketing" />
</span>
<span class="click_graphics click mouseMove_hover" data-speed="4">
    <img width="100%" src="{{ Theme::asset()->url('imgs/click_graphics/click.png') }}"
        alt="Digital marketing agency Dubai click engagement" />
</span>
<span class="click_graphics text mouseMove_hover" data-speed="6">
    <img width="100%" src="{{ Theme::asset()->url('imgs/click_graphics/text.png') }}"
        alt="Brand identity design and content marketing Dubai" />
</span>
<span class="click_graphics like mouseMove_hover" data-speed="8">
    <img width="100%" src="{{ Theme::asset()->url('imgs/click_graphics/like.png') }}"
        alt="Social media marketing and brand engagement Dubai" />
</span>
<span class="click_graphics hashtah mouseMove_hover" data-speed="10">
    <img width="100%" src="{{ Theme::asset()->url('imgs/click_graphics/hashtah.png') }}"
        alt="Integrated marketing campaigns creative agency Dubai" />
</span>
<div id="page">

    <canvas></canvas>


</div>
<div class="hero-scroll-indicator" aria-hidden="true">
    <span class="hero-scroll-indicator-text">SCROLL FOR MORE</span>
    <span class="hero-scroll-indicator-mouse">
        <span class="hero-scroll-indicator-wheel"></span>
    </span>
    <span class="hero-scroll-indicator-arrow">&#8595;</span>
</div>





{{-- <div class="hero-scroll-indicator" aria-hidden="true">
    <span class="hero-scroll-indicator-text">SCROLL FOR MORE</span>
    <span class="hero-scroll-indicator-mouse">
        <span class="hero-scroll-indicator-wheel"></span>
    </span>
    <span class="hero-scroll-indicator-arrow">&#8595;</span>
</div> --}}


<div id="main">
    <div id="horse-scroll-spacer" aria-hidden="true"></div>



    <div class="home-overlay-stack">
        {!! Theme::loadView('index') !!}




        <div id="page4">
            <footer class="home-footer">
                <div class="home-footer-inner">
                    <nav class="home-footer-links" aria-label="Footer">
                        @php
                            $copyright = Theme::getSiteCopyright();
                            $privacyUrl = Theme::privacyPolicyUrl();
                            $termsUrl = Theme::termsOfServiceUrl();
                        @endphp

                        <span class="home-footer-link">
                            {!! $copyright ?: 'All copyrights reserved &copy; Hatch Design Services L.L.C. ' . date('Y') !!}
                        </span>

                        @if ($privacyUrl)
                            <a href="{{ $privacyUrl }}" class="home-footer-link" rel="nofollow noopener noreferrer"
                                target="_blank">
                                Privacy Policy
                            </a>
                        @endif

                        @if ($termsUrl)
                            <a href="{{ $termsUrl }}" class="home-footer-link" rel="nofollow noopener noreferrer"
                                target="_blank">
                                Terms &amp; Conditions
                            </a>
                        @endif
                    </nav>
                </div>
            </footer>
        </div>
    </div>

</div>



<div class="cursor" style="padding: 15px">
    <span id="playBtn" style="display: none">Play</span>
</div>

@php

    Theme::asset()
        ->container('footer')
        ->usePath(false)
        ->add('home-locomotive-js', 'themes/hatch-concept-studio/js/locomotive-scroll.js')
        ->add('home-gsap-js', 'themes/hatch-concept-studio/js/gsap.min.js')
        ->add('home-scroll-trigger-js', 'themes/hatch-concept-studio/js/ScrollTrigger.min.js', ['home-gsap-js'])
        ->add('home-scroll-effects-js', 'themes/hatch-concept-studio/js/scroll-effects.js', ['scroll-effects-js'])
        ->add('home-swiper-js', 'themes/hatch-concept-studio/js/swiper-bundle.min.js')
        ->add('home-page-js', 'themes/hatch-concept-studio/js/HomePage.js', ['HomePage.js' ]);

@endphp
{!! Theme::partial('footer') !!}
