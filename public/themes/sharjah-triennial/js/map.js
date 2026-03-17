// Footer Map - Works on all pages
mapboxgl.accessToken = 'pk.eyJ1IjoiYWJkZWxyaG1hbmF0d2EzOSIsImEiOiJjbWQyZTZoZGMxN280Mmxxd3d3NWw1aHMyIn0.YcekKacapqijA-aHi_hkgg';

// Initialize footer map only if the container exists
if (document.getElementById('footer-map')) {
    // Get coordinates from global variable set by Blade
    const coords = window.footerMapCoords || { lng: 55.4023, lat: 25.34648, zoom: 1 };
    const points = window.footerMapPoints;
    // console.log('Footer Map Points:', points);
    const footerMap = new mapboxgl.Map({
        container: 'footer-map',
        style: 'mapbox://styles/mapbox/light-v11',
        center: [coords.lng, coords.lat],
        zoom: coords.zoom,
        interactive: true
    });

    // Restrict panning to the visible area
    footerMap.on('load', function () {
        const bounds = footerMap.getBounds();
        footerMap.setMaxBounds(bounds);
    });

    // Add black circle marker
    // const footerMarker = document.createElement('div');
    // footerMarker.style.width = '32px';
    // footerMarker.style.height = '32px';
    // footerMarker.style.border = '3px solid #000';
    // footerMarker.style.borderRadius = '50%';
    // footerMarker.style.background = 'transparent';
    // footerMarker.style.boxSizing = 'border-box';
    // footerMarker.style.cursor = 'pointer';
    // footerMarker.classList.add('footer-map-circle');

    // const footerMapMarker = new mapboxgl.Marker(footerMarker)
    //     .setLngLat([55.4023, 25.34648])
    //     .addTo(footerMap);

    // // Make marker clickable to open Google Maps
    // footerMarker.addEventListener('click', function () {
    //     window.open('https://maps.app.goo.gl/THR2C6phDtfemg5S7', '_blank');
    // });

    // // Make entire map clickable to open Google Maps
    // footerMap.on('click', function () {
    //     window.open('https://maps.app.goo.gl/THR2C6phDtfemg5S7', '_blank');
    // });

    if (Array.isArray(points) && points.length > 0) {
    // console.log('Total points:', points.length); // للتحقق من عدد النقاط
    
    points.forEach((pointArray, index) => {
        // console.log(`Processing point ${index}:`, pointArray);
        
        // تحويل المصفوفة إلى كائن
        const point = {};
        
        if (Array.isArray(pointArray)) {
            pointArray.forEach(item => {
                if (item && item.key) {
                    point[item.key] = item.value;
                }
            });
        }

        // console.log('Converted Point:', point);

        // التحقق من is_visible
        const isVisible = point.is_visible === '1' || point.is_visible === 1 || point.is_visible === true;
        // console.log('Is visible?', isVisible);

        if (isVisible) {
            const lng = parseFloat(point.longitude);
            const lat = parseFloat(point.latitude);

            // console.log('Coordinates:', { lng, lat });

            if (!isNaN(lng) && !isNaN(lat)) {
                const markerDiv = document.createElement('div');
                markerDiv.style.width = '32px';
                markerDiv.style.height = '32px';
                markerDiv.style.border = '3px solid #000';
                markerDiv.style.borderRadius = '50%';
                markerDiv.style.background = 'transparent';
                markerDiv.style.boxSizing = 'border-box';
                markerDiv.style.cursor = 'pointer';
                markerDiv.addEventListener('mouseenter', () => {
                    markerDiv.style.background = '#000';
                });

                markerDiv.addEventListener('mouseleave', () => {
                    markerDiv.style.background = 'transparent';
                });

                new mapboxgl.Marker(markerDiv)
                    .setLngLat([lng, lat])
                    .addTo(footerMap);

                // console.log('Marker added successfully at:', { lng, lat });

                markerDiv.addEventListener('click', () => {
                    if (point['link_url']) {
                        window.open(point['link_url'], '_blank');
                    }
                });
            } else {
                // console.error('Invalid coordinates for point:', point);
            }
        } else {
            // console.log('Point is not visible, skipping:', point);
        }
    });
} else {
    // console.error('Points is not an array or empty:', points);
}






}

