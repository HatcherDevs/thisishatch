@php
    use Botble\Theme\Facades\Theme;

    $assets = Theme::asset()->usePath(false);
    $assets
        ->add(
            'about-js',
            'themes/hatch-concept-studio/css/bootstrap.min.css',
            version: theme_asset_version('css/bootstrap.min.css'),
        )
        ->add('about-css', 'themes/hatch-concept-studio/css/about.css', version: theme_asset_version('css/about.css'))
        ->add(
            'contact-swiper-css',
            'themes/hatch-concept-studio/css/swiper-bundle.min.css',
            version: theme_asset_version('css/swiper-bundle.min.css'),
        )
        ->add(
            'projects-css',
            'themes/hatch-concept-studio/css/project-details-2.css',
            version: theme_asset_version('css/project-details-2.css'),
        );

@endphp

{!! Theme::partial('header') !!}

<main id="main" class="pd2-page" style="padding-top: 132px;" data-fixed-padding-top>
    {!! Theme::content() !!}
</main>
<div id="page4">
    <div class="site-footer-inner">
        <footer class="container py-3" role="contentinfo" aria-label="Site footer">
            @php
                $copyright = Theme::getSiteCopyright();
                $privacyUrl = Theme::privacyPolicyUrl();
                $termsUrl = Theme::termsOfServiceUrl();
            @endphp
            <div class="row">
                <div class="col-md-6 pt-3">
                    <span class="custom-link-footer">
                        {!! $copyright ?: 'All copyrights reserved &copy;Hatch Design Services L.L.C. ' . date('Y') !!}
                    </span>
                </div>
                <div class="col-md-3 pt-3">
                    @if ($privacyUrl)
                        <a href="{{ $privacyUrl }}" class="custom-link-footer" rel="nofollow noopener noreferrer"
                            target="_blank">Privacy Policy</a>
                    @endif
                </div>
                <div class="col-md-3 pt-3">
                    @if ($termsUrl)
                        <a href="{{ $termsUrl }}" class="custom-link-footer" rel="nofollow noopener noreferrer"
                            target="_blank">Terms &amp; Conditions</a>
                    @endif
                </div>
            </div>
        </footer>
    </div>
</div>
<div class="cursor">
    <span id="playBtn">Play</span>
</div>
@php
    $footerAssets = Theme::asset()->container('footer')->usePath(false);

    $footerAssets
        ->add(
            'site-popper-js',
            'themes/hatch-concept-studio/js/popper.min.js',
            version: theme_asset_version('js/popper.min.js'),
        )
        ->add(
            'site-bootstrap-js',
            'themes/hatch-concept-studio/js/bootstrap.min.js',
            ['site-popper-js'],
            version: theme_asset_version('js/bootstrap.min.js'),
        )
        ->add(
            'site-gsap-js',
            'themes/hatch-concept-studio/js/gsap.min.js',
            version: theme_asset_version('js/gsap.min.js'),
        )
        ->add(
            'site-scroll-trigger-js',
            'themes/hatch-concept-studio/js/ScrollTrigger.min.js',
            ['site-gsap-js'],
            version: theme_asset_version('js/ScrollTrigger.min.js'),
        )
        ->add(
            'site-swiper-js',
            'themes/hatch-concept-studio/js/swiper-bundle.min.js',
            version: theme_asset_version('js/swiper-bundle.min.js'),
        )
        ->add(
            'about-page-js',
            'themes/hatch-concept-studio/js/about.js',
            ['site-bootstrap-js'],
            version: theme_asset_version('js/about.js'),
        )
        ->add(
            'project-scroll-effects-js',
            'themes/hatch-concept-studio/js/scroll-effects.js',
            ['site-gsap-js', 'site-scroll-trigger-js'],
            [],
            theme_asset_version('js/scroll-effects.js'),
        )
        ->add(
            'project-details-js',
            'themes/hatch-concept-studio/js/project-details-2.js',
            [
                'site-bootstrap-js',
                'site-gsap-js',
                'site-scroll-trigger-js',
                'site-swiper-js',
                'project-scroll-effects-js',
            ],
            version: theme_asset_version('js/project-details-2.js'),
        );
@endphp
{!! Theme::partial('footer') !!}
