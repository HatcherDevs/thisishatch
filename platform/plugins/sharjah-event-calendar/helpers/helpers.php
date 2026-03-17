<?php

use Botble\SharjahEventCalendar\Models\Event;

if (!function_exists('get_upcoming_events')) {
    /**
     * Get upcoming events
     */
    function get_upcoming_events(int $limit = 10): \Illuminate\Database\Eloquent\Collection
    {
        return Event::query()
            ->where('status', 'published')
            ->where('start_date', '>=', now())
            ->orderBy('start_date', 'asc')
            ->limit($limit)
            ->with(['category', 'location'])
            ->get();
    }
}

if (!function_exists('get_featured_events')) {
    /**
     * Get featured events
     */
    function get_featured_events(int $limit = 6): \Illuminate\Database\Eloquent\Collection
    {
        return Event::query()
            ->where('status', 'published')
            ->where('is_featured', true)
            ->orderBy('start_date', 'desc')
            ->limit($limit)
            ->with(['category', 'location'])
            ->get();
    }
}

if (!function_exists('get_events_by_category')) {
    /**
     * Get events by category
     */
    function get_events_by_category(int $categoryId, int $limit = 10): \Illuminate\Database\Eloquent\Collection
    {
        return Event::query()
            ->where('status', 'published')
            ->where('event_category_id', $categoryId)
            ->orderBy('start_date', 'desc')
            ->limit($limit)
            ->with(['category', 'location'])
            ->get();
    }
}

if (!function_exists('get_events_by_location')) {
    /**
     * Get events by location
     */
    function get_events_by_location(int $locationId, int $limit = 10): \Illuminate\Database\Eloquent\Collection
    {
        return Event::query()
            ->where('status', 'published')
            ->where('event_location_id', $locationId)
            ->orderBy('start_date', 'desc')
            ->limit($limit)
            ->with(['category', 'location'])
            ->get();
    }
}
