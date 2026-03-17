<?php

namespace SharjahStore\Providers;

use Botble\Base\Facades\DashboardMenu;
use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\LanguageAdvanced\Supports\LanguageAdvancedManager;
use Botble\Slug\Facades\SlugHelper;
use Illuminate\Routing\Events\RouteMatched;
use SharjahStore\Models\Collection;
use SharjahStore\Models\Product;
use SharjahStore\Repositories\Eloquent\CollectionRepository;
use SharjahStore\Repositories\Eloquent\ProductRepository;
use SharjahStore\Repositories\Interfaces\CollectionInterface;
use SharjahStore\Repositories\Interfaces\ProductInterface;

class SharjahStoreServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        $this->app->bind(Collection::class, function () {
            return new Collection();
        });

        $this->app->bind(CollectionInterface::class, function () {
            return new CollectionRepository(new Collection());
        });

        $this->app->bind(Product::class, function () {
            return new Product();
        });

        $this->app->bind(ProductInterface::class, function () {
            return new ProductRepository(new Product());
        });
    }

    public function boot(): void
    {
        $this->setNamespace('plugins/sharjah-store')
            ->loadHelpers()
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->loadAndPublishTranslations()
            ->loadAndPublishViews()
            ->loadRoutes();

        $this->app['events']->listen(RouteMatched::class, function () {
            DashboardMenu::registerItem([
                'id'          => 'cms-plugins-sharjah-store',
                'priority'    => 6,
                'parent_id'   => null,
                'name'        => 'Store',
                'icon'        => 'fas fa-store',
                'url'         => '#',
                'permissions' => ['store.collections.index', 'store.products.index'],
            ])
            ->registerItem([
                'id'          => 'cms-plugins-sharjah-store-collections',
                'priority'    => 1,
                'parent_id'   => 'cms-plugins-sharjah-store',
                'name'        => 'plugins/sharjah-store::collections.name',
                'icon'        => 'fas fa-folder',
                'url'         => route('store.collections.index'),
                'permissions' => ['store.collections.index'],
            ])
            ->registerItem([
                'id'          => 'cms-plugins-sharjah-store-products',
                'priority'    => 2,
                'parent_id'   => 'cms-plugins-sharjah-store',
                'name'        => 'plugins/sharjah-store::products.name',
                'icon'        => 'fas fa-box',
                'url'         => route('store.products.index'),
                'permissions' => ['store.products.index'],
            ]);
        });

        if (defined('LANGUAGE_ADVANCED_MODULE_SCREEN_NAME')) {
            LanguageAdvancedManager::registerModule(Collection::class, [
                'name',
                'description',
            ]);

            LanguageAdvancedManager::registerModule(Product::class, [
                'name',
                'description',
                'content',
                'down_row',
            ]);
        }

        SlugHelper::registerModule(Collection::class, 'Store Collections');
        SlugHelper::setPrefix(Collection::class, 'store/collections');

        SlugHelper::registerModule(Product::class, 'Store Products');
        SlugHelper::setPrefix(Product::class, 'store/products');
    }
}
