@php
    $leftLines = $shortcode->left_description
        ? preg_split('/\r\n|\r|\n/', trim($shortcode->left_description))
        : [];

    $leftLines = array_values(array_filter(array_map('trim', $leftLines)));

    $rightImage = $shortcode->right_image ?? null;
    $rightImageUrl = $rightImage
        ? RvMedia::getImageUrl($rightImage)
        : null;

    $rightLines = $shortcode->right_description
        ? preg_split('/\r\n|\r|\n/', trim($shortcode->right_description))
        : [];

    $rightLines = array_values(array_filter(array_map('trim', $rightLines)));

    $rightHref = $shortcode->right_href ?? '#';
@endphp

@if (!empty($leftLines) || !empty($rightLines))
    <section class="home-cta-section" aria-label="Get in touch">
        <div class="home-cta-inner">

            @if (!empty($leftLines))
                <h2 class="home-cta-headline">
                    @foreach ($leftLines as $index => $line)
                        @php
                            $isLastLine = $index === count($leftLines) - 1;
                            $lineClass = $isLastLine ? 'line-orange' : 'line-white';
                        @endphp

                        <span class="line {{ $lineClass }}">{{ $line }}</span>
                    @endforeach
                </h2>
            @endif

            @if (!empty($rightLines))
                <a href="{{ $rightHref }}" class="home-cta-action">
                    <span class="home-cta-action-text">
                        @foreach ($rightLines as $index => $line)
                            @php
                                $isLastLine = $index === count($rightLines) - 1;
                                $lineClass = $isLastLine ? 'line-bottom' : 'line-top';
                            @endphp

                            <span class="line {{ $lineClass }}">
                                @if ($isLastLine)
                                    <img
                                        class="home-cta-action-icon"
                                        src="{{ $rightImageUrl }}"
                                        alt=""
                                        aria-hidden="true"
                                    />
                                @endif

                                {{ $line }}
                            </span>
                        @endforeach
                    </span>
                </a>
            @endif

        </div>
    </section>
@endif