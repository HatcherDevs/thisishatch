// Footer Map - Works on all pages
mapboxgl.accessToken = 'pk.eyJ1IjoiYWJkZWxyaG1hbmF0d2EzOSIsImEiOiJjbWQyZTZoZGMxN280Mmxxd3d3NWw1aHMyIn0.YcekKacapqijA-aHi_hkgg';

// Initialize footer map only if the container exists
if (document.getElementById('footer-map')) {
    const footerMap = new mapboxgl.Map({
        container: 'footer-map',
        style: 'mapbox://styles/mapbox/light-v11',
        center: [55.4023, 25.34648],
        zoom: 12.7,
        interactive: true
    });
    
    // Restrict panning to the visible area
    footerMap.on('load', function () {
        const bounds = footerMap.getBounds();
        footerMap.setMaxBounds(bounds);
    });
    
    // Add black circle marker
    const footerMarker = document.createElement('div');
    footerMarker.style.width = '32px';
    footerMarker.style.height = '32px';
    footerMarker.style.border = '3px solid #000';
    footerMarker.style.borderRadius = '50%';
    footerMarker.style.background = 'transparent';
    footerMarker.style.boxSizing = 'border-box';
    footerMarker.style.cursor = 'pointer';
    footerMarker.classList.add('footer-map-circle');
    
    const footerMapMarker = new mapboxgl.Marker(footerMarker)
        .setLngLat([55.4023, 25.34648])
        .addTo(footerMap);

    // Make marker clickable to open Google Maps
    footerMarker.addEventListener('click', function() {
        window.open('https://maps.app.goo.gl/THR2C6phDtfemg5S7', '_blank');
    });

    // Make entire map clickable to open Google Maps
    footerMap.on('click', function() {
        window.open('https://maps.app.goo.gl/THR2C6phDtfemg5S7', '_blank');
    });
}





// Visit Us Page Map - Only initializes if visit-us-map container exists
if (document.getElementById('visit-us-map')) {
    const map_visit_us = new mapboxgl.Map({
        container: 'visit-us-map',
        style: 'mapbox://styles/mapbox/light-v11',
        center: [55.4023, 25.34648],
        zoom: 12.7,
        interactive: false
    });
    
    // Restrict panning to the visible area
    map_visit_us.on('load', function () {
        const bounds = map_visit_us.getBounds();
        map_visit_us.setMaxBounds(bounds);
    });
    
    // Add black circle marker
    const marker_map_visit_us = document.createElement('div');
    marker_map_visit_us.style.width = '32px';
    marker_map_visit_us.style.height = '32px';
    marker_map_visit_us.style.border = '3px solid #000';
    marker_map_visit_us.style.borderRadius = '50%';
    marker_map_visit_us.style.background = 'transparent';
    marker_map_visit_us.style.boxSizing = 'border-box';
    marker_map_visit_us.classList.add('footer-map-circle');
    new mapboxgl.Marker(marker_map_visit_us)
    .setLngLat([55.4023, 25.34648])
    .addTo(map_visit_us);

    // جعل الماركر الأول قابل للنقر
    marker_map_visit_us.style.cursor = 'pointer';
    marker_map_visit_us.addEventListener('click', function() {
        window.open('https://maps.app.goo.gl/THR2C6phDtfemg5S7', '_blank');
    });

    // Marker 2 - Red
    const marker_map_visit_us_2 = document.createElement('div');
    marker_map_visit_us_2.style.width = '32px';
    marker_map_visit_us_2.style.height = '32px';
    marker_map_visit_us_2.style.border = '3px solid #000';
    marker_map_visit_us_2.style.borderRadius = '50%';
    marker_map_visit_us_2.style.background = '#fff';
    marker_map_visit_us_2.style.boxSizing = 'border-box';
    marker_map_visit_us_2.classList.add('footer-map-circle');
    new mapboxgl.Marker(marker_map_visit_us_2)
        .setLngLat([55.3909, 25.34648])
        .addTo(map_visit_us);

    // جعل الماركر الثاني قابل للنقر
    marker_map_visit_us_2.style.cursor = 'pointer';
    marker_map_visit_us_2.addEventListener('click', function() {
        window.open('https://maps.app.goo.gl/THR2C6phDtfemg5S7', '_blank');
    });

    // ضبط الخريطة لتشمل جميع الماركرات
    const bounds = new mapboxgl.LngLatBounds();
    bounds.extend([55.4023, 25.34648]); // ماركر 1 - أسود
    bounds.extend([55.3915, 25.35650]); // ماركر 2 - أحمر
    bounds.extend([55.4123, 25.33648]); // ماركر 3 - أحمر
    bounds.extend([55.3823, 25.36648]); // ماركر 4 - أخضر
    bounds.extend([55.4223, 25.32648]); // ماركر 5 - أخضر
    bounds.extend([55.3723, 25.34648]); // ماركر 6 - أزرق
    bounds.extend([55.4323, 25.35648]); // ماركر 7 - أزرق
    map_visit_us.fitBounds(bounds, { padding: 50 });
}