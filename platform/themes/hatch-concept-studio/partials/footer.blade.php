    {{-- Bootstrap footer: shown on inner pages only --}}
    @if (!request()->is('/') && !request()->is(''))
        <footer class="container py-3" role="contentinfo" aria-label="Site footer">
            <div class="row">
                <div class="col-md-6 pt-3">
                    <a href="#" class="custom-link-footer">All copyrights reserved &copy; Hatch Design Services
                        L.L.C. {{ date('Y') }}</a>
                </div>
                <div class="col-md-3 pt-3">
                    <a href="{{ route('public.single', 'privacy-policy') }}" class="custom-link-footer"
                        rel="nofollow">Privacy Policy</a>
                </div>
                <div class="col-md-3 pt-3">
                    <a href="{{ route('public.single', 'terms-and-conditions') }}" class="custom-link-footer"
                        rel="nofollow">Terms &amp; Conditions</a>
                </div>
            </div>
        </footer>
    @endif

    {{-- Dog mascot --}}
    <div id="dog">
        <img id="dogImage" src="{{ Theme::asset()->url('imgs/dog.png') }}"
            alt="Hatch Concept Studio - We dig into design &amp; get our hands dirty" />
        <span class="dog-bubble" id="notification">We dig into design &amp; get our hands dirty.</span>
        <audio id="notificationSound" src="{{ Theme::asset()->url('imgs/mixkit-happy-puppy-barks-741.mp3') }}"></audio>
    </div>

    <div class="layout"></div>
    <div class="cursor" style="padding: 15px">
        <span id="playBtn" style="display: none">Play</span>
    </div>

    @if (request()->is('/') || request()->is(''))
        {{-- Homepage JS --}}
        <script src="{{ Theme::asset()->url('js/locomotive-scroll.js') }}"></script>
        <script src="{{ Theme::asset()->url('js/gsap.min.js') }}"></script>
        <script src="{{ Theme::asset()->url('js/ScrollTrigger.min.js') }}"></script>
        <script src="{{ Theme::asset()->url('js/swiper-bundle.min.js') }}"></script>
        <script src="{{ Theme::asset()->url('js/HomePage.js') }}"></script>
    @else
        {{-- Inner pages JS --}}
        <script src="{{ Theme::asset()->url('js/popper.min.js') }}"></script>
        <script src="{{ Theme::asset()->url('js/bootstrap.min.js') }}"></script>
        @if (request()->is('store*') || request()->is('project-details*'))
            <script src="{{ Theme::asset()->url('js/swiper-bundle.min.js') }}"></script>
        @endif
        <script src="{{ Theme::asset()->url('js/about.js') }}"></script>
    @endif

    {!! Theme::asset()->scripts() !!}
    {!! Theme::footer() !!}
    </body>

    </html>
