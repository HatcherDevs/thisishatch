<?php

use Botble\Media\Facades\RvMedia;
use Botble\Theme\Facades\Theme;
use Botble\Theme\Supports\ThemeSupport;
use Botble\Theme\Typography\TypographyItem;
use Illuminate\Support\Str;

// Hel

if (! function_exists('get_upcoming_events')) {
    function get_upcoming_events(int $limit = 3)
    {
        // Placeholder - can be developed later
        return collect([]);
    }
}

app()->booted(function () {
    // Register Page Templates
    register_page_template([
        'default' => __('Default'),
        'homepage' => __('Homepage'),
        'father' => __('Father'),
        'map-header' => __('Map Header'),
        'main-with-map-and-hours' => __('Main with Map and Hours'),
        'research-page' => __('Research Page'),
    ]);

    // Add Custom Fields for Map Header Template
    add_filter(BASE_FILTER_REGISTER_CONTENT_TABS, function ($tabs, $model) {
        if ($model instanceof \Botble\Page\Models\Page) {
            $tabs .= '<li class="nav-item" role="presentation">
                <button class="nav-link" id="tabs-map-settings-tab" data-bs-toggle="tab" data-bs-target="#tabs-map-settings" type="button" role="tab">
                    <i class="fa fa-map me-2"></i>'.__('Map Settings').'
                </button>
            </li>';

            // Add Working Hours tab for main-with-map-and-hours template
            $tabs .= '<li class="nav-item" role="presentation">
                <button class="nav-link" id="tabs-working-hours-tab" data-bs-toggle="tab" data-bs-target="#tabs-working-hours" type="button" role="tab">
                    <i class="fa fa-clock-o me-2"></i>'.__('Working Hours & Contact').'
                </button>
            </li>';

            // Add Related Pages tab
            $tabs .= '<li class="nav-item" role="presentation">
                <button class="nav-link" id="tabs-related-pages-tab" data-bs-toggle="tab" data-bs-target="#tabs-related-pages" type="button" role="tab">
                    <i class="fa fa-link me-2"></i>'.__('Related Pages').'
                </button>
            </li>';

            // Add Menu tab
            $tabs .= '<li class="nav-item" role="presentation">
                <button class="nav-link" id="tabs-menu-tab" data-bs-toggle="tab" data-bs-target="#tabs-menu" type="button" role="tab">
                    <i class="fa fa-list me-2"></i>'.__('Menu').'
                </button>
            </li>';

            // Add Page Header tab
            $tabs .= '<li class="nav-item" role="presentation">
                <button class="nav-link" id="tabs-page-header-tab" data-bs-toggle="tab" data-bs-target="#tabs-page-header" type="button" role="tab">
                    <i class="fa fa-heading me-2"></i>'.__('Page Header').'
                </button>
            </li>';

            // Add Page Settings tab
            $tabs .= '<li class="nav-item" role="presentation">
                <button class="nav-link" id="tabs-page-settings-tab" data-bs-toggle="tab" data-bs-target="#tabs-page-settings" type="button" role="tab">
                    <i class="fa fa-cog me-2"></i>'.__('Page Settings').'
                </button>
            </li>';
        }

        return $tabs;
    }, 120, 2);

    // Add Custom Tab Content
    add_filter(BASE_FILTER_REGISTER_CONTENT_TAB_INSIDE, function ($tabs, $model) {
        if ($model instanceof \Botble\Page\Models\Page) {
            $tabs .= '<div class="tab-pane fade" id="tabs-map-settings" role="tabpanel">';

            // Get data
            $pageId = $model->id ?? 0;
            $mapPoints = get_field('map_points', $pageId) ?: [];
            $mapCenter = get_field('map_center', $pageId) ?: '';
            $mapZoom = get_field('map_zoom', $pageId) ?: 12;
            $showMap = get_field('show_map', $pageId);
            $showMap = ($showMap === null || $showMap === '1' || $showMap === 1 || $showMap === true) ? true : false;

            $tabs .= '
            <div class="alert alert-info">
                <i class="fa fa-info-circle me-2"></i>
                Configure custom map points for this page. If no points are added, child pages will be used as map locations.
            </div>

            <div id="map-settings-container">
                <div class="row">
                    <!-- Show/Hide Map -->
                    <div class="col-12 mb-4">
                        <div class="card bg-light">
                            <div class="card-body">
                                <div class="form-check form-switch">
                                    <input type="hidden" name="show_map" value="0">
                                    <input class="form-check-input" type="checkbox" 
                                           name="show_map" 
                                           id="show_map_toggle"
                                           value="1" '.($showMap ? 'checked' : '').'>
                                    <label class="form-check-label fw-bold" for="show_map_toggle">
                                        <i class="fa fa-eye me-2"></i>Display Map on Frontend
                                    </label>
                                    <small class="d-block text-muted mt-1">
                                        Turn this on to show the map section on the page. Turn off to hide it completely.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Map Center -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            <i class="fa fa-crosshairs me-2"></i>
                            Map Center (Latitude, Longitude)
                        </label>
                        <input type="text" 
                               name="map_center" 
                               class="form-control" 
                               value="'.htmlspecialchars(old('map_center', $mapCenter)).'" 
                               placeholder="25.3463, 55.4209">
                        <small class="form-text text-muted">
                            Enter the center coordinates for the map. Example: 25.3463, 55.4209
                        </small>
                    </div>

                    <!-- Map Zoom -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            <i class="fa fa-search-plus me-2"></i>
                            Map Zoom Level
                        </label>
                        <div class="input-group">
                            <select name="map_zoom" class="form-select">
                                <option value="">Use Default (12)</option>';

            for ($i = 8; $i <= 18; $i++) {
                $selected = ($mapZoom == $i) ? 'selected' : '';
                $zoomLabel = '';
                if ($i <= 10) {
                    $zoomLabel = ' - Far View';
                } elseif ($i <= 13) {
                    $zoomLabel = ' - Medium View';
                } elseif ($i <= 15) {
                    $zoomLabel = ' - Close View';
                } else {
                    $zoomLabel = ' - Street Level';
                }

                $tabs .= '<option value="'.$i.'" '.$selected.'>'.$i.$zoomLabel.'</option>';
            }

            $tabs .= '
                            </select>
                            <button type="button" class="btn btn-outline-secondary" onclick="resetToDefault()">
                                <i class="fa fa-refresh"></i>
                            </button>
                        </div>
                        <small class="form-text text-muted">
                            Choose zoom level: 8=Far, 12=Default, 16=Close view
                        </small>
                    </div>
                    
                    <!-- Quick Actions -->
                    <div class="col-12 mb-3">
                        <div class="d-flex gap-2 flex-wrap">
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="getCurrentLocation()">
                                <i class="fa fa-location-arrow me-1"></i>
                                Get Current Location
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-info" onclick="setSharjahDefault()">
                                <i class="fa fa-map-marker me-1"></i>
                                Set Sharjah Center
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-success" onclick="setDubaiDefault()">
                                <i class="fa fa-building me-1"></i>
                                Set Dubai Center
                            </button>
                        </div>
                    </div>

                    <!-- Map Points Section -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fa fa-map-marker me-2"></i>
                                    Custom Map Points
                                </h5>
                            </div>
                            <div class="card-body">
                                <div id="map-points-container">';

            if (! empty($mapPoints) && is_array($mapPoints)) {
                foreach ($mapPoints as $index => $point) {
                    $tabs .= '
                                        <div class="map-point-item border rounded p-3 mb-3 bg-light" data-index="'.$index.'">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h6 class="mb-0">
                                                    <i class="fa fa-map-marker me-2"></i>
                                                    Map Point #'.($index + 1).'
                                                </h6>
                                                <button type="button" class="btn btn-sm btn-outline-danger remove-map-point">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-6 mb-2">
                                                    <label class="form-label">Point Title <span class="text-danger">*</span></label>
                                                    <input type="text" 
                                                           name="map_points['.$index.'][title]" 
                                                           class="form-control" 
                                                           value="'.htmlspecialchars(old('map_points.'.$index.'.title', $point['title'] ?? '')).'" 
                                                           placeholder="Enter point title"
                                                           required>
                                                </div>
                                                <div class="col-md-6 mb-2">
                                                    <label class="form-label">Description</label>
                                                    <textarea name="map_points['.$index.'][description]" 
                                                              class="form-control" 
                                                              rows="2"
                                                              placeholder="Brief description">'.htmlspecialchars(old('map_points.'.$index.'.description', $point['description'] ?? '')).'</textarea>
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <label class="form-label">Latitude <span class="text-danger">*</span></label>
                                                    <input type="text" 
                                                           name="map_points['.$index.'][latitude]" 
                                                           class="form-control" 
                                                           value="'.htmlspecialchars(old('map_points.'.$index.'.latitude', $point['latitude'] ?? '')).'" 
                                                           placeholder="25.3463"
                                                           required>
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <label class="form-label">Longitude <span class="text-danger">*</span></label>
                                                    <input type="text" 
                                                           name="map_points['.$index.'][longitude]" 
                                                           class="form-control" 
                                                           value="'.htmlspecialchars(old('map_points.'.$index.'.longitude', $point['longitude'] ?? '')).'" 
                                                           placeholder="55.4209"
                                                           required>
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <label class="form-label">Link URL</label>
                                                    <input type="url" 
                                                           name="map_points['.$index.'][link_url]" 
                                                           class="form-control" 
                                                           value="'.htmlspecialchars(old('map_points.'.$index.'.link_url', $point['link_url'] ?? '')).'" 
                                                           placeholder="https://example.com">
                                                </div>
                                                <div class="col-md-2 mb-2">
                                                    <label class="form-label">Visible</label>
                                                    <select name="map_points['.$index.'][is_visible]" class="form-select">
                                                        <option value="1" '.(old('map_points.'.$index.'.is_visible', $point['is_visible'] ?? '1') == '1' ? 'selected' : '').'>Yes</option>
                                                        <option value="0" '.(old('map_points.'.$index.'.is_visible', $point['is_visible'] ?? '1') == '0' ? 'selected' : '').'>No</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>';
                }
            }

            $tabs .= '</div>
                                
                                <div class="text-center mt-3">
                                    <button type="button" class="btn btn-primary" id="add-map-point">
                                        <i class="fa fa-plus me-2"></i>Add New Map Point
                                    </button>
                                </div>';

            if (empty($mapPoints)) {
                $tabs .= '
                                    <div class="text-center text-muted mt-3" id="no-points-message">
                                        <i class="fa fa-map-o fa-3x"></i>
                                        <p class="mt-2">No map points added yet. Click "Add New Map Point" to start.</p>
                                    </div>';
            }

            $tabs .= '
                            </div>
                        </div>
                    </div>
                </div>
            </div>';

            // Add JavaScript
            $tabs .= '<script>
            document.addEventListener("DOMContentLoaded", function() {
                let mapPointIndex = '.count($mapPoints).';
                
                // Quick location functions
                window.getCurrentLocation = function() {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(function(position) {
                            const lat = position.coords.latitude;
                            const lng = position.coords.longitude;
                            document.querySelector("input[name=\"map_center\"]").value = lat + ", " + lng;
                            alert("Location set to: " + lat.toFixed(6) + ", " + lng.toFixed(6));
                        }, function(error) {
                            alert("Error getting location: " + error.message);
                        });
                    } else {
                        alert("Geolocation is not supported by this browser.");
                    }
                };

                window.resetToDefault = function() {
                    document.querySelector("input[name=\"map_center\"]").value = "25.3463, 55.4209";
                    const zoomSelect = document.querySelector("select[name=\"map_zoom\"]");
                    if (zoomSelect) zoomSelect.value = "12";
                };

                window.setSharjahDefault = function() {
                    document.querySelector("input[name=\"map_center\"]").value = "25.3463, 55.4209";
                    const zoomSelect = document.querySelector("select[name=\"map_zoom\"]");
                    if (zoomSelect) zoomSelect.value = "12";
                };

                window.setDubaiDefault = function() {
                    document.querySelector("input[name=\"map_center\"]").value = "25.2048, 55.2708";
                    const zoomSelect = document.querySelector("select[name=\"map_zoom\"]");
                    if (zoomSelect) zoomSelect.value = "11";
                };

                // Auto-format map center input
                const mapCenterInput = document.querySelector("input[name=\"map_center\"]");
                if (mapCenterInput) {
                    mapCenterInput.addEventListener("blur", function() {
                        let value = this.value.trim();
                        if (value) {
                            // Remove extra spaces and ensure proper comma format
                            value = value.replace(/\s*,\s*/, ", ");
                            this.value = value;
                        }
                    });
                }

                // Validate zoom level
                const mapZoomInput = document.querySelector("input[name=\"map_zoom\"]");
                if (mapZoomInput) {
                    mapZoomInput.addEventListener("change", function() {
                        const value = parseInt(this.value);
                        if (value && (value < 1 || value > 20)) {
                            alert("Zoom level should be between 1 and 20");
                            this.value = "12";
                        }
                    });
                }
                
                // Add new map point
                const addButton = document.getElementById("add-map-point");
                if (addButton) {
                    addButton.addEventListener("click", function() {
                        const container = document.getElementById("map-points-container");
                        const noPointsMessage = document.getElementById("no-points-message");
                        
                        if (noPointsMessage) {
                            noPointsMessage.style.display = "none";
                        }
                        
                        const newPoint = `
                            <div class="map-point-item border rounded p-3 mb-3 bg-light" data-index="${mapPointIndex}">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0">
                                        <i class="fa fa-map-marker me-2"></i>
                                        Map Point #${mapPointIndex + 1}
                                    </h6>
                                    <button type="button" class="btn btn-sm btn-outline-danger remove-map-point">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Point Title <span class="text-danger">*</span></label>
                                        <input type="text" name="map_points[${mapPointIndex}][title]" class="form-control" placeholder="Enter point title" required>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Description</label>
                                        <textarea name="map_points[${mapPointIndex}][description]" class="form-control" rows="2" placeholder="Brief description"></textarea>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label class="form-label">Latitude <span class="text-danger">*</span></label>
                                        <input type="text" name="map_points[${mapPointIndex}][latitude]" class="form-control" placeholder="25.3463" required>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label class="form-label">Longitude <span class="text-danger">*</span></label>
                                        <input type="text" name="map_points[${mapPointIndex}][longitude]" class="form-control" placeholder="55.4209" required>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label class="form-label">Link URL</label>
                                        <input type="url" name="map_points[${mapPointIndex}][link_url]" class="form-control" placeholder="https://example.com">
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        <label class="form-label">Visible</label>
                                        <select name="map_points[${mapPointIndex}][is_visible]" class="form-select">
                                            <option value="1" selected>Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        `;
                        container.insertAdjacentHTML("beforeend", newPoint);
                        mapPointIndex++;
                    });
                }
                
                // Remove map point
                document.addEventListener("click", function(e) {
                    if (e.target.classList.contains("remove-map-point") || e.target.closest(".remove-map-point")) {
                        const pointItem = e.target.closest(".map-point-item");
                        if (pointItem) {
                            pointItem.remove();
                            
                            // Show no points message if no points left
                            const remainingPoints = document.querySelectorAll(".map-point-item");
                            const noPointsMessage = document.getElementById("no-points-message");
                            if (remainingPoints.length === 0 && noPointsMessage) {
                                noPointsMessage.style.display = "block";
                            }
                        }
                    }
                });
            });
            </script>';

            $tabs .= '</div>';

            // Working Hours & Contact Tab Content
            $tabs .= '<div class="tab-pane fade" id="tabs-working-hours" role="tabpanel">';

            // Get working hours and contact data
            $workingHours = get_field('working_hours', $pageId) ?: [];
            $contactInfo = get_field('contact_info', $pageId) ?: [];
            $showWorkingHours = get_field('show_working_hours', $pageId);
            $showWorkingHours = ($showWorkingHours === null || $showWorkingHours === '1' || $showWorkingHours === 1 || $showWorkingHours === true) ? true : false;

            $tabs .= '
            <div class="alert alert-info">
                <i class="fa fa-info-circle me-2"></i>
                Configure working hours and contact information for the "Main with Map and Hours" template.
            </div>

            <!-- Show/Hide Working Hours & Contact -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card bg-light">
                        <div class="card-body">
                            <div class="form-check form-switch">
                                <input type="hidden" name="show_working_hours" value="0">
                                <input class="form-check-input" type="checkbox" 
                                       name="show_working_hours" 
                                       id="show_working_hours_toggle"
                                       value="1" '.($showWorkingHours ? 'checked' : '').'>
                                <label class="form-check-label fw-bold" for="show_working_hours_toggle">
                                    <i class="fa fa-eye me-2"></i>Display Working Hours & Contact Info on Frontend
                                </label>
                                <small class="d-block text-muted mt-1">
                                    Turn this on to show the working hours, contact information, and address on the page. Turn off to hide this section completely.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Working Hours Section -->
                <div class="col-12 mb-4">
                    <div class="bg-light rounded p-3">
                        <h5 class="mb-3">
                            <i class="fa fa-clock-o me-2"></i>
                            Working Hours
                        </h5>
                        
                        <div class="row">';

            $daysOfWeek = [
                'monday' => 'Monday',
                'tuesday' => 'Tuesday',
                'wednesday' => 'Wednesday',
                'thursday' => 'Thursday',
                'friday' => 'Friday',
                'saturday' => 'Saturday',
                'sunday' => 'Sunday',
            ];

            foreach ($daysOfWeek as $day => $dayLabel) {
                $dayData = $workingHours[$day] ?? ['open' => '09:00', 'close' => '18:00', 'is_open' => true];
                $isOpen = isset($dayData['is_open']) ? (bool) $dayData['is_open'] : true;

                $tabs .= '
                            <div class="col-md-6 col-lg-4 mb-3">
                                <div class="card">
                                    <div class="card-header py-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <strong>'.$dayLabel.'</strong>
                                            <div class="form-check form-switch">
                                                <input type="hidden" name="working_hours['.$day.'][is_open]" value="0">
                                                <input class="form-check-input" type="checkbox" 
                                                       name="working_hours['.$day.'][is_open]" 
                                                       value="1" '.($isOpen ? 'checked' : '').'
                                                       onchange="toggleDayHours(this, \''.$day.'\')">
                                                <label class="form-check-label">Open</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body py-2" id="hours-'.$day.'" '.(! $isOpen ? 'style="display:none"' : '').'>
                                        <div class="row">
                                            <div class="col-6">
                                                <label class="form-label small">Open</label>
                                                <input type="time" name="working_hours['.$day.'][open]" 
                                                       class="form-control form-control-sm" 
                                                       value="'.($dayData['open'] ?? '09:00').'">
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label small">Close</label>
                                                <input type="time" name="working_hours['.$day.'][close]" 
                                                       class="form-control form-control-sm" 
                                                       value="'.($dayData['close'] ?? '18:00').'">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>';
            }

            $tabs .= '
                        </div>
                    </div>
                </div>

                <!-- Contact Information Section -->
                <div class="col-12 mb-4">
                    <div class="bg-light rounded p-3">
                        <h5 class="mb-3">
                            <i class="fa fa-address-book me-2"></i>
                            Contact Information
                        </h5>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="tel" name="contact_info[phone]" 
                                       class="form-control" 
                                       value="'.htmlspecialchars($contactInfo['phone'] ?? '').'" 
                                       placeholder="+971 6 568 5050">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="contact_info[email]" 
                                       class="form-control" 
                                       value="'.htmlspecialchars($contactInfo['email'] ?? '').'" 
                                       placeholder="info@example.com">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Website</label>
                                <input type="url" name="contact_info[website]" 
                                       class="form-control" 
                                       value="'.htmlspecialchars($contactInfo['website'] ?? '').'" 
                                       placeholder="https://example.com">
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Address</label>
                                <textarea name="contact_info[address]" 
                                          class="form-control" 
                                          rows="2" 
                                          placeholder="Enter full address">'.htmlspecialchars($contactInfo['address'] ?? '').'</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
            function toggleDayHours(checkbox, day) {
                const hoursSection = document.getElementById("hours-" + day);
                if (checkbox.checked) {
                    hoursSection.style.display = "block";
                } else {
                    hoursSection.style.display = "none";
                }
            }
            </script>';

            $tabs .= '</div>';

            // Related Pages Tab Content
            $tabs .= '<div class="tab-pane fade" id="tabs-related-pages" role="tabpanel">';

            // Get related pages data
            $relatedPages = get_field('related_pages', $pageId) ?: [];

            // Get all available pages (excluding current page)
            $availablePages = \Botble\Page\Models\Page::query()
                ->where('status', 'published')
                ->where('id', '!=', $pageId ?: 0)
                ->orderBy('name', 'asc')
                ->get();

            $tabs .= '
            <div class="alert alert-info">
                <i class="fa fa-info-circle me-2"></i>
                Select pages that are related to this page. These will be displayed in related sections on the frontend.
            </div>

            <div class="row">
                <!-- Related Pages Selection -->
                <div class="col-12 mb-4">
                    <div class="bg-light rounded p-3">
                        <h5 class="mb-3">
                            <i class="fa fa-link me-2"></i>
                            Select Related Pages
                        </h5>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Available Pages</label>
                                <div class="list-group" id="available-pages-list" style="max-height: 400px; overflow-y: auto;">';

            foreach ($availablePages as $page) {
                $isSelected = in_array($page->id, $relatedPages);
                $tabs .= '
                                    <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center page-item" 
                                         data-page-id="'.$page->id.'" 
                                         data-page-name="'.htmlspecialchars($page->name).'"
                                         style="'.($isSelected ? 'display: none;' : '').'">
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                <strong>'.htmlspecialchars($page->name).'</strong>';

                if ($page->description) {
                    $tabs .= '<br><small class="text-muted">'.htmlspecialchars(Str::limit($page->description, 60)).'</small>';
                }

                $tabs .= '
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-primary add-related-page">
                                            <i class="fa fa-plus"></i> Add
                                        </button>
                                    </div>';
            }

            $tabs .= '
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Selected Related Pages</label>
                                <div class="list-group" id="selected-pages-list" style="max-height: 400px; overflow-y: auto;">';

            // Show already selected pages
            if (! empty($relatedPages)) {
                foreach ($relatedPages as $pageId) {
                    $page = $availablePages->firstWhere('id', $pageId);
                    if ($page) {
                        $tabs .= '
                                        <div class="list-group-item list-group-item-success d-flex justify-content-between align-items-center selected-page-item" 
                                             data-page-id="'.$page->id.'">
                                            <div class="d-flex align-items-center">
                                                <div class="me-3">
                                                    <strong>'.htmlspecialchars($page->name).'</strong>';

                        if ($page->description) {
                            $tabs .= '<br><small class="text-muted">'.htmlspecialchars(Str::limit($page->description, 60)).'</small>';
                        }

                        $tabs .= '
                                                </div>
                                            </div>
                                            <div>
                                                <button type="button" class="btn btn-sm btn-outline-secondary move-up" title="Move Up">
                                                    <i class="fa fa-arrow-up"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-secondary move-down" title="Move Down">
                                                    <i class="fa fa-arrow-down"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-danger remove-related-page" title="Remove">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </div>
                                            <input type="hidden" name="related_pages[]" value="'.$page->id.'">
                                        </div>';
                    }
                }
            }

            $tabs .= '
                                </div>
                                
                                <div class="text-center mt-3" id="no-related-pages" '.(! empty($relatedPages) ? 'style="display: none;"' : '').'>
                                    <i class="fa fa-chain-broken fa-3x text-muted"></i>
                                    <p class="text-muted mt-2">No related pages selected yet.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="d-flex justify-content-center gap-2">
                                    <button type="button" class="btn btn-outline-secondary" onclick="clearAllRelatedPages()">
                                        <i class="fa fa-trash me-1"></i>Clear All
                                    </button>
                                    <small class="align-self-center text-muted ms-3">
                                        Selected: <span id="related-count">'.count($relatedPages).'</span> pages
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
            document.addEventListener("DOMContentLoaded", function() {
                const availableList = document.getElementById("available-pages-list");
                const selectedList = document.getElementById("selected-pages-list");
                const noRelatedMessage = document.getElementById("no-related-pages");
                const relatedCount = document.getElementById("related-count");

                // Add related page
                availableList.addEventListener("click", function(e) {
                    if (e.target.classList.contains("add-related-page") || e.target.closest(".add-related-page")) {
                        const pageItem = e.target.closest(".page-item");
                        const pageId = pageItem.dataset.pageId;
                        const pageName = pageItem.dataset.pageName;
                        
                        // Hide from available list
                        pageItem.style.display = "none";
                        
                        // Add to selected list
                        const selectedItem = createSelectedPageItem(pageId, pageName, pageItem.querySelector("small") ? pageItem.querySelector("small").textContent : "");
                        selectedList.appendChild(selectedItem);
                        
                        // Hide no pages message
                        noRelatedMessage.style.display = "none";
                        
                        updateRelatedCount();
                    }
                });

                // Remove related page
                selectedList.addEventListener("click", function(e) {
                    if (e.target.classList.contains("remove-related-page") || e.target.closest(".remove-related-page")) {
                        const selectedItem = e.target.closest(".selected-page-item");
                        const pageId = selectedItem.dataset.pageId;
                        
                        // Show in available list
                        const availableItem = availableList.querySelector(`[data-page-id="${pageId}"]`);
                        if (availableItem) {
                            availableItem.style.display = "flex";
                        }
                        
                        // Remove from selected list
                        selectedItem.remove();
                        
                        // Show no pages message if empty
                        if (selectedList.children.length === 0) {
                            noRelatedMessage.style.display = "block";
                        }
                        
                        updateRelatedCount();
                    }
                    
                    // Move up
                    if (e.target.classList.contains("move-up") || e.target.closest(".move-up")) {
                        const item = e.target.closest(".selected-page-item");
                        const prevItem = item.previousElementSibling;
                        if (prevItem) {
                            selectedList.insertBefore(item, prevItem);
                        }
                    }
                    
                    // Move down
                    if (e.target.classList.contains("move-down") || e.target.closest(".move-down")) {
                        const item = e.target.closest(".selected-page-item");
                        const nextItem = item.nextElementSibling;
                        if (nextItem) {
                            selectedList.insertBefore(nextItem, item);
                        }
                    }
                });

                function createSelectedPageItem(pageId, pageName, description) {
                    const div = document.createElement("div");
                    div.className = "list-group-item list-group-item-success d-flex justify-content-between align-items-center selected-page-item";
                    div.dataset.pageId = pageId;
                    
                    div.innerHTML = `
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <strong>${pageName}</strong>
                                ${description ? `<br><small class="text-muted">${description}</small>` : ""}
                            </div>
                        </div>
                        <div>
                            <button type="button" class="btn btn-sm btn-outline-secondary move-up" title="Move Up">
                                <i class="fa fa-arrow-up"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary move-down" title="Move Down">
                                <i class="fa fa-arrow-down"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger remove-related-page" title="Remove">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                        <input type="hidden" name="related_pages[]" value="${pageId}">
                    `;
                    
                    return div;
                }

                function updateRelatedCount() {
                    const count = selectedList.querySelectorAll(".selected-page-item").length;
                    relatedCount.textContent = count;
                }

                // Clear all related pages
                window.clearAllRelatedPages = function() {
                    if (confirm("Are you sure you want to remove all related pages?")) {
                        // Show all available pages
                        availableList.querySelectorAll(".page-item").forEach(item => {
                            item.style.display = "flex";
                        });
                        
                        // Clear selected list
                        selectedList.innerHTML = "";
                        
                        // Show no pages message
                        noRelatedMessage.style.display = "block";
                        
                        updateRelatedCount();
                    }
                };
            });
            </script>';

            $tabs .= '</div>';

            // Menu Tab Content
            $menuItems = get_field('menu_items', $pageId) ?: [];
            $showMenu = get_field('show_menu', $pageId) ?: false;

            $tabs .= '<div class="tab-pane fade" id="tabs-menu" role="tabpanel">';

            $tabs .= '<div class="alert alert-info">
                <i class="fa fa-info-circle me-2"></i>
                '.__('Add Menu items for this page. You can add a name and URL, reorder items, hide/show each item, or remove it.').'
            </div>';

            $tabs .= '<div class="row mb-3">
                <div class="col-12">
                    <div class="card bg-light p-3">
                        <div class="form-check form-switch">
                            <input type="hidden" name="show_menu" value="0">
                            <input class="form-check-input" type="checkbox" name="show_menu" id="show_menu_toggle" value="1" '.($showMenu ? 'checked' : '').'>
                            <label class="form-check-label fw-bold" for="show_menu_toggle">'.__('Show Menu').'</label>
                        </div>
                    </div>
                </div>
            </div>';

            $tabs .= '<div id="menu-items-container">';

            if (! empty($menuItems) && is_array($menuItems)) {
                foreach ($menuItems as $index => $item) {
                    $tabs .= '<div class="menu-item border rounded p-3 mb-3 bg-light d-flex flex-column" data-index="'.$index.'">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">'.sprintf(__('Menu Item #%d'), ($index + 1)).'</h6>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-outline-secondary move-up" title="Move Up"><i class="fa fa-arrow-up"></i></button>
                                <button type="button" class="btn btn-sm btn-outline-secondary move-down" title="Move Down"><i class="fa fa-arrow-down"></i></button>
                                <button type="button" class="btn btn-sm btn-outline-danger remove-menu-item"><i class="fa fa-trash"></i></button>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-6 mb-2">
                                <label class="form-label">'.__('Name').'</label>
                                <input type="text" name="menu_items['.$index.'][name]" class="form-control" value="'.htmlspecialchars($item['name'] ?? '').'" placeholder="'.__('Menu name').'">
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label">'.__('URL').'</label>
                                <input type="url" name="menu_items['.$index.'][url]" class="form-control" value="'.htmlspecialchars($item['url'] ?? '').'" placeholder="https://example.com">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label class="form-label">'.__('Visible').'</label>
                                <select name="menu_items['.$index.'][is_visible]" class="form-select">
                                    <option value="1" '.((isset($item['is_visible']) && $item['is_visible']) ? 'selected' : '').'>Yes</option>
                                    <option value="0" '.((isset($item['is_visible']) && ! $item['is_visible']) ? 'selected' : '').'>No</option>
                                </select>
                            </div>
                        </div>
                    </div>';
                }
            }

            $tabs .= '</div>';

            $tabs .= '<div class="text-center">
                <button type="button" class="btn btn-primary" id="add-menu-item"><i class="fa fa-plus me-2"></i>'.__('Add Menu Item').'</button>
            </div>';

            $tabs .= '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    document.getElementById("add-menu-item").addEventListener("click", function() {
                        const container = document.getElementById("menu-items-container");
                        const idx = container.querySelectorAll(".menu-item").length;
                        const itemHtml = `
                            <div class="menu-item border rounded p-3 mb-3 bg-light d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Menu Item #${idx + 1}</h6>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-secondary move-up" title="Move Up"><i class="fa fa-arrow-up"></i></button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary move-down" title="Move Down"><i class="fa fa-arrow-down"></i></button>
                                        <button type="button" class="btn btn-sm btn-outline-danger remove-menu-item"><i class="fa fa-trash"></i></button>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">'.__('Name').'</label>
                                        <input type="text" name="menu_items[${idx}][name]" class="form-control" placeholder="'.__('Menu name').'">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">'.__('URL').'</label>
                                        <input type="url" name="menu_items[${idx}][url]" class="form-control" placeholder="https://example.com">
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label class="form-label">'.__('Visible').'</label>
                                        <select name="menu_items[${idx}][is_visible]" class="form-select">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>`;
                        container.insertAdjacentHTML("beforeend", itemHtml);
                    });

                    // Delegate events for remove/move
                    document.addEventListener("click", function(e) {
                        if (e.target.closest(".remove-menu-item")) {
                            const item = e.target.closest(".menu-item");
                            item.remove();
                        }

                        if (e.target.closest(".move-up")) {
                            const item = e.target.closest(".menu-item");
                            const prev = item.previousElementSibling;
                            if (prev && prev.classList.contains("menu-item")) {
                                prev.parentNode.insertBefore(item, prev);
                            }
                        }

                        if (e.target.closest(".move-down")) {
                            const item = e.target.closest(".menu-item");
                            const next = item.nextElementSibling;
                            if (next && next.classList.contains("menu-item")) {
                                next.parentNode.insertBefore(next, item);
                            }
                        }
                    });
                });
            </script>';

            $tabs .= '</div>';

            // Page Header Tab Content
            $tabs .= '<div class="tab-pane fade" id="tabs-page-header" role="tabpanel">';

            $pageId = $model->id ?? 0;
            $headerType = get_field('header_type', $pageId) ?: 'slider';
            $headerSliderImages = get_field('header_slider_images', $pageId) ?: [];
            $headerVideoUrl = get_field('header_video_url', $pageId) ?: '';
            $headerVideoThumbnail = get_field('header_video_thumbnail', $pageId) ?: '';
            $headerImage = get_field('header_image', $pageId) ?: '';

            $tabs .= '
            <div class="alert alert-info">
                <i class="fa fa-info-circle me-2"></i>
                Configure the page header that appears at the top of the page.
            </div>

            <div class="row">
                <div class="col-12 mb-3">
                    <label class="form-label fw-bold">Header Type</label>
                    <select name="header_type" id="header_type_select" class="form-select">
                        <option value="slider" '.($headerType === 'slider' ? 'selected' : '').'>Slider</option>
                        <option value="video" '.($headerType === 'video' ? 'selected' : '').'>Video</option>
                        <option value="image" '.($headerType === 'image' ? 'selected' : '').'>Image</option>
                        <option value="map" '.($headerType === 'map' ? 'selected' : '').'>Map</option>
                    </select>
                </div>
            </div>

            <!-- Slider Section -->
            <div id="slider_section" class="'.($headerType === 'slider' ? '' : 'd-none').'">
                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">
                            <i class="fa fa-images me-2"></i>Slider Images
                        </label>
                        <div id="slider_images_container" class="border rounded p-3 bg-white">
                            <div id="slider_images_list"></div>
                            <button type="button" id="add_slider_image" class="btn btn-primary btn-sm mt-2">
                                <i class="fa fa-plus me-2"></i>Add Image
                            </button>
                            <input type="hidden" name="header_slider_images" id="header_slider_images_field" value="">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Video Section -->
            <div id="video_section" class="'.($headerType === 'video' ? '' : 'd-none').'">
                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">
                            <i class="fa fa-video me-2"></i>Video URL
                        </label>
                        <input type="text" name="header_video_url" id="header_video_url" class="form-control" 
                               value="'.htmlspecialchars($headerVideoUrl).'" 
                               placeholder="https://youtube.com/watch?v=... or https://vimeo.com/...">
                        <small class="form-text text-muted">Enter YouTube or Vimeo video URL</small>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">
                            <i class="fa fa-image me-2"></i>Video Thumbnail
                        </label>
                        <div id="video_thumbnail_preview" class="mb-3">
                            '.($headerVideoThumbnail ? '<img src="'.htmlspecialchars($headerVideoThumbnail).'" class="img-thumbnail" style="max-width: 300px;">' : '<p class="text-muted">No thumbnail selected</p>').'
                        </div>
                        <button type="button" id="video_thumbnail_picker" class="btn btn-outline-primary">
                            <i class="fa fa-folder-open me-2"></i>Choose Thumbnail
                        </button>
                        <input type="hidden" name="header_video_thumbnail" id="header_video_thumbnail_field" value="'.htmlspecialchars($headerVideoThumbnail).'">
                    </div>
                </div>
            </div>

            <!-- Image Section -->
            <div id="image_section" class="'.($headerType === 'image' ? '' : 'd-none').'">
                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">
                            <i class="fa fa-image me-2"></i>Header Image
                        </label>
                        <div id="header_image_preview" class="mb-3">
                            '.($headerImage ? '<img src="'.htmlspecialchars($headerImage).'" class="img-thumbnail" style="max-width: 300px;">' : '<p class="text-muted">No image selected</p>').'
                        </div>
                        <button type="button" id="header_image_picker" class="btn btn-outline-primary">
                            <i class="fa fa-folder-open me-2"></i>Choose Image
                        </button>
                        <input type="hidden" name="header_image" id="header_image_field" value="'.htmlspecialchars($headerImage).'">
                    </div>
                </div>
            </div>

            <!-- Map Section -->
            <div id="map_section" class="'.($headerType === 'map' ? '' : 'd-none').'">
                <div class="row">
                    <!-- Map Center Latitude -->
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold">
                            <i class="fa fa-crosshairs me-2"></i>
                            Map Center Latitude
                        </label>
                        <input type="text" 
                               name="header_map_center_latitude" 
                               id="header_map_center_latitude"
                               class="form-control" 
                               value="'.htmlspecialchars(get_field('header_map_center_latitude', $pageId) ?: '').'" 
                               placeholder="25.3463">
                        <small class="form-text text-muted">
                            Enter latitude
                        </small>
                    </div>

                    <!-- Map Center Longitude -->
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold">
                            <i class="fa fa-crosshairs me-2"></i>
                            Map Center Longitude
                        </label>
                        <input type="text" 
                               name="header_map_center_longitude" 
                               id="header_map_center_longitude"
                               class="form-control" 
                               value="'.htmlspecialchars(get_field('header_map_center_longitude', $pageId) ?: '').'" 
                               placeholder="55.4209">
                        <small class="form-text text-muted">
                            Enter longitude
                        </small>
                    </div>

                    <!-- Map Zoom -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">
                            <i class="fa fa-search-plus me-2"></i>
                            Map Zoom Level
                        </label>
                        <select name="header_map_zoom" id="header_map_zoom" class="form-select">
                            <option value="">Use Default (12)</option>';

            $headerMapZoom = get_field('header_map_zoom', $pageId) ?: 12;
            for ($i = 8; $i <= 18; $i++) {
                $selected = ($headerMapZoom == $i) ? 'selected' : '';
                $zoomLabel = '';
                if ($i <= 10) {
                    $zoomLabel = ' - Far View';
                } elseif ($i <= 13) {
                    $zoomLabel = ' - Medium View';
                } elseif ($i <= 15) {
                    $zoomLabel = ' - Close View';
                } else {
                    $zoomLabel = ' - Street Level';
                }

                $tabs .= '<option value="'.$i.'" '.$selected.'>'.$i.$zoomLabel.'</option>';
            }

            $tabs .= '
                        </select>
                        <small class="form-text text-muted">
                            Choose zoom level: 8=Far, 12=Default, 16=Close view
                        </small>
                    </div>

                    <!-- Map Points Section -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fa fa-map-marker me-2"></i>
                                    Map Points
                                </h5>
                            </div>
                            <div class="card-body">
                                <div id="header_map_points_container">';

            $headerMapPoints = get_field('header_map_points', $pageId) ?: [];
            if (! empty($headerMapPoints) && is_array($headerMapPoints)) {
                foreach ($headerMapPoints as $index => $point) {
                    $tabs .= '
                                        <div class="map-point-item border rounded p-3 mb-3 bg-light" data-index="'.$index.'">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h6 class="mb-0">
                                                    <i class="fa fa-map-marker me-2"></i>
                                                    Map Point #'.($index + 1).'
                                                </h6>
                                                <button type="button" class="btn btn-sm btn-outline-danger remove-header-map-point">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-6 mb-2">
                                                    <label class="form-label">Point Title <span class="text-danger">*</span></label>
                                                    <input type="text" 
                                                           name="header_map_points['.$index.'][title]" 
                                                           class="form-control" 
                                                           value="'.htmlspecialchars($point['title'] ?? '').'" 
                                                           placeholder="Enter point title"
                                                           required>
                                                </div>
                                                <div class="col-md-6 mb-2">
                                                    <label class="form-label">Description</label>
                                                    <textarea name="header_map_points['.$index.'][description]" 
                                                              class="form-control" 
                                                              rows="2"
                                                              placeholder="Brief description">'.htmlspecialchars($point['description'] ?? '').'</textarea>
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <label class="form-label">Latitude <span class="text-danger">*</span></label>
                                                    <input type="text" 
                                                           name="header_map_points['.$index.'][latitude]" 
                                                           class="form-control" 
                                                           value="'.htmlspecialchars($point['latitude'] ?? '').'" 
                                                           placeholder="25.3463"
                                                           required>
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <label class="form-label">Longitude <span class="text-danger">*</span></label>
                                                    <input type="text" 
                                                           name="header_map_points['.$index.'][longitude]" 
                                                           class="form-control" 
                                                           value="'.htmlspecialchars($point['longitude'] ?? '').'" 
                                                           placeholder="55.4209"
                                                           required>
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <label class="form-label">Link URL <span class="text-danger">*</span></label>
                                                    <input type="url" 
                                                           name="header_map_points['.$index.'][link_url]" 
                                                           class="form-control" 
                                                           value="'.htmlspecialchars($point['link_url'] ?? '').'" 
                                                           placeholder="https://example.com"
                                                           required>
                                                </div>
                                                <div class="col-md-2 mb-2">
                                                    <label class="form-label">Visible <span class="text-danger">*</span></label>
                                                    <select name="header_map_points['.$index.'][is_visible]" class="form-select" required>
                                                        <option value="1" '.(($point['is_visible'] ?? 1) == 1 ? 'selected' : '').'>Yes</option>
                                                        <option value="0" '.(($point['is_visible'] ?? 1) == 0 ? 'selected' : '').'>No</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>';
                }
            }

            $tabs .= '</div>
                                
                                <div class="text-center mt-3">
                                    <button type="button" class="btn btn-primary" id="add-header-map-point">
                                        <i class="fa fa-plus me-2"></i>Add New Map Point
                                    </button>
                                </div>';

            if (empty($headerMapPoints)) {
                $tabs .= '
                                    <div class="text-center text-muted mt-3" id="no-header-map-points-message">
                                        <i class="fa fa-map-o fa-3x"></i>
                                        <p class="mt-2">No map points added yet. Click "Add New Map Point" to start.</p>
                                    </div>';
            }

            $tabs .= '
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
            document.addEventListener("DOMContentLoaded", function() {
                const typeSelect = document.getElementById("header_type_select");
                const sliderSection = document.getElementById("slider_section");
                const videoSection = document.getElementById("video_section");
                const imageSection = document.getElementById("image_section");
                const mapSection = document.getElementById("map_section");
                
                typeSelect.addEventListener("change", function() {
                    sliderSection.classList.add("d-none");
                    videoSection.classList.add("d-none");
                    imageSection.classList.add("d-none");
                    mapSection.classList.add("d-none");
                    
                    if (this.value === "slider") {
                        sliderSection.classList.remove("d-none");
                    } else if (this.value === "video") {
                        videoSection.classList.remove("d-none");
                    } else if (this.value === "image") {
                        imageSection.classList.remove("d-none");
                    } else if (this.value === "map") {
                        mapSection.classList.remove("d-none");
                    }
                });

                // Slider Images Manager
                const sliderContainer = document.getElementById("slider_images_list");
                const sliderField = document.getElementById("header_slider_images_field");
                const addSliderBtn = document.getElementById("add_slider_image");
                
                let sliderImages = '.json_encode($headerSliderImages).' || [];
                
                function renderSliderImages() {
                    sliderContainer.innerHTML = "";
                    
                    if (sliderImages.length === 0) {
                        sliderContainer.innerHTML = \'<p class="text-muted text-center py-3">No images added yet</p>\';
                    } else {
                        // Create grid container
                        const grid = document.createElement("div");
                        grid.className = "row g-3";
                        
                        sliderImages.forEach((img, index) => {
                            const col = document.createElement("div");
                            col.className = "col-md-4 col-sm-6 col-12";
                            col.innerHTML = `
                                <div class="card h-100 shadow-sm border-0 overflow-hidden">
                                    <div style="height: 150px; overflow: hidden; background: #f0f0f0;">
                                        <img src="${img}" class="w-100 h-100" style="object-fit: cover;" 
                                             onerror="this.src=\'https://via.placeholder.com/300x150?text=Image+Error\'; this.style.objectFit=\'contain\';">
                                    </div>
                                    <div class="card-body p-2">
                                        <button type="button" class="btn btn-sm btn-danger w-100" onclick="removeSliderImage(${index})">
                                            <i class="fa fa-trash me-1"></i>Remove
                                        </button>
                                    </div>
                                </div>
                            `;
                            grid.appendChild(col);
                        });
                        
                        sliderContainer.appendChild(grid);
                    }
                    
                    sliderField.value = JSON.stringify(sliderImages);
                }
                
                window.removeSliderImage = function(index) {
                    sliderImages.splice(index, 1);
                    renderSliderImages();
                };
                
                // Setup RvMedia for Slider
                if (typeof RvMediaStandAlone !== "undefined") {
                    new RvMediaStandAlone("#add_slider_image", {
                        multiple: true,
                        type: "image",
                        onSelectFiles: function(files, $el) {
                            files.forEach(file => {
                                let imageUrl = file.full_url || file.url || "";
                                if (imageUrl && !sliderImages.includes(imageUrl)) {
                                    sliderImages.push(imageUrl);
                                }
                            });
                            renderSliderImages();
                        }
                    });
                } else {
                    // Fallback if RvMediaStandAlone is not available
                    addSliderBtn.addEventListener("click", function(e) {
                        e.preventDefault();
                        const url = prompt("Enter image URL:");
                        if (url) {
                            sliderImages.push(url);
                            renderSliderImages();
                        }
                    });
                }
                
                renderSliderImages();

                // Image Picker with RvMedia
                const imagePicker = document.getElementById("header_image_picker");
                const imageField = document.getElementById("header_image_field");
                const imagePreview = document.getElementById("header_image_preview");
                
                if (typeof RvMediaStandAlone !== "undefined") {
                    new RvMediaStandAlone("#header_image_picker", {
                        multiple: false,
                        type: "image",
                        onSelectFiles: function(files, $el) {
                            if (files && files.length > 0) {
                                const file = files[0];
                                let imageUrl = file.full_url || file.url || "";
                                imageField.value = imageUrl;
                                if (imageUrl) {
                                    imagePreview.innerHTML = `<img src="${imageUrl}" class="img-thumbnail" style="max-width: 300px;">`;
                                }
                            }
                        }
                    });
                } else {
                    // Fallback if RvMediaStandAlone is not available
                    imagePicker.addEventListener("click", function(e) {
                        e.preventDefault();
                        const url = prompt("Enter image URL:");
                        if (url) {
                            imageField.value = url;
                            imagePreview.innerHTML = `<img src="${url}" class="img-thumbnail" style="max-width: 300px;">`;
                        }
                    });
                }

                // Video Thumbnail Picker with RvMedia
                const videoThumbnailPicker = document.getElementById("video_thumbnail_picker");
                const videoThumbnailField = document.getElementById("header_video_thumbnail_field");
                const videoThumbnailPreview = document.getElementById("video_thumbnail_preview");
                
                if (typeof RvMediaStandAlone !== "undefined") {
                    new RvMediaStandAlone("#video_thumbnail_picker", {
                        multiple: false,
                        type: "image",
                        onSelectFiles: function(files, $el) {
                            if (files && files.length > 0) {
                                const file = files[0];
                                let imageUrl = file.full_url || file.url || "";
                                videoThumbnailField.value = imageUrl;
                                if (imageUrl) {
                                    videoThumbnailPreview.innerHTML = `<img src="${imageUrl}" class="img-thumbnail" style="max-width: 300px;">`;
                                }
                            }
                        }
                    });
                } else {
                    // Fallback if RvMediaStandAlone is not available
                    videoThumbnailPicker.addEventListener("click", function(e) {
                        e.preventDefault();
                        const url = prompt("Enter image URL:");
                        if (url) {
                            videoThumbnailField.value = url;
                            videoThumbnailPreview.innerHTML = `<img src="${url}" class="img-thumbnail" style="max-width: 300px;">`;
                        }
                    });
                }

                // Map Points Manager
                const headerMapPointsContainer = document.getElementById("header_map_points_container");
                const addHeaderMapPointBtn = document.getElementById("add-header-map-point");
                let headerMapPointIndex = '.count($headerMapPoints).';
                
                if (addHeaderMapPointBtn) {
                    addHeaderMapPointBtn.addEventListener("click", function() {
                        const container = document.getElementById("header_map_points_container");
                        const noPointsMessage = document.getElementById("no-header-map-points-message");
                        
                        if (noPointsMessage) {
                            noPointsMessage.style.display = "none";
                        }
                        
                        const newPoint = `
                            <div class="map-point-item border rounded p-3 mb-3 bg-light" data-index="${headerMapPointIndex}">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0">
                                        <i class="fa fa-map-marker me-2"></i>
                                        Map Point #${headerMapPointIndex + 1}
                                    </h6>
                                    <button type="button" class="btn btn-sm btn-outline-danger remove-header-map-point">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Point Title <span class="text-danger">*</span></label>
                                        <input type="text" name="header_map_points[${headerMapPointIndex}][title]" class="form-control" placeholder="Enter point title" required>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Description</label>
                                        <textarea name="header_map_points[${headerMapPointIndex}][description]" class="form-control" rows="2" placeholder="Brief description"></textarea>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label class="form-label">Latitude <span class="text-danger">*</span></label>
                                        <input type="text" name="header_map_points[${headerMapPointIndex}][latitude]" class="form-control" placeholder="25.3463" required>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label class="form-label">Longitude <span class="text-danger">*</span></label>
                                        <input type="text" name="header_map_points[${headerMapPointIndex}][longitude]" class="form-control" placeholder="55.4209" required>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label class="form-label">Link URL <span class="text-danger">*</span></label>
                                        <input type="url" name="header_map_points[${headerMapPointIndex}][link_url]" class="form-control" placeholder="https://example.com" required>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        <label class="form-label">Visible <span class="text-danger">*</span></label>
                                        <select name="header_map_points[${headerMapPointIndex}][is_visible]" class="form-select" required>
                                            <option value="1" selected>Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        `;
                        container.insertAdjacentHTML("beforeend", newPoint);
                        headerMapPointIndex++;
                    });
                }
                
                // Remove header map point
                document.addEventListener("click", function(e) {
                    if (e.target.classList.contains("remove-header-map-point") || e.target.closest(".remove-header-map-point")) {
                        const pointItem = e.target.closest(".map-point-item");
                        if (pointItem) {
                            pointItem.remove();
                            
                            // Show no points message if no points left
                            const remainingPoints = headerMapPointsContainer.querySelectorAll(".map-point-item");
                            const noPointsMessage = document.getElementById("no-header-map-points-message");
                            if (remainingPoints.length === 0 && noPointsMessage) {
                                noPointsMessage.style.display = "block";
                            }
                        }
                    }
                });
            });
            </script>
            ';

            $tabs .= '</div>';

            // Page Settings Tab Content
            $tabs .= '<div class="tab-pane fade" id="tabs-page-settings" role="tabpanel">';

            $pageId = $model->id ?? 0;
            $pageLayout = get_field('page_layout', $pageId) ?: 'default';
            $enableComments = get_field('enable_comments', $pageId) ?: false;
            $enableSharing = get_field('enable_sharing', $pageId) ?: true;
            $customCssClass = get_field('custom_css_class', $pageId) ?: '';

            $tabs .= '
            <div class="alert alert-info">
                <i class="fa fa-info-circle me-2"></i>
                Configure additional page settings and options.
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Page Layout</label>
                    <select name="page_layout" class="form-select">
                        <option value="default" '.($pageLayout === 'default' ? 'selected' : '').'>Default</option>
                        <option value="sidebar-left" '.($pageLayout === 'sidebar-left' ? 'selected' : '').'>Sidebar Left</option>
                        <option value="sidebar-right" '.($pageLayout === 'sidebar-right' ? 'selected' : '').'>Sidebar Right</option>
                        <option value="full-width" '.($pageLayout === 'full-width' ? 'selected' : '').'>Full Width</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Custom CSS Class</label>
                    <input type="text" name="custom_css_class" class="form-control" 
                           value="'.htmlspecialchars($customCssClass).'" 
                           placeholder="e.g., custom-class-1 custom-class-2">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="card bg-light p-3">
                        <div class="form-check form-switch">
                            <input type="hidden" name="enable_comments" value="0">
                            <input class="form-check-input" type="checkbox" 
                                   name="enable_comments" 
                                   id="enable_comments_toggle"
                                   value="1" '.($enableComments ? 'checked' : '').'>
                            <label class="form-check-label fw-bold" for="enable_comments_toggle">
                                <i class="fa fa-comments me-2"></i>Enable Comments
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card bg-light p-3">
                        <div class="form-check form-switch">
                            <input type="hidden" name="enable_sharing" value="0">
                            <input class="form-check-input" type="checkbox" 
                                   name="enable_sharing" 
                                   id="enable_sharing_toggle"
                                   value="1" '.($enableSharing ? 'checked' : '').'>
                            <label class="form-check-label fw-bold" for="enable_sharing_toggle">
                                <i class="fa fa-share-alt me-2"></i>Enable Sharing
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            ';

            $tabs .= '</div>';
        }

        return $tabs;
    }, 120, 2);

    // Save custom fields when page is saved
    add_action(BASE_FILTER_AFTER_SAVE_FORM, function ($form) {
        $model = $form->getModel();
        $request = $form->getRequest();

        if ($model instanceof \Botble\Page\Models\Page) {
            // Map Settings
            if ($request->has('map_points')) {
                update_field('map_points', $request->input('map_points'), $model->id);
            }
            if ($request->has('map_center')) {
                update_field('map_center', $request->input('map_center'), $model->id);
            }
            if ($request->has('map_zoom')) {
                update_field('map_zoom', $request->input('map_zoom'), $model->id);
            }

            // Show/Hide Map
            if ($request->has('show_map')) {
                update_field('show_map', $request->input('show_map') == '1' ? true : false, $model->id);
            } else {
                update_field('show_map', false, $model->id);
            }

            // Working Hours & Contact Info
            if ($request->has('working_hours')) {
                $workingHours = $request->input('working_hours');

                // Process working hours to ensure proper boolean values
                foreach ($workingHours as $day => $hours) {
                    if (isset($hours['is_open'])) {
                        // Convert to boolean
                        $workingHours[$day]['is_open'] = ($hours['is_open'] == '1') ? true : false;
                    } else {
                        $workingHours[$day]['is_open'] = false;
                    }
                }

                update_field('working_hours', $workingHours, $model->id);
            }
            if ($request->has('contact_info')) {
                update_field('contact_info', $request->input('contact_info'), $model->id);
            }

            // Show/Hide Working Hours
            if ($request->has('show_working_hours')) {
                update_field('show_working_hours', $request->input('show_working_hours') == '1' ? true : false, $model->id);
            } else {
                update_field('show_working_hours', false, $model->id);
            }

            // Related Pages
            if ($request->has('related_pages')) {
                $relatedPages = array_filter($request->input('related_pages', [])); // Remove empty values
                update_field('related_pages', array_values($relatedPages), $model->id); // Reset array keys
            } else {
                // If no related pages submitted, clear the field
                update_field('related_pages', [], $model->id);
            }

            // Menu items
            if ($request->has('menu_items')) {
                $menuItemsRaw = $request->input('menu_items', []);
                $menuItems = [];

                foreach ($menuItemsRaw as $item) {
                    if (! is_array($item)) {
                        continue;
                    }

                    $name = trim($item['name'] ?? '');
                    $url = trim($item['url'] ?? '');

                    // Skip completely empty items
                    if ($name === '' && $url === '') {
                        continue;
                    }

                    $menuItems[] = [
                        'name' => $name,
                        'url' => $url,
                        'is_visible' => isset($item['is_visible']) && (string) $item['is_visible'] === '1',
                    ];
                }

                update_field('menu_items', $menuItems, $model->id);
            } else {
                // No items submitted -> clear saved menu items
                update_field('menu_items', [], $model->id);
            }

            // Show/Hide menu
            if ($request->has('show_menu')) {
                update_field('show_menu', $request->input('show_menu') == '1' ? true : false, $model->id);
            } else {
                update_field('show_menu', false, $model->id);
            }

            // PAGE HEADER TAB FIELDS
            // Header Type and related fields
            if ($request->has('header_type')) {
                update_field('header_type', $request->input('header_type'), $model->id);
            }

            if ($request->has('header_slider_images')) {
                $sliderImages = $request->input('header_slider_images');
                if (is_string($sliderImages)) {
                    $sliderImages = json_decode($sliderImages, true) ?: [];
                }
                update_field('header_slider_images', $sliderImages, $model->id);
            }

            if ($request->has('header_video_url')) {
                update_field('header_video_url', $request->input('header_video_url'), $model->id);
            }

            if ($request->has('header_video_thumbnail')) {
                update_field('header_video_thumbnail', $request->input('header_video_thumbnail'), $model->id);
            }

            if ($request->has('header_image')) {
                update_field('header_image', $request->input('header_image'), $model->id);
            }

            // Header Map Fields
            if ($request->has('header_map_center_latitude')) {
                update_field('header_map_center_latitude', $request->input('header_map_center_latitude'), $model->id);
            }

            if ($request->has('header_map_center_longitude')) {
                update_field('header_map_center_longitude', $request->input('header_map_center_longitude'), $model->id);
            }

            if ($request->has('header_map_zoom')) {
                update_field('header_map_zoom', $request->input('header_map_zoom'), $model->id);
            }

            if ($request->has('header_map_points')) {
                $headerMapPoints = $request->input('header_map_points', []);
                $processedPoints = [];

                foreach ($headerMapPoints as $point) {
                    if (is_array($point) && ! empty($point['title']) && ! empty($point['latitude']) && ! empty($point['longitude']) && ! empty($point['link_url'])) {
                        $processedPoints[] = [
                            'title' => $point['title'],
                            'description' => $point['description'] ?? '',
                            'latitude' => $point['latitude'],
                            'longitude' => $point['longitude'],
                            'link_url' => $point['link_url'],
                            'is_visible' => ($point['is_visible'] ?? 1) == 1 ? 1 : 0,
                        ];
                    }
                }

                update_field('header_map_points', $processedPoints, $model->id);
            } else {
                update_field('header_map_points', [], $model->id);
            }

            // PAGE SETTINGS TAB FIELDS
            if ($request->has('page_layout')) {
                update_field('page_layout', $request->input('page_layout'), $model->id);
            }

            if ($request->has('custom_css_class')) {
                update_field('custom_css_class', $request->input('custom_css_class'), $model->id);
            }

            if ($request->has('enable_comments')) {
                update_field('enable_comments', $request->input('enable_comments') == '1' ? true : false, $model->id);
            } else {
                update_field('enable_comments', false, $model->id);
            }

            if ($request->has('enable_sharing')) {
                update_field('enable_sharing', $request->input('enable_sharing') == '1' ? true : false, $model->id);
            } else {
                update_field('enable_sharing', false, $model->id);
            }
        }
    }, 120);

    // Image Sizes
    RvMedia::addSize('medium', 800, 800);
    RvMedia::addSize('large', 1200, 1200);

    // Theme Support
    ThemeSupport::registerSiteCopyright();
    ThemeSupport::registerSocialSharing();

    // Typography
    Theme::typography()
        ->registerFontFamilies([
            new TypographyItem('primary', __('Primary'), 'Inter'),
            new TypographyItem('heading', __('Heading'), 'Playfair Display'),
        ])
        ->registerFontSizes([
            new TypographyItem('h1', __('Heading 1'), 48),
            new TypographyItem('h2', __('Heading 2'), 40),
            new TypographyItem('h3', __('Heading 3'), 32),
            new TypographyItem('h4', __('Heading 4'), 24),
            new TypographyItem('h5', __('Heading 5'), 20),
            new TypographyItem('h6', __('Heading 6'), 18),
            new TypographyItem('body', __('Body'), 16),
        ]);
});

// Helper functions for custom fields
if (! function_exists('get_field')) {
    function get_field($key, $post_id = null)
    {
        if (! $post_id) {
            return null;
        }

        $metaValue = \Botble\Base\Models\MetaBox::where('reference_id', $post_id)
            ->where('reference_type', \Botble\Page\Models\Page::class)
            ->where('meta_key', $key)
            ->value('meta_value');

        // Try to decode JSON if it's an array
        if ($metaValue && (str_starts_with($metaValue, '[') || str_starts_with($metaValue, '{'))) {
            $decoded = json_decode($metaValue, true);

            return $decoded ?? $metaValue;
        }

        return $metaValue;
    }
}

if (! function_exists('update_field')) {
    function update_field($key, $value, $post_id)
    {
        if (! $post_id) {
            return false;
        }

        $serializedValue = is_array($value) ? json_encode($value) : $value;

        return \Botble\Base\Models\MetaBox::updateOrCreate(
            [
                'reference_id' => $post_id,
                'reference_type' => \Botble\Page\Models\Page::class,
                'meta_key' => $key,
            ],
            [
                'meta_value' => $serializedValue,
            ]
        );
    }
}

if (! function_exists('get_related_pages')) {
    function get_related_pages($page_id = null)
    {
        if (! $page_id) {
            return collect();
        }

        $relatedPageIds = get_field('related_pages', $page_id);

        if (empty($relatedPageIds) || ! is_array($relatedPageIds)) {
            return collect();
        }

        // 🔒 Security: تنظيف IDs قبل استخدامها في SQL
        $relatedPageIds = array_map('intval', array_filter($relatedPageIds));

        if (empty($relatedPageIds)) {
            return collect();
        }

        return \Botble\Page\Models\Page::query()
            ->whereIn('id', $relatedPageIds)
            ->where('status', 'published')
            ->orderByRaw('FIELD(id, '.implode(',', $relatedPageIds).')') // Maintain the selected order
            ->get();
    }
}
