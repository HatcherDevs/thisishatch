<?php

namespace SharjahOpportunities\Providers;

use Botble\Base\Facades\DashboardMenu;
use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\LanguageAdvanced\Supports\LanguageAdvancedManager;
use Botble\Slug\Facades\SlugHelper;
use Illuminate\Routing\Events\RouteMatched;
use SharjahOpportunities\Models\Opportunity;
use SharjahOpportunities\Repositories\Eloquent\OpportunityRepository;
use SharjahOpportunities\Repositories\Interfaces\OpportunityInterface;
use Botble\Shortcode\Facades\Shortcode as ShortcodeFacade;
use Botble\Shortcode\Compilers\Shortcode;
use Botble\Shortcode\Forms\ShortcodeForm;

class SharjahOpportunitiesServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        $this->app->bind(Opportunity::class, function () {
            return new Opportunity();
        });

        $this->app->bind(OpportunityInterface::class, function () {
            return new OpportunityRepository(new Opportunity());
        });
    }

    public function boot(): void
    {
        $this->setNamespace('plugins/sharjah-opportunities')
            ->loadHelpers()
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->loadAndPublishTranslations()
            ->loadAndPublishViews()
            ->loadRoutes();

        $this->app['events']->listen(RouteMatched::class, function () {
            DashboardMenu::registerItem([
                'id'          => 'cms-plugins-sharjah-opportunities',
                'priority'    => 5,
                'parent_id'   => null,
                'name'        => 'plugins/sharjah-opportunities::opportunities.name',
                'icon'        => 'fas fa-briefcase',
                'url'         => route('opportunities.index'),
                'permissions' => ['opportunities.index'],
            ]);
        });

        if (defined('LANGUAGE_ADVANCED_MODULE_SCREEN_NAME')) {
            LanguageAdvancedManager::registerModule(Opportunity::class, [
                'name',
                'description',
                'content',
            ]);
        }

        SlugHelper::registerModule(Opportunity::class, 'Opportunities');
        SlugHelper::setPrefix(Opportunity::class, 'opportunities');

        if (class_exists(ShortcodeFacade::class)) {
            ShortcodeFacade::register(
                'opportunities',
                trans('plugins/sharjah-opportunities::opportunities.shortcode_name'),
                trans('plugins/sharjah-opportunities::opportunities.shortcode_description'),
                [$this, 'renderOpportunitiesShortcode']
            );

            ShortcodeFacade::setAdminConfig('opportunities', function (array $attributes): ShortcodeForm {
                return ShortcodeForm::createFromArray($attributes)
                    ->withLazyLoading()
                    ->withHtmlAttributes();
            });
        }
    }

    public function renderOpportunitiesShortcode(Shortcode $shortcode): string
    {
        $attributes = $shortcode->toArray();
        $limit = isset($attributes['limit']) ? (int)$attributes['limit'] : 5;
        $view = $attributes['view'] ?? 'plugins/sharjah-opportunities::shortcodes.opportunities';

        $opportunities = Opportunity::where('status', \Botble\Base\Enums\BaseStatusEnum::PUBLISHED)
            ->limit($limit)
            ->get();

        if (view()->exists($view)) {
            return view($view, compact('opportunities', 'shortcode'))->render();
        }

        $html = '<div class="opportunities-shortcode">';
        foreach ($opportunities as $opportunity) {
            $html .= '<div class="opportunity-item">';
            $html .= '<a href="' . route('opportunity.single', $opportunity->slug) . '">' . e($opportunity->name) . '</a>';
            $html .= '</div>';
        }
        $html .= '</div>';

        return $html;
    }
}
