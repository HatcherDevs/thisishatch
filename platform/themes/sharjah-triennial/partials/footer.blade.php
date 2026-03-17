<!-- Footer Section -->
<footer class="top_padding_categories event-section pb-4 mt-4">
    <div class="footer-box">
        <div class="row">
            <div class="col-md-5">
                <div style="height: 100%; position: relative">
                    <div>
                        <!-- Newsletter Section -->
                        @if (is_plugin_active('newsletter'))
                            <div class="footer-news-title">
                                {{ isArabic() ? 'اشترك للحصول على أخبارنا' : 'SIGN UP TO GET OUR NEWS' }}</div>
                            {!! Theme::partial('newsletter-form') !!}
                        @endif

                        <!-- Address -->
                        @if (theme_option('site_title'))
                            <div class="footer-address">
                                {{ theme_option('site_title', 'Sharjah Architecture Triennial') }}<br />
                            </div>
                        @endif

                        <!-- Contact -->
                        @if (theme_option('site_email') || theme_option('site_phone'))
                            <div class="footer-contact">
                                {{ isArabic() ? 'للاستفسارات العامة اتصل بنا:' : 'For general inquiries contact:' }}<br />
                                @if (theme_option('site_email'))
                                    {{ isArabic() ? 'البريد الإلكتروني' : 'E' }}: <a
                                        href="mailto:{{ theme_option('site_email', 'info@sharjaharchitecture.org') }}">
                                        {{ theme_option('site_email', 'info@sharjaharchitecture.org') }}
                                    </a><br />
                                @endif
                                @if (theme_option('site_phone'))
                                    {{ isArabic() ? 'الهاتف' : 'T' }}: <span
                                        dir="ltr">{{ theme_option('site_phone', '+ 971 6 5262201') }}</span>
                                @endif
                            </div>
                        @endif

                        <!-- Social Links -->
                        @if (theme_option('social_instagram') ||
                                theme_option('social_facebook') ||
                                theme_option('social_twitter') ||
                                theme_option('social_linkedin'))
                            <div class="footer-social-links mt-md-5">
                                @if ($instagram = theme_option('social_instagram'))
                                    <a class="text-decoration-none text-dark" href="{{ $instagram }}"
                                        target="_blank">
                                        <i class="fa fa-arrow-{{ isRTL() ? 'left' : 'right' }}"></i> Instagram
                                    </a><br />
                                @endif
                                @if ($facebook = theme_option('social_facebook'))
                                    <a class="text-decoration-none text-dark" href="{{ $facebook }}"
                                        target="_blank">
                                        <i class="fa-solid fa-arrow-{{ isRTL() ? 'left' : 'right' }}"></i> Facebook
                                    </a><br />
                                @endif
                                @if ($twitter = theme_option('social_twitter'))
                                    <a class="text-decoration-none text-dark" href="{{ $twitter }}"
                                        target="_blank">
                                        <i class="fa-solid fa-arrow-{{ isRTL() ? 'left' : 'right' }}"></i> X
                                    </a><br />
                                @endif
                                @if ($linkedin = theme_option('social_linkedin'))
                                    <a class="text-decoration-none text-dark" href="{{ $linkedin }}"
                                        target="_blank">
                                        <i class="fa-solid fa-arrow-{{ isRTL() ? 'left' : 'right' }}"></i> LinkedIn
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Copyright -->
                    @if (theme_option('copyright'))
                        <div style="position: absolute; bottom: 0">
                            <div class="footer-bottom-row">
                                <div class="footer-copyright">
                                    {{-- {{ theme_option('copyright', '  © Sharjah Architecture Triennial {{ date('Y') }}. All Rights Reserved.') }} --}}

                                    @php
                                        // Replace the Blade date placeholder with the current year if present in theme options.
                                        $copyrightRaw = theme_option('copyright');

                                        // Match variations like {{ date('Y') }} or {{ date('Y') }}
                                        $copyright = preg_replace(
                                            '/\{\{\s*date\(["\']Y["\']\)\s*\}\}/',
                                            date('Y'),
                                            $copyrightRaw,
                                        );
                                    @endphp

                                    {{-- Output as raw HTML in case theme text contains markup; theme options should be trusted here. --}}
                                    {!! $copyright !!}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Terms & Conditions -->
                <div class="col-md-1" style="display: flex; align-items: end; justify-content: end">
                    <div class="footer-bottom-row">
                        <div class="footer-copyright">
                             @if ($termsUrl = theme_option('term_and_privacy_policy_url'))
                            <a href="{{ $termsUrl }}"
                                class="footer-terms text-decoration-none text-dark footer-copyright">
                                {{ isArabic() ? 'الشروط والأحكام' : 'Terms and Conditions' }}
                            </a>
                                 @endif
                        </div>
                    </div>
                </div>
        

            <!-- Map Section -->
            @if (theme_option('default_map_center_lng') && theme_option('default_map_center_lat'))
                <div class="col-md-6 footer-map">
                    <div class="footer-map-img-wrap position-relative" style="width: 100%; height: 350px">
                        <div id="footer-map" style="width: 100%; height: 100%"></div>
                    </div>


                    <div class="d-flex w-100 justify-content-between footer-address_underMap" style="max-width: 80%">
                        <div class="fw-medium">{{ theme_option('site_title', 'Sharjah Architecture Triennial') }}</div>
                        <div>
                            {!! str_replace(
                                ',,',
                                '<br />',
                                e(
                                    theme_option(
                                        'site_address',
                                        'Al Qasimiya School,, Sheikh Saqr Bin Khalid Al Qasimi St,, Al Manakh, Sharjah, UAE',
                                    ),
                                ),
                            ) !!}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @php
        // dump(theme_option()->getOptions());
    @endphp
    @if (theme_option('default_map_center_lng') && theme_option('default_map_center_lat'))
        <script>
            window.footerMapCoords = {
                lng: {{ theme_option('default_map_center_lng') }},
                lat: {{ theme_option('default_map_center_lat') }},
                zoom: {{ theme_option('default_map_zoom') }}
            };
            window.footerMapPoints = {!! theme_option('map_points') !!};
        </script>
    @endif

</footer>
