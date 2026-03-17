<?php

namespace Botble\Research\Providers;

use Botble\Base\Facades\DashboardMenu;
use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Research\Models\Location;
use Botble\Research\Models\Timeline;

class ResearchServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot(): void
    {
        $this
            ->setNamespace('plugins/research')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadAndPublishTranslations()
            ->loadRoutes()
            ->loadAndPublishViews()
            ->loadMigrations();

        // Register multi-language support
        if (defined('LANGUAGE_ADVANCED_MODULE_SCREEN_NAME')) {
            \Botble\LanguageAdvanced\Supports\LanguageAdvancedManager::registerModule(Timeline::class, [
                'name',
                'subtitle',
                'description',
            ]);

            \Botble\LanguageAdvanced\Supports\LanguageAdvancedManager::registerModule(Location::class, [
                'title',
                'subtitle',
                'description',
                'typology',
                'zone',
                'plot_area',
                'built_up_area',
            ]);
        }

        // Register dashboard menu
        DashboardMenu::default()->beforeRetrieving(function () {
            DashboardMenu::make()
                ->registerItem([
                    'id' => 'cms-plugins-research',
                    'priority' => 6,
                    'parent_id' => null,
                    'name' => 'Research',
                    'icon' => 'fa fa-history',
                    'url' => route('research.timelines.index'),
                    'permissions' => ['research.timelines.index'],
                ])
                ->registerItem([
                    'id' => 'cms-plugins-research-timelines',
                    'priority' => 1,
                    'parent_id' => 'cms-plugins-research',
                    'name' => 'plugins/research::timelines.name',
                    'icon' => null,
                    'url' => route('research.timelines.index'),
                    'permissions' => ['research.timelines.index'],
                ])
                ->registerItem([
                    'id' => 'cms-plugins-research-locations',
                    'priority' => 2,
                    'parent_id' => 'cms-plugins-research',
                    'name' => 'plugins/research::locations.name',
                    'icon' => null,
                    'url' => route('research.locations.index'),
                    'permissions' => ['research.locations.index'],
                ]);
        });
    }
}
