<div id="dog">
    <img id="dogImage" src="{{ Theme::asset()->url('imgs/dog.png') }}"
        alt="Hatch Concept Studio - We dig into design & get our hands dirty" />
    <span class="dog-bubble" id="notification">We dig into design & get our hands dirty.</span>
    <!-- <audio id="notificationSound" src="imgs/mixkit-happy-puppy-barks-741.mp3"></audio> -->
</div>

<div class="layout"></div>
<div class="cursor" style="padding: 15px">
    <span id="playBtn" style="display: none">Play</span>
</div>

<!-- WebSite Schema with Search -->
<script type="application/ld+json" data-cfasync="false">
      {
  "@context": "https://schema.org",
        "@type": "WebSite",
        "@id": "https://thisishatch.com/#website",
        "url": "https://thisishatch.com/",
        "name": "Hatch Concept Studio",
        "description": "Homegrown creative studio helping brands stand out with graphic design, digital marketing, creative campaigns and strategy services in Dubai.",
        "publisher": {
          "@id": "https://thisishatch.com/#organization"
        },
        "inLanguage": "en-AE"
      }
    </script>

<!-- Schema.org Structured Data -->
<script type="application/ld+json" data-cfasync="false">
      {
  "@context": "https://schema.org",
        "@type": "LocalBusiness",
        "@id": "https://thisishatch.com/#organization",
        "name": "Hatch Concept Studio",
        "legalName": "Hatch Design Services L.L.C.",
        "url": "https://thisishatch.com/",
        "description": "Homegrown creative studio in Dubai, helping brands stand out with impactful graphic design, digital marketing, creative campaigns and strategy services.",
        "logo": "https://thisishatch.com/imgs/hatch_logo_white.png",
        "image": "https://thisishatch.com/imgs/og-image.png",
        "telephone": "",
        "email": "",
        "address": {
          "@type": "PostalAddress",
          "addressLocality": "Dubai",
          "addressCountry": "AE"
        },
        "geo": {
          "@type": "GeoCoordinates",
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

<!-- BreadcrumbList schema -->
<script type="application/ld+json" data-cfasync="false">
      {
  "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [
          {
            "@type": "ListItem",
            "position": 1,
            "name": "Home",
            "item": "https://thisishatch.com/"
          }
        ]
      }
    </script>

<script src="{{ Theme::asset()->url('js/locomotive-scroll.js') }}" data-cfasync="false"></script>
<script src="{{ Theme::asset()->url('js/gsap.min.js') }}" data-cfasync="false"></script>
<script src="{{ Theme::asset()->url('js/ScrollTrigger.min.js') }}" data-cfasync="false"></script>
<script src="{{ Theme::asset()->url('js/swiper-bundle.min.js') }}" data-cfasync="false"></script>

<script src="{{ Theme::asset()->url('js/HomePage.js') }}" data-cfasync="false"></script>

@php
    $themeScripts = Theme::asset()->scripts();
    $themeScripts = preg_replace(
        '/<script(?![^>]*data-cfasync)/i',
        '<script data-cfasync="false"',
        $themeScripts ?? '',
    );

    $themeFooter = Theme::footer();
    $themeFooter = preg_replace('/<script(?![^>]*data-cfasync)/i', '<script data-cfasync="false"', $themeFooter ?? '');
@endphp

{!! $themeScripts !!}
{!! $themeFooter !!}
</body>

</html>
