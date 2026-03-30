{{-- Page 1: Canvas animation --}}
<div id="page">
    <canvas></canvas>
</div>

{{-- Page 2: Showreel video --}}
<div id="page2">
    <div class="video-custom">
        <div class="play-pause">
            <a class="play-btn btnVideo" id="play_button"><i></i></a>
            <a id="pause_button" class="pause-btn btnVideo"><i></i></a>
        </div>
        <video id="video" width="100%" poster="{{ Theme::asset()->url('imgs/timeline-video.png') }}">
            <source src="{{ Theme::asset()->url('Hatch_Reel 2024_V2.mp4') }}" data-wf-ignore="true" />
        </video>
        <div class="sound-ctrl">
            <img src="" alt="Volume" />
            <button class="off-button" id="sound-off" type="button">OFF</button>
            <button class="on-button" id="sound-on" type="button">ON</button>
        </div>
    </div>
</div>

{{-- Page 3: Swiper projects slider --}}
<div id="page3">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <a href="{{ route('public.single', 'projects') }}" class="slide-inner">
                    <img src="{{ Theme::asset()->url('imgs/projects/project-1.png') }}" alt="Branding and graphic design project by Hatch Concept Studio Dubai" loading="lazy" />
                </a>
            </div>
            <div class="swiper-slide">
                <a href="{{ route('public.single', 'projects') }}" class="slide-inner">
                    <img src="{{ Theme::asset()->url('imgs/projects/project-1.png') }}" alt="Creative campaign project by Hatch Concept Studio Dubai" loading="lazy" />
                </a>
            </div>
            <div class="swiper-slide">
                <a href="{{ route('public.single', 'projects') }}" class="slide-inner">
                    <img src="{{ Theme::asset()->url('imgs/projects/project-1.png') }}" alt="Digital marketing project by Hatch Concept Studio Dubai" loading="lazy" />
                </a>
            </div>
            <div class="swiper-slide">
                <a href="{{ route('public.single', 'projects') }}" class="slide-inner">
                    <img src="{{ Theme::asset()->url('imgs/projects/project-1.png') }}" alt="Logo design project by Hatch Concept Studio Dubai" loading="lazy" />
                </a>
            </div>
            <div class="swiper-slide">
                <a href="{{ route('public.single', 'projects') }}" class="slide-inner">
                    <img src="{{ Theme::asset()->url('imgs/projects/project-1.png') }}" alt="Brand identity design project by Hatch Concept Studio" loading="lazy" />
                </a>
            </div>
            <div class="swiper-slide">
                <a href="{{ route('public.single', 'projects') }}" class="slide-inner">
                    <img src="{{ Theme::asset()->url('imgs/projects/project-1.png') }}" alt="Packaging design project by Hatch Concept Studio" loading="lazy" />
                </a>
            </div>
            <div class="swiper-slide">
                <a href="{{ route('public.single', 'projects') }}" class="slide-inner">
                    <img src="{{ Theme::asset()->url('imgs/projects/project-1.png') }}" alt="Social media marketing project by Hatch Concept Studio" loading="lazy" />
                </a>
            </div>
            <div class="swiper-slide">
                <a href="{{ route('public.single', 'projects') }}" class="slide-inner">
                    <img src="{{ Theme::asset()->url('imgs/projects/project-1.png') }}" alt="Marketing strategy project by Hatch Concept Studio" loading="lazy" />
                </a>
            </div>
        </div>
        <div class="swiper-button-next">
            Next Project
            <i class="fa fa-arrow-right"></i>
        </div>
        <div class="swiper-button-prev">
            <i class="fa fa-arrow-left"></i>
            Previous Project
        </div>
    </div>
</div>

{{-- Page 4: Footer row inside main --}}
<div id="page4">
    <div style="padding-bottom: 20px">
        <footer class="container py-3" role="contentinfo" aria-label="Site footer">
            <div class="row">
                <div class="col-md-6 pt-3">
                    <a href="#" class="custom-link-footer">All copyrights reserved &copy; Hatch Design Services L.L.C. {{ date('Y') }}</a>
                </div>
                <div class="col-md-3 pt-3">
                    <a href="{{ route('public.single', 'privacy-policy') }}" class="custom-link-footer" rel="nofollow">Privacy Policy</a>
                </div>
                <div class="col-md-3 pt-3">
                    <a href="{{ route('public.single', 'terms-and-conditions') }}" class="custom-link-footer" rel="nofollow">Terms &amp; Conditions</a>
                </div>
            </div>
        </footer>
    </div>
</div>

{{-- WebSite Schema with Search --}}
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "WebSite",
    "@@id": "https://thisishatch.com/#website",
    "url": "https://thisishatch.com/",
    "name": "Hatch Concept Studio",
    "description": "Homegrown creative studio helping brands stand out with graphic design, digital marketing, creative campaigns and strategy services in Dubai.",
    "publisher": {
        "@@id": "https://thisishatch.com/#organization"
    },
    "inLanguage": "en-AE"
}
</script>

{{-- LocalBusiness Schema --}}
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "LocalBusiness",
    "@@id": "https://thisishatch.com/#organization",
    "name": "Hatch Concept Studio",
    "legalName": "Hatch Design Services L.L.C.",
    "url": "https://thisishatch.com/",
    "description": "Homegrown creative studio in Dubai, helping brands stand out with impactful graphic design, digital marketing, creative campaigns and strategy services.",
    "logo": "https://thisishatch.com/imgs/hatch_logo_white.png",
    "image": "https://thisishatch.com/imgs/og-image.png",
    "telephone": "",
    "email": "",
    "address": {
        "@@type": "PostalAddress",
        "addressLocality": "Dubai",
        "addressCountry": "AE"
    },
    "geo": {
        "@@type": "GeoCoordinates",
        "latitude": 25.2048,
        "longitude": 55.2708
    },
    "areaServed": ["Dubai", "UAE", "United Arab Emirates"],
    "serviceType": [
        "Graphic Design",
        "Brand Identity Design",
        "Digital Marketing",
        "Social Media Marketing",
        "Website Design",
        "Creative Campaigns",
        "Marketing Strategy",
        "Logo Design",
        "Corporate Branding",
        "Packaging Design"
    ],
    "sameAs": [
        "https://www.instagram.com/thisishatch",
        "https://www.linkedin.com/company/hatch-concept-studio"
    ],
    "hasMap": "https://maps.google.com/?q=Dubai,UAE"
}
</script>

{{-- BreadcrumbList Schema --}}
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "BreadcrumbList",
    "itemListElement": [
        {
            "@@type": "ListItem",
            "position": 1,
            "name": "Home",
            "item": "https://thisishatch.com/"
        }
    ]
}
</script>
