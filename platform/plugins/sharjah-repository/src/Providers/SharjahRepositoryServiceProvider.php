<?php

namespace ArchiElite\SharjahRepository\Providers;

use ArchiElite\SharjahRepository\Models\RepositoryCategory;
use ArchiElite\SharjahRepository\Models\RepositoryItem;
use Botble\Base\Facades\DashboardMenu;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\LanguageAdvanced\Supports\LanguageAdvancedManager;
use Botble\Slug\Facades\SlugHelper;
use Illuminate\Support\ServiceProvider;

class SharjahRepositoryServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot(): void
    {
        $this->setNamespace('plugins/sharjah-repository')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->loadAndPublishTranslations()
            ->loadRoutes();

        DashboardMenu::beforeRetrieving(function (): void {
            DashboardMenu::make()
                ->registerItem([
                    'id' => 'cms-plugins-sharjah-repository',
                    'priority' => 5,
                    'parent_id' => null,
                    'name' => 'plugins/sharjah-repository::repository.name',
                    'icon' => 'ti ti-database',
                    'url' => route('repository-items.index'),
                    'permissions' => ['repository-items.index'],
                ])
                ->registerItem([
                    'id' => 'cms-plugins-repository-items',
                    'priority' => 1,
                    'parent_id' => 'cms-plugins-sharjah-repository',
                    'name' => 'plugins/sharjah-repository::repository.repositories',
                    'url' => route('repository-items.index'),
                    'permissions' => ['repository-items.index'],
                ])
                ->registerItem([
                    'id' => 'cms-plugins-repository-categories',
                    'priority' => 2,
                    'parent_id' => 'cms-plugins-sharjah-repository',
                    'name' => 'plugins/sharjah-repository::repository.categories',
                    'url' => route('repository-categories.index'),
                    'permissions' => ['repository-categories.index'],
                ]);
        });

        SlugHelper::registering(function (): void {
            SlugHelper::registerModule(RepositoryItem::class, fn() => trans('plugins/sharjah-repository::repository.repositories'));
            SlugHelper::setPrefix(RepositoryItem::class, 'repositories', true);
        });

        if (defined('LANGUAGE_MODULE_SCREEN_NAME') && defined('LANGUAGE_ADVANCED_MODULE_SCREEN_NAME')) {
            LanguageAdvancedManager::registerModule(RepositoryCategory::class, [
                'name',
            ]);

            LanguageAdvancedManager::registerModule(RepositoryItem::class, [
                'title',
                'content',
            ]);
        }
    }
}
