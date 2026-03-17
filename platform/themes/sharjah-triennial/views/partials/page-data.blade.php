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
        $showWorkingHours === null || $showWorkingHours === '1' || $showWorkingHours === 1 || $showWorkingHours === true
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
    $daysOfWeek = [
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

@endphp
