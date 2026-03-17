<?php

namespace Botble\SharjahEventCalendar\Http\Controllers;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Http\Controllers\BaseController;
use Botble\SharjahEventCalendar\Models\Event;
use Botble\SharjahEventCalendar\Models\EventCategory;
use Botble\SharjahEventCalendar\Models\EventLocation;
use Botble\SharjahEventCalendar\Models\EventTag;
use Botble\Theme\Facades\Theme;
use Illuminate\Http\Request;

class PublicEventController extends BaseController
{
    public function index(Request $request)
    {
        $query = Event::query()
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->with(['category', 'location', 'tags']);

        // Filter by location
        if ($request->filled('location')) {
            $query->where('event_location_id', $request->location);
        }

        // Filter by status (ongoing, upcoming, completed)
        if ($request->filled('event_status')) {
            // Use date-only comparisons so the filter matches based on current day
            $today = now()->format('Y-m-d');

            switch ($request->event_status) {
                case 'ongoing':
                    // event is ongoing if start_date <= today AND (end_date >= today OR end_date IS NULL)
                    $query->whereDate('start_date', '<=', $today)
                        ->where(function ($q) use ($today) {
                            $q->whereDate('end_date', '>=', $today)
                                ->orWhereNull('end_date');
                        });
                    break;
                case 'upcoming':
                    // upcoming if start_date > today
                    $query->whereDate('start_date', '>', $today);
                    break;
                case 'completed':
                    // completed if end_date < today (only if end_date is set)
                    $query->whereNotNull('end_date')
                        ->whereDate('end_date', '<', $today);
                    break;
            }
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('event_category_id', $request->category);
        }

        $events = $query->orderBy('start_date', 'desc')->paginate(12);

        // Get filter data
        $locations = EventLocation::query()
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->orderBy('name')
            ->get();

        $categories = EventCategory::query()
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->orderBy('name')
            ->get();

        return view('plugins.sharjah-event-calendar::public.index', compact('events', 'locations', 'categories'));
    }

    public function calendar(Request $request)
    {
        $events = Event::query()
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->with(['category', 'location'])
            ->orderBy('start_date', 'asc')
            ->get();

        return view('plugins.sharjah-event-calendar::public.calendar', compact('events'));
    }

    public function detail(string $slug)
    {
        $slugRecord = \Botble\Slug\Facades\SlugHelper::getSlug($slug, 'events');

        if (!$slugRecord) {
            abort(404);
        }

        $event = Event::query()
            ->where('id', $slugRecord->reference_id)
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->with(['category', 'location', 'tags'])
            ->first();

        if (!$event) {
            abort(404);
        }

        return view('plugins.sharjah-event-calendar::public.detail', compact('event'));
    }

    public function category(string $slug)
    {
        $slugModel = \Botble\Slug\Facades\SlugHelper::getSlug($slug, 'event-categories');

        if (!$slugModel) {
            abort(404);
        }

        $category = EventCategory::query()
            ->where('id', $slugModel->reference_id)
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->firstOrFail();

        $events = Event::query()
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->where('event_category_id', $category->id)
            ->with(['category', 'location', 'tags'])
            ->orderBy('start_date', 'desc')
            ->paginate(12);

        return view('plugins.sharjah-event-calendar::public.category', compact('category', 'events'));
    }

    public function tag(string $slug)
    {
        $slugModel = \Botble\Slug\Facades\SlugHelper::getSlug($slug, 'event-tags');

        if (!$slugModel) {
            abort(404);
        }

        $tag = EventTag::query()
            ->where('id', $slugModel->reference_id)
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->firstOrFail();

        $events = $tag->events()
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->with(['category', 'location', 'tags'])
            ->orderBy('start_date', 'desc')
            ->paginate(12);

        return view('plugins.sharjah-event-calendar::public.tag', compact('tag', 'events'));
    }

    public function location(string $slug)
    {
        $slugModel = \Botble\Slug\Facades\SlugHelper::getSlug($slug, 'event-locations');

        if (!$slugModel) {
            abort(404);
        }

        $location = EventLocation::query()
            ->where('id', $slugModel->reference_id)
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->firstOrFail();

        $events = Event::query()
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->where('event_location_id', $location->id)
            ->with(['category', 'location', 'tags'])
            ->orderBy('start_date', 'desc')
            ->paginate(12);

        return view('plugins.sharjah-event-calendar::public.location', compact('location', 'events'));
    }
}
