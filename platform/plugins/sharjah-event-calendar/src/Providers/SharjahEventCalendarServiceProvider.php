<?php

namespace Botble\SharjahEventCalendar\Providers;

use Botble\Base\Facades\DashboardMenu;
use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\SharjahEventCalendar\Models\Event;
use Botble\SharjahEventCalendar\Models\EventCategory;
use Botble\SharjahEventCalendar\Models\EventLocation;
use Botble\SharjahEventCalendar\Models\EventTag;

class SharjahEventCalendarServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        $this->app->make('files')->requireOnce(__DIR__ . '/../../helpers/constants.php');
    }

    public function boot(): void
    {
        $this
            ->setNamespace('plugins/sharjah-event-calendar')
            ->loadHelpers()
            ->loadAndPublishConfigurations(['permissions'])
            ->loadAndPublishTranslations()
            ->loadRoutes()
            ->loadAndPublishViews()
            ->loadMigrations();

        // Register view paths for the plugin
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'plugins.sharjah-event-calendar');

        // Register slug support
        \Botble\Slug\Facades\SlugHelper::registerModule(Event::class, 'Events');
        \Botble\Slug\Facades\SlugHelper::setPrefix(Event::class, 'events');

        // Register multi-language support
        if (defined('LANGUAGE_ADVANCED_MODULE_SCREEN_NAME')) {
            \Botble\LanguageAdvanced\Supports\LanguageAdvancedManager::registerModule(Event::class, [
                'name',
                'description',
                'content',
            ]);

            \Botble\LanguageAdvanced\Supports\LanguageAdvancedManager::registerModule(EventCategory::class, [
                'name',
                'description',
            ]);

            \Botble\LanguageAdvanced\Supports\LanguageAdvancedManager::registerModule(EventTag::class, [
                'name',
                'description',
            ]);

            \Botble\LanguageAdvanced\Supports\LanguageAdvancedManager::registerModule(EventLocation::class, [
                'name',
                'description',
                'address',
                'city',
            ]);
        }

        // Register dashboard menu
        DashboardMenu::default()->beforeRetrieving(function () {
            DashboardMenu::make()
                ->registerItem([
                    'id' => 'cms-plugins-events',
                    'priority' => 5,
                    'parent_id' => null,
                    'name' => 'plugins/sharjah-event-calendar::events.name',
                    'icon' => 'fa fa-calendar',
                    'url' => route('events.index'),
                    'permissions' => ['events.index'],
                ])
                ->registerItem([
                    'id' => 'cms-plugins-events-all',
                    'priority' => 1,
                    'parent_id' => 'cms-plugins-events',
                    'name' => 'plugins/sharjah-event-calendar::events.all_events',
                    'icon' => null,
                    'url' => route('events.index'),
                    'permissions' => ['events.index'],
                ])
                ->registerItem([
                    'id' => 'cms-plugins-events-categories',
                    'priority' => 2,
                    'parent_id' => 'cms-plugins-events',
                    'name' => 'plugins/sharjah-event-calendar::categories.name',
                    'icon' => null,
                    'url' => route('events.categories.index'),
                    'permissions' => ['events.categories.index'],
                ])
                ->registerItem([
                    'id' => 'cms-plugins-events-tags',
                    'priority' => 3,
                    'parent_id' => 'cms-plugins-events',
                    'name' => 'plugins/sharjah-event-calendar::tags.name',
                    'icon' => null,
                    'url' => route('events.tags.index'),
                    'permissions' => ['events.tags.index'],
                ])
                ->registerItem([
                    'id' => 'cms-plugins-events-locations',
                    'priority' => 4,
                    'parent_id' => 'cms-plugins-events',
                    'name' => 'plugins/sharjah-event-calendar::locations.name',
                    'icon' => null,
                    'url' => route('events.locations.index'),
                    'permissions' => ['events.locations.index'],
                ]);
        });
    }
}
