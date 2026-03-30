<?php

namespace Botble\Projects\Providers;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Facades\DashboardMenu;
use Botble\Base\Supports\DashboardMenuItem;
use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Media\Facades\RvMedia;
use Botble\Projects\Models\Project;
use Botble\SeoHelper\Facades\SeoHelper;
use Botble\Slug\Facades\SlugHelper;
use Botble\Slug\Models\Slug;
use Illuminate\Support\Str;

class ProjectsServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot(): void
    {
        $this
            ->setNamespace('plugins/projects')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadRoutes()
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadMigrations();

        if (class_exists(SeoHelper::class)) {
            SeoHelper::registerModule(Project::class);
        }

        if (class_exists(SlugHelper::class)) {
            SlugHelper::registerModule(Project::class, trans('plugins/projects::projects.name'));
            SlugHelper::setPrefix(Project::class, 'projects');
            SlugHelper::setColumnUsedForSlugGenerator(Project::class, 'title');
        }

        add_filter(BASE_FILTER_PUBLIC_SINGLE_DATA, [$this, 'handleSingleView'], 1);

        DashboardMenu::default()->beforeRetrieving(function (): void {
            DashboardMenu::make()
                ->registerItem(
                    DashboardMenuItem::make()
                        ->id('cms-plugins-projects')
                        ->priority(150)
                        ->name('plugins/projects::projects.name')
                        ->icon('ti ti-briefcase')
                        ->route('projects.index')
                )
                ->registerItem(
                    DashboardMenuItem::make()
                        ->id('cms-plugins-projects-items')
                        ->parentId('cms-plugins-projects')
                        ->priority(1)
                        ->name('plugins/projects::projects.name')
                        ->icon('ti ti-list')
                        ->route('projects.index')
                        ->permissions(['projects.index'])
                )
                ->registerItem(
                    DashboardMenuItem::make()
                        ->id('cms-plugins-projects-categories')
                        ->parentId('cms-plugins-projects')
                        ->priority(2)
                        ->name('plugins/projects::projects.categories')
                        ->icon('ti ti-category')
                        ->route('projects.categories.index')
                        ->permissions(['projects.categories.index'])
                )
                ->registerItem(
                    DashboardMenuItem::make()
                        ->id('cms-plugins-projects-tags')
                        ->parentId('cms-plugins-projects')
                        ->priority(3)
                        ->name('plugins/projects::projects.tags')
                        ->icon('ti ti-tags')
                        ->route('projects.tags.index')
                        ->permissions(['projects.tags.index'])
                );
        });
    }

    public function handleSingleView(Slug|array $slug): Slug|array
    {
        if (! $slug instanceof Slug || $slug->reference_type !== Project::class) {
            return $slug;
        }

        $project = Project::query()
            ->with(['category', 'tags'])
            ->where('id', $slug->reference_id)
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->first();

        if (! $project) {
            return $slug;
        }

        $description = Str::limit(strip_tags((string) ($project->description ?: $project->content)), 160);

        SeoHelper::setTitle($project->title)->setDescription($description);

        if ($project->image) {
            SeoHelper::openGraph()->setImage(RvMedia::getImageUrl($project->image));
        }

        $relatedProjects = Project::query()
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->where('id', '!=', $project->id)
            ->latest('id')
            ->limit(8)
            ->get();

        return [
            'view' => 'project',
            'default_view' => 'plugins/projects::themes.project',
            'data' => compact('project', 'relatedProjects'),
            'slug' => $project->slug,
        ];
    }
}
