<?php

use Botble\Theme\Facades\ThemeOption;
use Botble\Theme\ThemeOption\ThemeOptionSection;

app()->booted(function () {
    ThemeOption::setSection(
        ThemeOptionSection::make('opt-text-subsection-preloader')
            ->title(__('Preloader'))
            ->icon('ti ti-loader-2')
            ->priority(5)
    );

    ThemeOption::setSection(
        ThemeOptionSection::make('opt-text-subsection-projects')
            ->title(__('Projects'))
            ->icon('ti ti-briefcase')
            ->priority(30)
    );

    ThemeOption::setSection(
        ThemeOptionSection::make('opt-text-subsection-header')
            ->title(__('Header'))
            ->icon('ti ti-layout-navbar')
            ->priority(20)
    );

    theme_option()
        ->setField([
            'id' => 'primary_color',
            'section_id' => 'opt-text-subsection-general',
            'type' => 'customColor',
            'label' => __('Primary color'),
            'attributes' => [
                'name' => 'primary_color',
                'value' => '#ff2b4a',
            ],
        ])
        ->setField([
            'id' => 'preloader_enabled',
            'section_id' => 'opt-text-subsection-preloader',
            'type' => 'customSelect',
            'label' => __('Enable Preloader?'),
            'attributes' => [
                'name' => 'preloader_enabled',
                'list' => [
                    'yes' => __('Yes'),
                    'no' => __('No'),
                ],
                'value' => 'no',
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id' => 'preloader_style',
            'section_id' => 'opt-text-subsection-preloader',
            'type' => 'customSelect',
            'label' => __('Preloader style'),
            'attributes' => [
                'name' => 'preloader_style',
                'list' => [
                    'ring' => __('Ring'),
                    'dots' => __('Dots'),
                    'pulse' => __('Pulse'),
                ],
                'value' => 'ring',
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id' => 'preloader_background_color',
            'section_id' => 'opt-text-subsection-preloader',
            'type' => 'customColor',
            'label' => __('Preloader background color'),
            'attributes' => [
                'name' => 'preloader_background_color',
                'value' => '#ffffff',
            ],
        ])
        ->setField([
            'id' => 'preloader_spinner_color',
            'section_id' => 'opt-text-subsection-preloader',
            'type' => 'customColor',
            'label' => __('Preloader spinner color'),
            'attributes' => [
                'name' => 'preloader_spinner_color',
                'value' => '#ff2b4a',
            ],
        ])
        ->setField([
            'id' => 'preloader_behavior',
            'section_id' => 'opt-text-subsection-preloader',
            'type' => 'customSelect',
            'label' => __('Preloader behavior'),
            'attributes' => [
                'name' => 'preloader_behavior',
                'list' => [
                    'assets_loaded' => __('Hide when page and assets are loaded'),
                    'fixed_time' => __('Hide after fixed time'),
                ],
                'value' => 'assets_loaded',
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id' => 'preloader_display_mode',
            'section_id' => 'opt-text-subsection-preloader',
            'type' => 'customSelect',
            'label' => __('Preloader display mode'),
            'attributes' => [
                'name' => 'preloader_display_mode',
                'list' => [
                    'every_page' => __('Show on every page load'),
                    'once_per_session' => __('Show once per browser session'),
                ],
                'value' => 'every_page',
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id' => 'preloader_fixed_time_ms',
            'section_id' => 'opt-text-subsection-preloader',
            'type' => 'text',
            'label' => __('Preloader fixed time (milliseconds)'),
            'attributes' => [
                'name' => 'preloader_fixed_time_ms',
                'value' => '1500',
                'options' => [
                    'class' => 'form-control',
                    'placeholder' => '1500',
                ],
            ],
        ])
        ->setField([
            'id' => 'header_menu_icon',
            'section_id' => 'opt-text-subsection-header',
            'type' => 'mediaImage',
            'label' => __('Menu icon'),
            'attributes' => [
                'name' => 'header_menu_icon',
            ],
        ])
        ->setField([
            'id' => 'header_logo',
            'section_id' => 'opt-text-subsection-header',
            'type' => 'mediaImage',
            'label' => __('Menu logo'),
            'attributes' => [
                'name' => 'header_logo',
            ],
        ])
        ->setField([
            'id' => 'header_menu_title',
            'section_id' => 'opt-text-subsection-header',
            'type' => 'text',
            'label' => __('Menu title'),
            'attributes' => [
                'name' => 'header_menu_title',
                'value' => 'This is Hatch',
            ],
        ])
        ->setField([
            'id' => 'website_favicon',
            'section_id' => 'opt-text-subsection-header',
            'type' => 'mediaImage',
            'label' => __('Favicon'),
            'attributes' => [
                'name' => 'website_favicon',
            ],
        ])
        ->setField([
            'id' => 'website_apple_icon',
            'section_id' => 'opt-text-subsection-header',
            'type' => 'mediaImage',
            'label' => __('Apple touch icon'),
            'attributes' => [
                'name' => 'website_apple_icon',
            ],
        ])
        ->setField([
            'id' => 'projects_intro_text',
            'section_id' => 'opt-text-subsection-projects',
            'type' => 'editor',
            'label' => __('Projects intro text'),
            'attributes' => [
                'name' => 'projects_intro_text',
                'value' => 'Our day begins and ends with doing what we love - grabbing design by the horns and beating it black and blue until it looks beautiful. You will find nothing but unadulterated, kicking, living design here.',
                'attributes' => [
                    'with-short-code' => true,
                ],
            ],
        ]);

    add_action(RENDERING_THEME_OPTIONS_PAGE, function (): void {
        if (! request()->routeIs('theme.options')) {
            return;
        }

        echo <<<'HTML'
<script>
document.addEventListener('DOMContentLoaded', function () {
    var enabledField = document.querySelector('[name="preloader_enabled"]');
    var behaviorField = document.querySelector('[name="preloader_behavior"]');

    if (!enabledField) {
        return;
    }

    var dependentFields = [
        'preloader_style',
        'preloader_background_color',
        'preloader_spinner_color',
        'preloader_behavior',
        'preloader_display_mode',
        'preloader_fixed_time_ms'
    ];

    var findFieldWrapper = function (fieldName) {
        var field = document.querySelector('[name="' + fieldName + '"]');

        if (!field) {
            return null;
        }

        return field.closest('.mb-3') || field.closest('.form-group') || field.parentElement;
    };

    var togglePreloaderFields = function () {
        var isEnabled = enabledField.value === 'yes';

        dependentFields.forEach(function (fieldName) {
            var wrapper = findFieldWrapper(fieldName);

            if (!wrapper) {
                return;
            }

            wrapper.style.display = isEnabled ? '' : 'none';
        });

        var fixedTimeWrapper = findFieldWrapper('preloader_fixed_time_ms');

        if (!fixedTimeWrapper) {
            return;
        }

        var isFixedTime = behaviorField && behaviorField.value === 'fixed_time';
        fixedTimeWrapper.style.display = isEnabled && isFixedTime ? '' : 'none';
    };

    enabledField.addEventListener('change', togglePreloaderFields);
    if (behaviorField) {
        behaviorField.addEventListener('change', togglePreloaderFields);
    }
    togglePreloaderFields();
});
</script>
HTML;
    }, 999);
});
