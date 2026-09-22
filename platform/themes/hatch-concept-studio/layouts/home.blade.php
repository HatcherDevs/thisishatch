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
    {{-- <div id="horse-scroll-spacer" aria-hidden="true"></div> --}}



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


{!! Theme::partial('footer') !!}
