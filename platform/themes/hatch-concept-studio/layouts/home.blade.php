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

<div id="main">
    {!! Theme::loadView('index') !!}




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
