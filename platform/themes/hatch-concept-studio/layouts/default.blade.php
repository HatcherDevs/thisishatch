@php
    use Botble\Theme\Facades\Theme;

    $assets = Theme::asset()->usePath(false);

    /*
    |--------------------------------------------------------------------------
    | About page
    |--------------------------------------------------------------------------
    */

    if (request()->is('about')) {
        $assets

            ->add('about-css', 'themes/hatch-concept-studio/css/about.css')
            ->add('about-js', 'themes/hatch-concept-studio/css/bootstrap.min.css');
    }

    /*
    |--------------------------------------------------------------------------
    | Projects listing page
    |--------------------------------------------------------------------------
    */

    if (request()->is('projects')) {
        $assets
            ->add('about-js', 'themes/hatch-concept-studio/css/bootstrap.min.css')
            ->add('about-css', 'themes/hatch-concept-studio/css/about.css')
            ->add('projects-css', 'themes/hatch-concept-studio/css/projects.css');
    }

    /*
    |--------------------------------------------------------------------------
    | Single project page
    |--------------------------------------------------------------------------
    */

    if (request()->is('projects/*')) {
        $assets
            ->add('project-details-css', 'themes/hatch-concept-studio/css/project-details.css')
            ->add('project-details-js', 'themes/hatch-concept-studio/js/project-details.js');
    }
@endphp







{!! Theme::partial('header') !!}


<div id="main" style="padding-top: 132px;">
    <div class="container w-md-75">

        {!! Theme::content() !!}
    </div>



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
</div>



@php
    $footerAssets = Theme::asset()->container('footer')->usePath(false);

    if (request()->is('about')) {
        $footerAssets
            ->add('about-popper-js', 'themes/hatch-concept-studio/js/popper.min.js')
            ->add('about-bootstrap-js', 'themes/hatch-concept-studio/js/bootstrap.min.js', ['about-popper-js'])
            ->add('about-js', 'themes/hatch-concept-studio/js/about.js', ['about-bootstrap-js']);
    }

    if (request()->is('projects')) {
        $footerAssets
            ->add('projects-popper-js', 'themes/hatch-concept-studio/js/popper.min.js')
            ->add('projects-bootstrap-js', 'themes/hatch-concept-studio/js/bootstrap.min.js', ['projects-popper-js'])
            ->add('projects-js', 'themes/hatch-concept-studio/js/about.js', ['projects-bootstrap-js'])
            ->add('projects-js', 'themes/hatch-concept-studio/js/projects.js', ['projects-bootstrap-js']);
    }

    if (request()->is('projects/*')) {
        $footerAssets->add('project-details-js', 'themes/hatch-concept-studio/js/project-details.js');
    }
@endphp


{!! Theme::partial('footer') !!}
