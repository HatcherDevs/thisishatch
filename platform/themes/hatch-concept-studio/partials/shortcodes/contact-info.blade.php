@php
    $heading = $shortcode->heading ?: "Don't be shy";
    $email = $shortcode->email ?: 'info@thisishatch.com';

    $dubaiLabel = $shortcode->dubai_label ?: 'Dubai';
    $dubaiAddress = $shortcode->dubai_address ?: 'Office B103, Bldg 6, Dubai Design District, Dubai, UAE';
    $dubaiPhoneText = $shortcode->dubai_phone_text ?: '+971 (04) 4247 795';
    $dubaiPhoneLink = preg_replace('/\s+/', '', (string) ($shortcode->dubai_phone_link ?: '+971044247795'));

    $cairoLabel = trim((string) ($shortcode->cairo_label ?? ''));
    $cairoAddress = trim((string) ($shortcode->cairo_address ?? ''));

    $behanceUrl = $shortcode->behance_url ?: '#';
    $instagramUrl = $shortcode->instagram_url ?: '#';
    $linkedinUrl = $shortcode->linkedin_url ?: '#';

    $arrowIcon = Theme::asset()->url('imgs/projects/Arrow.png');
@endphp

@once
    <link rel="stylesheet" href="{{ Theme::asset()->url('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ Theme::asset()->url('css/about.css') }}">
@endonce

<div class="container pt-5 mt-5" id="contact">
    <div class="row">
        <div class="col-md-7">
            <h2 class="contact_h2">{{ $heading }}</h2>
            <a class="mailto" href="mailto:{{ $email }}">{{ $email }}</a>
        </div>
        <div class="col-md-5">
            <div>
                <div class="dubai-info d-flex justify-content-between mt-5 pb-3">
                    <span>{{ $dubaiLabel }}</span>
                    <span>
                        {!! nl2br(e($dubaiAddress)) !!}<br />
                        <a class="custom-link-footer" href="tel:{{ $dubaiPhoneLink }}">{{ $dubaiPhoneText }}</a>
                    </span>
                </div>

                @if (trim((string) $cairoAddress) !== '')
                    <div class="dubai-info d-flex justify-content-between pt-4" style="border-top: 1px solid #0514f0">
                        <span>{{ $cairoLabel !== '' ? $cairoLabel : 'Cairo' }}</span>
                        <span>{!! nl2br(e($cairoAddress)) !!}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="container mt-5">
    <div class="container py-3 w-lg-25 w-sm-50 w-md-50 d-flex justify-content-between float-start">
        <a href="{{ $behanceUrl }}" target="_blank" rel="noopener noreferrer" class="custom-link-footer">
            <img id="arrow" width="15" src="{{ $arrowIcon }}" alt="Behance" />
            <span>Behance</span>
        </a>
        <a href="{{ $instagramUrl }}" target="_blank" rel="noopener noreferrer" class="custom-link-footer">
            <img id="arrow" width="15" src="{{ $arrowIcon }}" alt="Instagram" />
            <span>Instagram</span>
        </a>
        <a href="{{ $linkedinUrl }}" target="_blank" rel="noopener noreferrer" class="custom-link-footer active">
            <img id="arrow" width="15" src="{{ $arrowIcon }}" alt="LinkedIn" />
            <span>LinkedIn</span>
        </a>
    </div>
    <div class="clearfix"></div>
</div>
