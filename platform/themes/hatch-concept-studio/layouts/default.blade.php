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

{!! Theme::partial('footer') !!}
