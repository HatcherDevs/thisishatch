@if (theme_option('dog_enabled', 'yes') === 'yes')
    @php
        $dogMessages = preg_split(
            '/\r\n|\r|\n/',
            (string) theme_option('dog_messages', 'We dig into design & get our hands dirty.'),
        );
        $dogMessages = array_values(array_filter(array_map('trim', $dogMessages)));
        $dogMessages = array_map(
            static fn(string $message): string => html_entity_decode($message, ENT_QUOTES | ENT_HTML5, 'UTF-8'),
            $dogMessages,
        );

        if ($dogMessages === []) {
            $dogMessages = ['We dig into design & get our hands dirty.'];
        }

        $dogLoopMessages = theme_option('dog_loop_messages', 'yes') === 'yes';
    @endphp
    <div id="dog" data-dog-messages='@json($dogMessages)'
        data-dog-loop="{{ $dogLoopMessages ? 'yes' : 'no' }}">
        <img id="dogImage" src="{{ Theme::asset()->url('imgs/dog.png') }}"
            alt="Hatch Concept Studio - We dig into design & get our hands dirty" />
        <span class="dog-bubble" id="notification">{{ $dogMessages[0] }}</span>
        <!-- <audio id="notificationSound" src="imgs/mixkit-happy-puppy-barks-741.mp3"></audio> -->
    </div>

    
@endif

<div class="layout"></div>

<!-- WebSite Schema with Search -->
<script type="application/ld+json">
      {
        "@@context": "https://schema.org",
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
<script type="application/ld+json">
      {
        "@@context": "https://schema.org",
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
<script type="application/ld+json">
      {
        "@@context": "https://schema.org",
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




@php
    Theme::asset()
        ->container('footer')
        ->usePath(false)
        ->add('preloader-js', 'themes/hatch-concept-studio/js/preloader.js')
        ->add('dog-notification-js', 'themes/hatch-concept-studio/js/dog-notification.js')
        ->add('menu-js', 'themes/hatch-concept-studio/js/menu.js');
@endphp

{!! Theme::asset()->scripts() !!}
{!! Theme::footer() !!}
</body>

</html>
