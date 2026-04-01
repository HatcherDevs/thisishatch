<?php

use Botble\Theme\Facades\ThemeOption;
use Botble\Theme\ThemeOption\ThemeOptionSection;

app()->booted(function () {
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
});
