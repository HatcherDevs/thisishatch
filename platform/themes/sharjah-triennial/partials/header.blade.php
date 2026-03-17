<header>
    <!-- Desktop Navbar -->
    <nav class="navbar-custom d-flex align-items-center justify-content-between navbar-desktop" role="navigation"
        aria-label="Main navigation">
        <div class="navbar-left d-flex">
            <a href="{{ route('public.index') }}">
                @if ($logo = theme_option('site_logo'))
                    <img src="{{ RvMedia::getImageUrl($logo) }}" alt="{{ theme_option('site_title') }}"
                        style="height: 13px;">
                @endif
            </a>
        </div>


        <div class="navbar-center d-flex position-relative">
            {!! Menu::renderMenuLocation('main-menu', [
                'view' => 'menu',
            ]) !!}



            {{-- End fallback menu --}}




            <a href="#search" aria-label="Search" aria-expanded="false" id="desktop-search-icon">
                @if (isArabic())
                    بحث
                    <span class="sr-only">بحث</span>
                @else
                    Search
                    <span class="sr-only">Search</span>
                @endif


            </a>
            <form id="desktop-search-form" class="align-items-center"
                style="
              display: none;
              position: absolute;
              inset: -3px 0px !important;
              left: 0;
              right: 0;
              background: #fff;
              top: -4px;
              bottom: -4px;
            ">
                <input type="text" class="form-control search-desktop" placeholder="Search..."
                    style="background:#d3d3d3;border:none;height:
            30px;font-size:16px;border-radius: 1px;margin: 0px 10px;width:
            305px;margin: 0px 10px;">




                @if (isRTL())
                    <button type="submit" class="btn btn-link px-3"
                        style="
                font-size: 16px;
                border-radius: 0;
                text-decoration: none;
                border-right: 3px solid #000;
                border-left: 3px solid #000;
                height: 120%;
                color: #000;
              ">

                        Search



                    </button>
                    <button type="button" id="desktop-search-close" class="btn btn-link px-2"
                        style="
                font-size: 30px;
                color: #000;
                text-decoration: none;
                border-left: 3px solid #000;
                border-radius: 0;
                height: 120%;
                display: flex;
                align-items: center;
                width: 55px;
                justify-content: center;
              "
                        aria-label="Close search">
                        ×
                    </button>
                @else
                    <button type="submit" class="btn btn-link px-3"
                        style="
                font-size: 16px;
                border-radius: 0;
                text-decoration: none;
                border-left: 3px solid #000;
                border-right: 1px solid #000;
                height: 120%;
                color: #000;
              ">
                        Search
                    </button>
                    <button type="button" id="desktop-search-close" class="btn btn-link px-2"
                        style="
                font-size: 30px;
                color: #000;
                text-decoration: none;
                border-right: 3px solid #000;
                border-radius: 0;
                height: 120%;
                display: flex;
                align-items: center;
                width: 55px;
                justify-content: center;
                padding: 0px;
                padding-bottom: 1.5px;
                border-left: 2px solid #000;
              "
                        aria-label="Close search">
                        ×
                    </button>
                @endif
            </form>
        </div>


        <div class="navbar-right d-flex">
            <a href="{{ route('set.language', ['locale' => 'ar']) }}" role="button" tabindex="0"
                aria-label="Switch to Arabic language"
                style="font-weight: {{ app()->getLocale() === 'ar' ? '700' : '500' }} !important; text-decoration: none; color: inherit;">
                العربية
            </a>
            <span class="lang-sep" aria-hidden="true">/</span>
            <a href="{{ route('set.language', ['locale' => 'en']) }}" role="button" tabindex="0"
                aria-label="Switch to English language"
                style="font-weight: {{ app()->getLocale() === 'en' ? '700' : '500' }}; text-decoration: none; color: inherit;">
                EN
            </a>
        </div>
    </nav>

    <!-- Mobile Navbar -->
    <nav class="navbar-mobile d-none" role="navigation" aria-label="Mobile navigation">
        <div class="navbar-mobile-header d-flex align-items-center justify-content-between">
            <a href="{{ route('public.index') }}">
                @if ($logo = theme_option('logo'))
                    <img src="{{ RvMedia::getImageUrl($logo) }}" alt="{{ theme_option('site_title') }}"
                        style="height: 13px;">
                @else
                    <svg width="325" height="13" viewBox="0 0 325 13" xmlns="http://www.w3.org/2000/svg"
                        class="svelte-1e7qjk6">
                        <path
                            d="M322.32 7.78567V0.765625H324.394V12.7146H322.087L319.266 4.94779V12.7146H317.225V0.765625H319.781L322.32 7.78567Z"
                            class="svelte-1e7qjk6"></path>
                        <path
                            d="M311.745 12.8805C309.638 12.8805 308.177 11.4864 308.177 9.44516V3.95197C308.177 1.96048 309.638 0.599609 311.745 0.599609C313.87 0.599609 315.314 1.97707 315.314 3.96856V9.46179C315.314 11.4865 313.853 12.8805 311.745 12.8805ZM311.745 10.8392C312.658 10.8392 313.156 10.275 313.156 9.27921V4.2009C313.156 3.20515 312.658 2.64091 311.745 2.64091C310.833 2.64091 310.335 3.20515 310.335 4.2009V9.27921C310.335 10.275 310.833 10.8392 311.745 10.8392Z"
                            class="svelte-1e7qjk6"></path>
                        <path d="M306.271 12.7146H304.114V0.765625H306.271V12.7146Z" class="svelte-1e7qjk6"></path>
                        <path d="M295.487 0.765625H302.922V2.80693H300.283V12.7146H298.126V2.80693H295.487V0.765625Z"
                            class="svelte-1e7qjk6"></path>
                        <path
                            d="M296.02 12.7146H293.83L293.166 10.0095H289.946L289.282 12.7146H287.092L290.145 0.765625H292.967L296.02 12.7146ZM291.556 3.48736L290.444 7.96821H292.668L291.556 3.48736Z"
                            class="svelte-1e7qjk6"></path>
                        <path
                            d="M282.744 12.7146H278.993V0.765625H282.677C284.652 0.765625 286.079 2.17627 286.079 4.13458V9.32908C286.079 11.304 284.685 12.7146 282.744 12.7146ZM281.15 2.80693V10.6733H282.594C283.457 10.6733 283.922 10.1921 283.922 9.41205V4.08482C283.922 3.28822 283.441 2.80693 282.561 2.80693H281.15Z"
                            class="svelte-1e7qjk6"></path>
                        <path
                            d="M274.834 7.78567V0.765625H276.908V12.7146H274.601L271.78 4.94779V12.7146H269.739V0.765625H272.295L274.834 7.78567Z"
                            class="svelte-1e7qjk6"></path>
                        <path
                            d="M264.26 12.8806C262.152 12.8806 260.691 11.4865 260.691 9.44522V0.765625H262.849V9.27927C262.849 10.275 263.347 10.8393 264.26 10.8393C265.172 10.8393 265.67 10.275 265.67 9.27927V0.765625H267.828V9.46185C267.828 11.4865 266.367 12.8806 264.26 12.8806Z"
                            class="svelte-1e7qjk6"></path>
                        <path
                            d="M255.394 12.8805C253.287 12.8805 251.826 11.4864 251.826 9.44516V3.95197C251.826 1.96048 253.287 0.599609 255.394 0.599609C257.519 0.599609 258.962 1.97707 258.962 3.96856V9.46179C258.962 11.4865 257.502 12.8805 255.394 12.8805ZM255.394 10.8392C256.307 10.8392 256.805 10.275 256.805 9.27921V4.2009C256.805 3.20515 256.307 2.64091 255.394 2.64091C254.482 2.64091 253.984 3.20515 253.984 4.2009V9.27921C253.984 10.275 254.482 10.8392 255.394 10.8392Z"
                            class="svelte-1e7qjk6"></path>
                        <path
                            d="M250.597 0.765625V2.80693H245.917V5.49544H250.248V7.53674H245.917V12.7146H243.759V0.765625H250.597Z"
                            class="svelte-1e7qjk6"></path>
                        <path d="M238.62 12.7146H231.799V0.765625H233.956V10.6733H238.62V12.7146Z"
                            class="svelte-1e7qjk6">
                        </path>
                        <path
                            d="M230.609 12.7146H228.419L227.755 10.0095H224.535L223.872 12.7146H221.681L224.735 0.765625H227.556L230.609 12.7146ZM226.145 3.48736L225.033 7.96821H227.257L226.145 3.48736Z"
                            class="svelte-1e7qjk6"></path>
                        <path d="M220.488 12.7146H218.331V0.765625H220.488V12.7146Z" class="svelte-1e7qjk6"></path>
                        <path
                            d="M214.172 7.78567V0.765625H216.246V12.7146H213.939L211.118 4.94779V12.7146H209.077V0.765625H211.633L214.172 7.78567Z"
                            class="svelte-1e7qjk6"></path>
                        <path
                            d="M204.918 7.78567V0.765625H206.992V12.7146H204.685L201.864 4.94779V12.7146H199.823V0.765625H202.378L204.918 7.78567Z"
                            class="svelte-1e7qjk6"></path>
                        <path
                            d="M198.249 0.765625V2.80693H193.569V5.51203H197.9V7.55333H193.569V10.6733H198.249V12.7146H191.411V0.765625H198.249Z"
                            class="svelte-1e7qjk6"></path>
                        <path d="M189.323 12.7146H187.165V0.765625H189.323V12.7146Z" class="svelte-1e7qjk6"></path>
                        <path
                            d="M185.887 12.7146H183.563L181.456 8.15079H180.36V12.7146H178.203V0.765625H181.904C183.895 0.765625 185.306 2.17627 185.306 4.21755V4.69886C185.306 6.05972 184.542 7.15503 183.497 7.71928L185.887 12.7146ZM181.621 2.80693H180.36V6.10949H181.621C182.634 6.10949 183.148 5.56185 183.148 4.61589V4.30053C183.148 3.35457 182.634 2.80693 181.621 2.80693Z"
                            class="svelte-1e7qjk6"></path>
                        <path d="M169.576 0.765625H177.011V2.80693H174.372V12.7146H172.215V2.80693H169.576V0.765625Z"
                            class="svelte-1e7qjk6"></path>
                        <path
                            d="M164.749 0.765625V2.80693H160.069V5.51203H164.401V7.55333H160.069V10.6733H164.749V12.7146H157.912V0.765625H164.749Z"
                            class="svelte-1e7qjk6"></path>
                        <path
                            d="M156.633 12.7146H154.31L152.202 8.15079H151.107V12.7146H148.949V0.765625H152.65C154.642 0.765625 156.052 2.17627 156.052 4.21755V4.69886C156.052 6.05972 155.289 7.15503 154.243 7.71928L156.633 12.7146ZM152.368 2.80693H151.107V6.10949H152.368C153.38 6.10949 153.895 5.56185 153.895 4.61589V4.30053C153.895 3.35457 153.38 2.80693 152.368 2.80693Z"
                            class="svelte-1e7qjk6"></path>
                        <path
                            d="M143.47 12.8806C141.362 12.8806 139.902 11.4865 139.902 9.44522V0.765625H142.059V9.27927C142.059 10.275 142.557 10.8393 143.47 10.8393C144.383 10.8393 144.881 10.275 144.881 9.27927V0.765625H147.038V9.46185C147.038 11.4865 145.578 12.8806 143.47 12.8806Z"
                            class="svelte-1e7qjk6"></path>
                        <path d="M131.458 0.765625H138.892V2.80693H136.254V12.7146H134.096V2.80693H131.458V0.765625Z"
                            class="svelte-1e7qjk6"></path>
                        <path
                            d="M127.215 12.8805C125.107 12.8805 123.646 11.4864 123.646 9.44516V3.95197C123.646 1.96048 125.107 0.599609 127.215 0.599609C129.355 0.599609 130.783 1.92727 130.783 4.28388H128.625C128.625 3.27153 128.127 2.64091 127.215 2.64091C126.302 2.64091 125.804 3.20515 125.804 4.2009V9.27921C125.804 10.275 126.302 10.8392 127.215 10.8392C128.227 10.8392 128.625 10.1256 128.625 9.12984H130.783C130.783 11.4533 129.389 12.8805 127.215 12.8805Z"
                            class="svelte-1e7qjk6"></path>
                        <path
                            d="M122.255 0.765625V2.80693H117.575V5.51203H121.906V7.55333H117.575V10.6733H122.255V12.7146H115.417V0.765625H122.255Z"
                            class="svelte-1e7qjk6"></path>
                        <path d="M106.791 0.765625H114.226V2.80693H111.587V12.7146H109.429V2.80693H106.791V0.765625Z"
                            class="svelte-1e7qjk6"></path>
                        <path d="M105.598 12.7146H103.441V0.765625H105.598V12.7146Z" class="svelte-1e7qjk6"></path>
                        <path
                            d="M99.1858 5.51203V0.765625H101.343V12.7146H99.1858V7.55333H96.1819V12.7146H94.0245V0.765625H96.1819V5.51203H99.1858Z"
                            class="svelte-1e7qjk6"></path>
                        <path
                            d="M88.8854 12.8805C86.7778 12.8805 85.3173 11.4864 85.3173 9.44516V3.95197C85.3173 1.96048 86.7778 0.599609 88.8854 0.599609C91.0263 0.599609 92.4535 1.92727 92.4535 4.28388H90.2961C90.2961 3.27153 89.7982 2.64091 88.8854 2.64091C87.9727 2.64091 87.4748 3.20515 87.4748 4.2009V9.27921C87.4748 10.275 87.9727 10.8392 88.8854 10.8392C89.8978 10.8392 90.2961 10.1256 90.2961 9.12984H92.4535C92.4535 11.4533 91.0595 12.8805 88.8854 12.8805Z"
                            class="svelte-1e7qjk6"></path>
                        <path
                            d="M84.2211 12.7146H81.8977L79.7901 8.15079H78.6947V12.7146H76.5373V0.765625H80.2382C82.2296 0.765625 83.6403 2.17627 83.6403 4.21755V4.69886C83.6403 6.05972 82.8769 7.15503 81.8313 7.71928L84.2211 12.7146ZM79.956 2.80693H78.6947V6.10949H79.956C80.9684 6.10949 81.4828 5.56185 81.4828 4.61589V4.30053C81.4828 3.35457 80.9684 2.80693 79.956 2.80693Z"
                            class="svelte-1e7qjk6"></path>
                        <path
                            d="M75.348 12.7146H73.1574L72.4936 10.0095H69.274L68.6101 12.7146H66.4195L69.4731 0.765625H72.2944L75.348 12.7146ZM70.8838 3.48736L69.7718 7.96821H71.9957L70.8838 3.48736Z"
                            class="svelte-1e7qjk6"></path>
                        <path
                            d="M58.9118 5.51203V0.765625H61.0692V12.7146H58.9118V7.55333H55.9079V12.7146H53.7505V0.765625H55.9079V5.51203H58.9118Z"
                            class="svelte-1e7qjk6"></path>
                        <path
                            d="M52.5612 12.7146H50.3706L49.7068 10.0095H46.4872L45.8233 12.7146H43.6327L46.6863 0.765625H49.5076L52.5612 12.7146ZM48.097 3.48736L46.985 7.96821H49.2089L48.097 3.48736Z"
                            class="svelte-1e7qjk6"></path>
                        <path
                            d="M39.299 12.8806C37.3075 12.8806 36.013 11.5363 36.0794 9.12991H38.2203C38.2203 10.1091 38.353 10.8393 39.299 10.8393C40.1454 10.8393 40.3777 10.2252 40.3777 9.29586V2.80693H37.1581V0.765625H42.5352V9.14654C42.5352 11.5363 41.2905 12.8806 39.299 12.8806Z"
                            class="svelte-1e7qjk6"></path>
                        <path
                            d="M35.7465 12.7146H33.4231L31.3155 8.15079H30.2201V12.7146H28.0627V0.765625H31.7635C33.755 0.765625 35.1657 2.17627 35.1657 4.21755V4.69886C35.1657 6.05972 34.4023 7.15503 33.3567 7.71928L35.7465 12.7146ZM31.4814 2.80693H30.2201V6.10949H31.4814C32.4938 6.10949 33.0082 5.56185 33.0082 4.61589V4.30053C33.0082 3.35457 32.4938 2.80693 31.4814 2.80693Z"
                            class="svelte-1e7qjk6"></path>
                        <path
                            d="M26.8734 12.7146H24.6828L24.0189 10.0095H20.7994L20.1355 12.7146H17.9449L20.9985 0.765625H23.8198L26.8734 12.7146ZM22.4092 3.48736L21.2972 7.96821H23.5211L22.4092 3.48736Z"
                            class="svelte-1e7qjk6"></path>
                        <path
                            d="M14.5861 5.51203V0.765625H16.7435V12.7146H14.5861V7.55333H11.5823V12.7146H9.4248V0.765625H11.5823V5.51203H14.5861Z"
                            class="svelte-1e7qjk6"></path>
                        <path
                            d="M4.08654 12.8805C1.76313 12.8805 0.352489 11.2209 0.402277 9.03028H2.50994C2.49335 10.192 3.10739 10.8392 4.08654 10.8392C5.0325 10.8392 5.59676 10.192 5.59676 9.49496C5.59676 8.86432 5.26484 8.48261 4.58442 8.1341L2.87505 7.23795C1.481 6.50774 0.535043 5.3958 0.535043 3.96856C0.535043 1.99366 2.06186 0.599609 4.11973 0.599609C6.27719 0.599609 7.70443 1.96049 7.70443 4.2507H5.59676C5.56357 3.18857 5.01591 2.64091 4.13633 2.64091C3.17377 2.64091 2.79207 3.27155 2.79207 3.869C2.79207 4.53283 3.20697 4.86476 3.92058 5.22987L5.71293 6.15923C7.024 6.83965 7.85379 7.95156 7.85379 9.32901C7.85379 11.1877 6.39336 12.8805 4.08654 12.8805Z"
                            class="svelte-1e7qjk6"></path>
                    </svg>
                @endif
            </a>
            <div style="padding: 6px 15px; border-left: 2px solid #000">
                <button class="navbar-mobile-toggle btn btn-link p-0" onclick="openMobileNav()"
                    aria-label="Open menu">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
        <!-- <div class="text-end mb-3">
                <span role="button" tabindex="0" aria-label="Switch to Arabic language" style="font-weight: 500!important;">العربية</span>
                <span aria-hidden="true"> / </span>
                <span role="button" tabindex="0" aria-label="Switch to English language" class="text-decoration-underline">EN</span>
            </div> -->

        <!-- Mobile Overlay -->
        <div class="navbar-mobile-overlay" id="navbarMobileOverlay" role="dialog" aria-modal="true"
            aria-label="Mobile menu">
            <div class="navbar-mobile-header navbar-mobile-header_popup">
                <span class="">
                    <img src="logo.svg" alt="Sharjah Architecture Triennial Foundation Logo"
                        class="navbar-mobile-logo" />
                </span>
                <button class="navbar-mobile-close" onclick="closeMobileNav()" aria-label="Close menu">
                    &#10005;
                </button>
            </div>
            <div class="navbar-mobile-lang">
                <a href="{{ route('set.language', ['locale' => 'ar']) }}"
                    style="font-weight: {{ app()->getLocale() === 'ar' ? '700' : '400' }}; text-decoration: none; color: inherit;">
                    العربية
                </a>
                /
                <a href="{{ route('set.language', ['locale' => 'en']) }}"
                    class="{{ app()->getLocale() === 'en' ? 'active-lang' : '' }}"
                    style="font-weight: {{ app()->getLocale() === 'en' ? '700' : '400' }}; text-decoration: none; color: inherit;">
                    EN
                </a>
            </div>
            <div class="navbar-mobile-links">
                {!! Menu::renderMenuLocation('main-menu', [
                    'view' => 'mobile-menu',
                ]) !!}
            </div>
            <form class="navbar-mobile-search" onsubmit="return false;">
                <input type="text" placeholder="Type here..." />
                <button type="submit">Search</button>
            </form>
        </div>
    </nav>
</header>
