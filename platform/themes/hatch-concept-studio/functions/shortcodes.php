<?php

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Forms\FieldOptions\MediaImageFieldOption;
use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\MediaImageField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Projects\Models\Project;
use Botble\Shortcode\Compilers\Shortcode as ShortcodeCompiler;
use Botble\Shortcode\Facades\Shortcode;
use Botble\Shortcode\Forms\ShortcodeForm;
use Botble\Theme\Facades\Theme;
use Botble\Theme\Supports\ThemeSupport;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Facades\Event;

Event::listen(RouteMatched::class, function (): void {
    ThemeSupport::registerGoogleMapsShortcode();
    ThemeSupport::registerYoutubeShortcode();

    Shortcode::register(
        'hero-horse',
        __('Hero section - Horse'),
        __('Display a hero section with horse image, heading and optional button'),
        function (ShortcodeCompiler $shortcode) {
            return Theme::partial('shortcodes.hero-horse', compact('shortcode'));
        }
    );

    Shortcode::setAdminConfig('hero-horse', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->add(
                'title',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Title'))
                    ->placeholder(__('This is Hatch'))
            )
            ->add(
                'subtitle',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Subtitle'))
                    ->placeholder(__('Creative studio in Dubai'))
            )
            ->add(
                'button_text',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Button text'))
                    ->placeholder(__('Explore projects'))
            )
            ->add(
                'button_url',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Button URL'))
                    ->placeholder('/projects')
            )
            ->add(
                'horse_image',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Horse image'))
                    ->helperText(__('Optional. If empty, default horse image from theme assets will be used.'))
            );
    });

    Shortcode::register(
        'video-section',
        __('Video section'),
        __('Display native HTML5 video with configurable options'),
        function (ShortcodeCompiler $shortcode) {
            return Theme::partial('shortcodes.video-section', compact('shortcode'));
        }
    );

    Shortcode::setAdminConfig('video-section', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->add(
                'video_url',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Video URL'))
                    ->placeholder(__('https://example.com/video.mp4'))
                    ->required()
            )
            ->add(
                'cover_image',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Cover image'))
                    ->helperText(__('Optional. Used as video poster image before playback.'))
            )
            ->add(
                'autoplay',
                SelectField::class,
                SelectFieldOption::make()
                    ->label(__('Auto play'))
                    ->choices([
                        '0' => __('No'),
                        '1' => __('Yes'),
                    ])
                    ->selected($attributes['autoplay'] ?? '0')
            )
            ->add(
                'mute',
                SelectField::class,
                SelectFieldOption::make()
                    ->label(__('Mute'))
                    ->choices([
                        '0' => __('No'),
                        '1' => __('Yes'),
                    ])
                    ->selected($attributes['mute'] ?? '1')
            )
            ->add(
                'loop',
                SelectField::class,
                SelectFieldOption::make()
                    ->label(__('Loop'))
                    ->choices([
                        '0' => __('No'),
                        '1' => __('Yes'),
                    ])
                    ->selected($attributes['loop'] ?? '0')
            );
    });

    Shortcode::register(
        'projects-carousel',
        __('Projects carousel'),
        __('Display projects as a carousel'),
        function (ShortcodeCompiler $shortcode) {
            $projects = Project::query()
                ->with(['category', 'tags'])
                ->where('status', BaseStatusEnum::PUBLISHED)
                ->latest('id')
                ->get();

            return Theme::partial('shortcodes.projects-carousel', compact('shortcode', 'projects'));
        }
    );

    Shortcode::setAdminConfig('projects-carousel', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->add(
                'autoplay',
                SelectField::class,
                SelectFieldOption::make()
                    ->label(__('Auto play'))
                    ->choices([
                        '0' => __('No'),
                        '1' => __('Yes'),
                    ])
                    ->selected($attributes['autoplay'] ?? '0')
            );
    });
});
