@extends('theme.sharjah-triennial::layouts.master')


@section('content')

    @php
        $pageData = Theme::page();
        $pageId = $pageData->id ?? 0;

        // Page Header
        $headerType = get_field('header_type', $pageId) ?: 'slider';
        $headerSliderImages = get_field('header_slider_images', $pageId) ?: [];
        $headerVideoUrl = get_field('header_video_url', $pageId) ?: '';
        $headerVideoThumbnail = get_field('header_video_thumbnail', $pageId) ?: '';
        $headerImage = get_field('header_image', $pageId) ?: '';

        // Header Map
        $headerMapCenterLatitude = get_field('header_map_center_latitude', $pageId) ?: '';
        $headerMapCenterLongitude = get_field('header_map_center_longitude', $pageId) ?: '';
        $headerMapZoom = get_field('header_map_zoom', $pageId) ?: 12;
        $headerMapPoints = get_field('header_map_points', $pageId) ?: [];
        $visibleHeaderMapPoints = collect($headerMapPoints)->filter(function ($point) {
            return !empty($point['is_visible']) && $point['is_visible'] !== '0';
        });

        // Sidebar Map
        $sidepageMapPoints = get_field('map_points', $pageId) ?: [];
        $sidepageMapCenter = get_field('map_center', $pageId) ?: '';
        $sidepageMapZoom = get_field('map_zoom', $pageId) ?: '';

        $sidemapcenterCoords = [];
        if (!empty($sidepageMapCenter)) {
            $sidemapcoords = explode(',', $sidepageMapCenter);
            if (count($sidemapcoords) >= 2) {
                $sidemapcenterCoords = [
                    'lat' => trim($sidemapcoords[0]),
                    'lng' => trim($sidemapcoords[1]),
                ];
            }
        }

        $sidedefaultLat = $sidemapcenterCoords['lat'] ?? theme_option('default_map_center_lat', '25.3463');
        $sidedefaultLng = $sidemapcenterCoords['lng'] ?? theme_option('default_map_center_lng', '55.4209');
        $sidedefaultZoom = $sidepageMapZoom ?: theme_option('default_map_zoom', '12');

        $sidevisibleMapPoints = collect($sidepageMapPoints)->filter(function ($sidepoint) {
            return !empty($sidepoint['is_visible']) && $sidepoint['is_visible'] !== '0';
        });

        // Show/Hide Settings
        $showMap = get_field('show_map', $pageId) ?? true;
        $showMap = $showMap === null || $showMap === '1' || $showMap === 1 || $showMap === true ? true : false;

        $showWorkingHours = get_field('show_working_hours', $pageId) ?? true;
        $showWorkingHours =
            $showWorkingHours === null ||
            $showWorkingHours === '1' ||
            $showWorkingHours === 1 ||
            $showWorkingHours === true
                ? true
                : false;

        // Menu Items
        $menuItems = get_field('menu_items', $pageId) ?: [];
        $menuShowState = get_field('show_menu', $pageId) ?: false;

        // Working Hours & Contact
        $workingHours = get_field('working_hours', $pageId) ?: [];
        $contactInfo = get_field('contact_info', $pageId) ?: [];

        // Child Pages
        $childPages = \Botble\Page\Models\Page::query()
            ->where('parent_id', $pageId)
            ->where('status', 'published')
            ->orderBy('order', 'asc')
            ->orderBy('created_at', 'asc')
            ->orderBy('name', 'asc')
            ->get();

        // Days of Week and Current Time
        $daysOfWeek = isArabic()
            ? [
                'monday' => 'الاثنين',
                'tuesday' => 'الثلاثاء',
                'wednesday' => 'الأربعاء',
                'thursday' => 'الخميس',
                'friday' => 'الجمعة',
                'saturday' => 'السبت',
                'sunday' => 'الأحد',
            ]
            : [
                'monday' => 'Monday',
                'tuesday' => 'Tuesday',
                'wednesday' => 'Wednesday',
                'thursday' => 'Thursday',
                'friday' => 'Friday',
                'saturday' => 'Saturday',
                'sunday' => 'Sunday',
            ];

        $timezone = new DateTimeZone('Asia/Dubai');
        $now = new DateTime('now', $timezone);
        $currentDay = strtolower($now->format('l'));
        $currentTime = $now->format('H:i');

        $isCurrentlyOpen = false;
        if (
            isset($workingHours[$currentDay]) &&
            isset($workingHours[$currentDay]['is_open']) &&
            $workingHours[$currentDay]['is_open']
        ) {
            $openTime = $workingHours[$currentDay]['open'] ?? '09:00';
            $closeTime = $workingHours[$currentDay]['close'] ?? '18:00';
            $isCurrentlyOpen = $currentTime >= $openTime && $currentTime < $closeTime;
        }
        $relatedPages = get_related_pages($pageData->id) ?? [];
    @endphp

    <main id="main-content " class="main-content event-section about_page">

        {{-- Page Header Section --}}
        <section class="page-header-section mb-5">
            @if ($headerType)
                @if ($headerType === 'slider' && !empty($headerSliderImages))
                    {{-- Slider Header --}}
                    <div class="header-slider ">
                        <div id="headerCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner header_img">
                                @foreach ($headerSliderImages as $index => $image)
                                    <div class="carousel-item @if ($index === 0) active @endif">
                                        <img src="{{ $image }}" class="border-top border-3 border-black"
                                            style="width: 100%; height: 100%; object-fit: cover; display: block"
                                            alt="Header Slider Image {{ $index + 1 }}">
                                    </div>
                                @endforeach
                            </div>
                            @if (count($headerSliderImages) > 1)
                                <button class="carousel-control-prev" type="button" data-bs-target="#headerCarousel"
                                    data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#headerCarousel"
                                    data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            @endif
                        </div>
                    </div>
                @elseif($headerType === 'video' && !empty($headerVideoUrl))
                    {{-- Video Header --}}
                    <div class="header-video header_img">
                        @if (strpos($headerVideoUrl, 'youtube.com') !== false || strpos($headerVideoUrl, 'youtu.be') !== false)
                            {{-- YouTube Video Thumbnail with Play Button --}}
                            <div class="video-container position-relative border-top border-3 border-black"
                                style="overflow: hidden;">
                                @php
                                    preg_match(
                                        '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.*/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/|youtube\.com/embed/)([^"&?\s]{11})%i',
                                        $headerVideoUrl,
                                        $match,
                                    );
                                    $videoId = $match[1] ?? '';
                                    // Use custom thumbnail if available, otherwise use YouTube default
                                    $thumbnailUrl = !empty($headerVideoThumbnail)
                                        ? $headerVideoThumbnail
                                        : "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg";
                                    $embedUrl = "https://www.youtube.com/embed/{$videoId}?autoplay=1";
                                @endphp

                                @if ($videoId)
                                    <img src="{{ $thumbnailUrl }}" class="w-100 d-block" style="object-fit: cover;"
                                        alt="Video Thumbnail">
                                    <button type="button" id="video-youtube-play-btn" data-video-type="youtube"
                                        data-video-id="{{ $videoId }}" data-embed-url="{{ $embedUrl }}"
                                        style="position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%) scale(1); background: rgb(255, 255, 255); border: 3px solid rgb(34, 34, 34); border-radius: 4px; width: 70px; height: 70px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.3s; text-decoration: none; z-index: 10; padding: 0;"
                                        onmouseover="this.style.transform='translate(-50%, -50%) scale(1.1)'"
                                        onmouseout="this.style.transform='translate(-50%, -50%) scale(1)'">
                                        <svg width="40" height="40" viewBox="0 0 40 40">
                                            <polygon points="12,8 32,20 12,32" fill="#222"></polygon>
                                        </svg>
                                    </button>
                                @else
                                    <p class="text-danger">Invalid YouTube URL</p>
                                @endif
                            </div>
                        @elseif(strpos($headerVideoUrl, 'vimeo.com') !== false)
                            {{-- Vimeo Video Link --}}
                            <div class="video-container position-relative border-top border-3 border-black"
                                style="overflow: hidden;">
                                @php
                                    preg_match('/vimeo\.com\/(\d+)/', $headerVideoUrl, $match);
                                    $videoId = $match[1] ?? '';
                                    $embedUrl = "https://player.vimeo.com/video/{$videoId}?autoplay=1";
                                @endphp
                                @if ($videoId)
                                    @if (!empty($headerVideoThumbnail))
                                        {{-- Use custom thumbnail if available --}}
                                        <img src="{{ $headerVideoThumbnail }}" class="w-100 d-block"
                                            style="object-fit: cover; " alt="Video Thumbnail">
                                    @endif
                                    <button type="button" id="video-vimeo-play-btn" data-video-type="vimeo"
                                        data-video-id="{{ $videoId }}" data-embed-url="{{ $embedUrl }}"
                                        style="position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%) scale(1); background: rgb(255, 255, 255); border: 3px solid rgb(34, 34, 34); border-radius: 4px; width: 70px; height: 70px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.3s; text-decoration: none; z-index: 10; padding: 0;"
                                        onmouseover="this.style.transform='translate(-50%, -50%) scale(1.1)'"
                                        onmouseout="this.style.transform='translate(-50%, -50%) scale(1)'">
                                        <svg width="40" height="40" viewBox="0 0 40 40">
                                            <polygon points="12,8 32,20 12,32" fill="#222"></polygon>
                                        </svg>
                                    </button>
                                @else
                                    <p class="text-danger">Invalid Vimeo URL</p>
                                @endif
                            </div>
                        @endif
                    </div>
                @elseif($headerType === 'image' && !empty($headerImage))
                    {{-- Image Header --}}
                    <div class="header_img">
                        <img src="{{ $headerImage }}" class="border-top border-3 border-black"
                            style="width: 100%; height: 100%; object-fit: cover; display: block" alt="Page Header Image">
                    </div>
                @elseif($headerType === 'map' && (!empty($visibleHeaderMapPoints) || !empty($headerMapPoints)))
                    {{-- Map Header --}}
                    <hr class="divider" />
                    <div class="visit-us-map-img-wrap position-relative" style="width: 100%; height: 640px">
                        <div id="visit-us-map" style="width: 100%; height: 100%"></div>
                    </div>
                @endif
                {{-- </section> --}}
            @endif



            <div class="col-12">
                <hr class="divider" />
                <h2 class="my-1" style="font-size: 26px">{{ $pageData->name }}</h2>
                <hr class="divider" />
                <div class="row">


                    {{-- Left side --}}

                    <div class="col-lg-5 mb-4 mb-lg-0">


                        @if ($childPages->count() > 0)
                            <ul class="list-group about-menu">
                                @foreach ($childPages as $childPage)
                                    <li class="list-group-item ps-0">
                                        <a class="text-decoration-none text-dark" href="{{ $childPage->url }}"
                                            title="{{ $childPage->description ?: $childPage->name }}">
                                            <i class="fa-solid fa-arrow-right"></i>

                                            {{ $childPage->name }}

                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif



                        @if (!empty($menuItems) && is_array($menuItems) && $menuShowState == 'on')
                            <ul class="list-group about-menu">
                                @foreach ($menuItems as $menuItem)
                                    @if (!empty($menuItem['is_visible']) && $menuItem['is_visible'] == '1')
                                        <li class="list-group-item ps-0">
                                            <a class="text-decoration-none text-dark" href="{{ $menuItem['link'] ?? '#' }}"
                                                data-period="{{ $menuItem['timeline_id'] ?? 'null' }}">
                                                <i class="fa-solid fa-arrow-right"></i>
                                                {{ $menuItem['name'] ?? '' }}
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        @endif


                        @if ($showMap)
                            <div class="visit-us-map-img-wrap position-relative" style="width: 100%; height: 230px">
                                <div id="al-qasimiyah-map" style="width: 100%; height: 100%"></div>
                            </div>
                            <hr class="divider" />
                        @endif

                        @if ($showWorkingHours)
                            @if (!empty($contactInfo['address']))
                                <h6 class="py-2">
                                    {!! nl2br(e($contactInfo['address'])) !!}
                                </h6>

                                <hr class="divider" />
                            @endif
                            <h6 class="pt-2">{{ isArabic() ? 'ساعات العمل:' : 'Opening hours:' }}</h6>
                            <table class="mb-2" style="width: inherit; line-height: initial">
                                @foreach ($daysOfWeek as $day => $dayLabel)
                                    @php
                                        $dayInfo = $workingHours[$day] ?? [
                                            'open' => '10:00',
                                            'close' => '18:00',
                                            'is_open' => true,
                                        ];
                                        $isToday = $day === $currentDay;
                                        $isDayOpen = isset($dayInfo['is_open']) ? $dayInfo['is_open'] : true;
                                    @endphp
                                    <tr>
                                        <td>{{ $dayLabel }}</td>
                                        <td>
                                            @if ($isDayOpen)
                                                {{ $dayInfo['open'] ?? '10:00' }} - {{ $dayInfo['close'] ?? '18:00' }}
                                                @if ($isToday && $isCurrentlyOpen)
                                                    <small>{{ isArabic() ? '(مفتوح الآن)' : '(Open Now)' }}</small>
                                                @endif
                                            @else
                                                <span style="color: #999;">{{ isArabic() ? 'مغلق' : 'Closed' }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            <hr class="divider" />
                        @endif



                    </div>
                    {{-- End Left side --}}







                    <div class="col-lg-7">
                        <div class="desc pt-md-4 mt-3 fs-5">
                            {!! Theme::content() !!}

                        </div>
                    </div>
                </div>
            </div>
        </section>


        {!! Theme::downRow() !!}

        @if ($childPages->count() > 0)
            <section class="mb-5 mt-5 pt-5">
                <hr class="divider" />
                <h3 class="my-2" style="font-size: 22px">{{ $pageData->name ?? 'About SAT' }}</h3>
                <hr class="divider" />
                <div class="row g-4 mt-1">

                    @foreach ($childPages as $childPage)
                        <!-- Dynamic Card for {{ $childPage->name }} -->
                        <div class="col-6 col-xl-3 latest-card-wrap">
                            <div class="latest-card h-100 d-flex flex-column border-bottom border-black border-3">
                                <a href="{{ $childPage->url }}" class="latest-card-link">Go to
                                    {{ $childPage->name }}</a>
                                <div class="latest-img-wrap">
                                    @if ($childPage->image)
                                        <img src="{{ RvMedia::getImageUrl($childPage->image, 'medium', false, RvMedia::getDefaultImage()) }}"
                                            alt="{{ $childPage->name }}" />
                                    @else
                                        <img src="{{ RvMedia::getDefaultImage() }}" alt="{{ $childPage->name }}" />
                                    @endif
                                </div>
                                <hr class="latest-hr border-0 border-top border-black border-3 m-0" />
                                <div
                                    class="latest-title-wrap p-2 fw-bold custom-font-size border-bottom border-black border-3 custom-margin-bottom ps-0">
                                    {{ $childPage->name }}
                                </div>
                                <div class="latest-desc pt-0 custom-padding-bottom pt-2">
                                    @if ($childPage->description)
                                        {{ Str::limit($childPage->description, 250) }}
                                    @else
                                        {{ Str::limit(strip_tags($childPage->content), 250) }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach


                </div>
            </section>
        @endif

        @if ($relatedPages->count() > 0)
            <section class="mb-5 mt-5 pt-5">
                <hr class="divider" />
                <h3 class="my-2" style="font-size: 22px">Related Pages</h3>
                <hr class="divider" />
                <div class="row g-3 mt-1">
                    @foreach ($relatedPages as $relatedPage)
                        <!-- Related Page Card for {{ $relatedPage->name }} -->
                        <div class="col-6 col-xl-3 latest-card-wrap">
                            <div class="latest-card h-100 d-flex flex-column border-bottom border-black border-3">
                                <a href="{{ $relatedPage->url }}" class="latest-card-link">Go to
                                    {{ $relatedPage->name }}</a>
                                <div class="latest-img-wrap">
                                    @if ($relatedPage->image)
                                        <img src="{{ RvMedia::getImageUrl($relatedPage->image, 'medium', false, RvMedia::getDefaultImage()) }}"
                                            alt="{{ $relatedPage->name }}" />
                                    @else
                                        <img src="https://cdn.sanity.io/images/kh6stm8m/production/6e1abcd77b2b920247a7f09da85c33e6299c0bb7-3000x2003.jpg"
                                            alt="{{ $relatedPage->name }}" />
                                    @endif
                                </div>
                                <hr class="latest-hr border-0 border-top border-black border-3 m-0" />
                                <div
                                    class="latest-title-wrap p-2 fw-bold custom-font-size border-bottom border-black border-3 custom-margin-bottom ps-0">
                                    {{ $relatedPage->name }}
                                </div>
                                <div class="latest-desc pt-0 custom-padding-bottom custom-font-size pt-2">
                                    @if (!empty($relatedPage->description))
                                        {{ Str::limit($relatedPage->description, 250) }}
                                    @else
                                        {{ Str::limit(strip_tags($relatedPage->content), 250) }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif



    </main>

    @include('theme.sharjah-triennial::partials.video-modal')
@endsection


@push('footer')
    @include('theme.sharjah-triennial::partials.maps-scripts')
@endpush
