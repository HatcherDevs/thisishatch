<?php

namespace Botble\Projects\Providers;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Facades\DashboardMenu;
use Botble\Base\Forms\FieldOptions\MediaImageFieldOption;
use Botble\Base\Forms\FieldOptions\MediaImagesFieldOption;
use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\FieldOptions\TextareaFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\MediaImageField;
use Botble\Base\Forms\Fields\MediaImagesField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Supports\DashboardMenuItem;
use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Media\Facades\RvMedia;
use Botble\Page\Models\Page;
use Botble\Projects\Models\Project;
use Botble\SeoHelper\Facades\SeoHelper;
use Botble\Shortcode\Compilers\Shortcode as ShortcodeCompiler;
use Botble\Shortcode\Facades\Shortcode;
use Botble\Shortcode\Forms\ShortcodeForm;
use Botble\Slug\Facades\SlugHelper;
use Botble\Slug\Models\Slug;
use Botble\Theme\Facades\Theme;

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

        $this->registerShortcodes();

        if (class_exists(SeoHelper::class)) {
            SeoHelper::registerModule(Project::class);
        }

        if (class_exists(SlugHelper::class)) {
            SlugHelper::registerModule(
                Project::class,
                trans('plugins/projects::projects.name')
            );

            SlugHelper::setPrefix(Project::class, 'projects');

            SlugHelper::setColumnUsedForSlugGenerator(
                Project::class,
                'title'
            );
        }

        add_filter(
            BASE_FILTER_PUBLIC_SINGLE_DATA,
            [$this, 'handleSingleView'],
            1
        );

        DashboardMenu::default()->beforeRetrieving(
            function (): void {
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
            }
        );
    }

    protected function registerShortcodes(): void
    {
        Shortcode::register(
            'project-images',
            __('Project images'),
            __('Display project images with selected layout'),
            function (ShortcodeCompiler $shortcode) {
                return Theme::partial(
                    'shortcodes.project-images',
                    compact('shortcode')
                );
            }
        );

        Shortcode::setAdminConfig(
            'project-images',
            function (array $attributes) {
                return ShortcodeForm::createFromArray($attributes)
                    ->add(
                        'layout',
                        SelectField::class,
                        SelectFieldOption::make()
                            ->label(__('Images layout'))
                            ->choices([
                                'full-image' => __('Full image'),
                                'two-inline' => __('2 inline images'),
                                'two-vertical' => __('Up/down images'),
                                'three-inline' => __('3 inline images'),
                            ])
                            ->selected(
                                $attributes['layout'] ?? 'full-image'
                            )
                    )
                    ->add(
                        'images',
                        MediaImagesField::class,
                        MediaImagesFieldOption::make()
                            ->label(__('Images'))
                            ->helperText(
                                __(
                                    'Select images according to the selected layout.'
                                )
                            )
                            ->values(
                                $attributes['images'] ?? []
                            )
                    );
            }
        );

        Shortcode::register(
            'project-headline',
            __('Project headline'),
            __('Display project title and description'),
            function (ShortcodeCompiler $shortcode) {
                return Theme::partial(
                    'shortcodes.project-headline',
                    compact('shortcode')
                );
            }
        );

        Shortcode::setAdminConfig(
            'project-headline',
            function (array $attributes) {
                return ShortcodeForm::createFromArray($attributes)
                    ->add(
                        'title',
                        TextField::class,
                        TextFieldOption::make()
                            ->label(__('Title'))
                            ->placeholder(
                                __('Headline about the project')
                            )
                            ->required()
                    )
                    ->add(
                        'description',
                        TextareaField::class,
                        TextareaFieldOption::make()
                            ->label(__('Description'))
                            ->placeholder(
                                __('Enter project description')
                            )
                    );
            }
        );

        Shortcode::register(
            'project-video',
            __('Project video'),
            __('Display project video with cover image'),
            function (ShortcodeCompiler $shortcode) {
                return Theme::partial(
                    'shortcodes.project-video',
                    compact('shortcode')
                );
            }
        );

        Shortcode::setAdminConfig(
            'project-video',
            function (array $attributes) {
                return ShortcodeForm::createFromArray($attributes)
                    ->add(
                        'video_url',
                        TextField::class,
                        TextFieldOption::make()
                            ->label(__('Video URL'))
                            ->placeholder(
                                __('https://example.com/video.mp4')
                            )
                            ->required()
                    )
                    ->add(
                        'cover_image',
                        MediaImageField::class,
                        MediaImageFieldOption::make()
                            ->label(__('Cover image'))
                            ->helperText(
                                __(
                                    'Image displayed before video playback.'
                                )
                            )
                    );
            }
        );
    }

    public function handleSingleView(Slug|array $slug): Slug|array
    {
        if (
            ! $slug instanceof Slug
            || $slug->reference_type !== Project::class
        ) {
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

        $seoMeta = get_meta_data(
            $project,
            'seo_meta',
            true
        );

        $seoDescription = is_array($seoMeta)
            ? trim(
                (string) (
                    $seoMeta['seo_description'] ?? ''
                )
            )
            : '';

        SeoHelper::setTitle($project->title)
            ->setDescription($seoDescription);

        if ($project->image) {
            SeoHelper::openGraph()->setImage(
                RvMedia::getImageUrl($project->image)
            );
        }

        $relatedProjects = Project::query()
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->where('id', '!=', $project->id)
            ->latest('id')
            ->limit(8)
            ->get();

        $nextProject = Project::query()
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->where('id', '>', $project->id)
            ->orderBy('id')
            ->first();

        $previousProject = Project::query()
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->where('id', '<', $project->id)
            ->orderByDesc('id')
            ->first();

        $projectsPageId = Slug::query()
            ->where('reference_type', Page::class)
            ->where('key', 'projects')
            ->value('reference_id');

        $projectsPageCover = null;

        if ($projectsPageId) {
            $projectsPageCover = Page::query()
                ->wherePublished()
                ->where('id', $projectsPageId)
                ->value('image');
        }

        Theme::layout('project');

        return [
            'view' => 'project',
            'default_view' => 'plugins/projects::themes.project',
            'data' => compact(
                'project',
                'relatedProjects',
                'nextProject',
                'previousProject',
                'projectsPageCover'
            ),
            'slug' => $project->slug,
        ];
    }
}