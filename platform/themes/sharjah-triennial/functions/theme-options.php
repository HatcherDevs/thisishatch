<?php

use Botble\Theme\Events\RenderingThemeOptionSettings;
use Botble\Theme\ThemeOption\Fields\ColorField;
use Botble\Theme\ThemeOption\Fields\MediaImageField;
use Botble\Theme\ThemeOption\Fields\RepeaterField;
use Botble\Theme\ThemeOption\Fields\TextField;
use Botble\Theme\ThemeOption\Fields\ToggleField;
use Botble\Theme\ThemeOption\ThemeOptionSection;

app('events')->listen(RenderingThemeOptionSettings::class, function (): void {
    // General Settings
    \Botble\Theme\Facades\ThemeOption::setSection(
        ThemeOptionSection::make('opt-text-subsection-general')
            ->title(__('General'))
            ->icon('ti ti-settings')
            ->fields([
                ColorField::make()
                    ->name('primary_color')
                    ->label(__('Primary Color'))
                    ->defaultValue('#667eea'),
                ColorField::make()
                    ->name('secondary_color')
                    ->label(__('Secondary Color'))
                    ->defaultValue('#764ba2'),
                MediaImageField::make()
                    ->name('site_logo')
                    ->label(__('Logo'))
                    ->helperText(__('Upload your site logo')),
                MediaImageField::make()
                    ->name('site_logo_white')
                    ->label(__('Logo (White)'))->helperText(__('Logo for dark backgrounds')),
                MediaImageField::make()
                    ->name('site_favicon')
                    ->label(__('Favicon')),
            ])
    );

    // Contact Information
    \Botble\Theme\Facades\ThemeOption::setSection(
        ThemeOptionSection::make('opt-text-subsection-contact')
            ->title(__('Contact Information'))
            ->icon('ti ti-address-book')
            ->fields([
                TextField::make()
                    ->name('site_phone')
                    ->label(__('Phone Number'))
                    ->placeholder('+971 XX XXX XXXX'),
                TextField::make()
                    ->name('site_email')
                    ->label(__('Email Address'))
                    ->placeholder('info@example.com'),
                TextField::make()
                    ->name('site_address')
                    ->label(__('Address'))
                    ->placeholder('Sharjah, UAE'),
            ])
    );

    // Social Links
    \Botble\Theme\Facades\ThemeOption::setSection(
        ThemeOptionSection::make('opt-text-subsection-social')
            ->title(__('Social Links'))
            ->icon('ti ti-share')
            ->fields([
                TextField::make()
                    ->name('social_facebook')
                    ->label(__('Facebook'))
                    ->placeholder('https://facebook.com/'),
                TextField::make()
                    ->name('social_twitter')
                    ->label(__('Twitter / X'))
                    ->placeholder('https://twitter.com/'),
                TextField::make()
                    ->name('social_instagram')
                    ->label(__('Instagram'))
                    ->placeholder('https://instagram.com/'),
                TextField::make()
                    ->name('social_linkedin')
                    ->label(__('LinkedIn'))
                    ->placeholder('https://linkedin.com/'),
                TextField::make()
                    ->name('social_youtube')
                    ->label(__('YouTube'))
                    ->placeholder('https://youtube.com/'),
            ])
    );

    // Statistics
    \Botble\Theme\Facades\ThemeOption::setSection(
        ThemeOptionSection::make('opt-text-subsection-stats')
            ->title(__('Statistics'))
            ->icon('ti ti-chart-bar')
            ->fields([
                TextField::make()
                    ->name('stat_projects')
                    ->label(__('Total Projects'))
                    ->defaultValue('150+'),
                TextField::make()
                    ->name('stat_architects')
                    ->label(__('Total Architects'))
                    ->defaultValue('200+'),
                TextField::make()
                    ->name('stat_countries')
                    ->label(__('Countries'))
                    ->defaultValue('45+'),
                TextField::make()
                    ->name('stat_visitors')
                    ->label(__('Total Visitors'))
                    ->defaultValue('50K+'),
            ])
    );

    // Header Settings
    \Botble\Theme\Facades\ThemeOption::setSection(
        ThemeOptionSection::make('opt-text-subsection-header')
            ->title(__('Header'))
            ->icon('ti ti-layout-navbar')
            ->fields([
                ToggleField::make()
                    ->name('header_sticky_enabled')
                    ->label(__('Enable Sticky Header'))
                    ->defaultValue(true),
                ColorField::make()
                    ->name('header_background_color')
                    ->label(__('Header Background Color'))
                    ->defaultValue('#ffffff'),
                ColorField::make()
                    ->name('header_text_color')
                    ->label(__('Header Text Color'))
                    ->defaultValue('#1a1a1a'),
            ])
    );

    // Footer Settings
    \Botble\Theme\Facades\ThemeOption::setSection(
        ThemeOptionSection::make('opt-text-subsection-footer')
            ->title(__('Footer'))
            ->icon('ti ti-layout-bottombar')
            ->fields([
                TextField::make()
                    ->name('footer_description')
                    ->label(__('Footer Description'))
                    ->defaultValue('Sharjah Architecture Triennial - A cultural platform celebrating architectural innovation and heritage.'),
                ColorField::make()
                    ->name('footer_background_color')
                    ->label(__('Footer Background Color'))
                    ->defaultValue('#1a1a1a'),
                MediaImageField::make()
                    ->name('footer_logo')
                    ->label(__('Footer Logo'))
                    ->helperText(__('Logo for footer (optional)')),
            ])
    );

    // Map Header Template Settings
    \Botble\Theme\Facades\ThemeOption::setSection(
        ThemeOptionSection::make('opt-text-subsection-map-header')
            ->title(__('Map Header Settings'))
            ->icon('ti ti-map')
            ->description(__('Configure map points for Map Header template pages'))
            ->fields([
                RepeaterField::make()
                    ->name('map_points')
                    ->label(__('Map Points'))
                    ->helperText(__('Add custom points to display on maps when using Map Header template'))
                    ->fields([
                        TextField::make()
                            ->name('title')
                            ->label(__('Point Title'))
                            ->placeholder(__('Enter point title')),
                        TextField::make()
                            ->name('description')
                            ->label(__('Description'))
                            ->placeholder(__('Brief description of this location')),
                        TextField::make()
                            ->name('latitude')
                            ->label(__('Latitude'))
                            ->placeholder('25.3463')
                            ->helperText(__('Example: 25.3463')),
                        TextField::make()
                            ->name('longitude')
                            ->label(__('Longitude'))
                            ->placeholder('55.4209')
                            ->helperText(__('Example: 55.4209')),
                        TextField::make()
                            ->name('link_url')
                            ->label(__('Link URL'))
                            ->placeholder(__('https://example.com or /page-slug'))
                            ->helperText(__('URL to open when point is clicked')),
                        ToggleField::make()
                            ->name('is_visible')
                            ->label(__('Show Point'))
                            ->defaultValue(true)
                            ->helperText(__('Toggle to show/hide this point on the map')),
                        MediaImageField::make()
                            ->name('icon_image')
                            ->label(__('Custom Icon (Optional)'))
                            ->helperText(__('Upload custom marker icon for this point')),
                    ]),
                TextField::make()
                    ->name('default_map_center_lat')
                    ->label(__('Default Map Center - Latitude'))
                    ->defaultValue('25.3463')
                    ->helperText(__('Default center latitude for maps')),
                TextField::make()
                    ->name('default_map_center_lng')
                    ->label(__('Default Map Center - Longitude'))
                    ->defaultValue('55.4209')
                    ->helperText(__('Default center longitude for maps')),
                TextField::make()
                    ->name('default_map_zoom')
                    ->label(__('Default Map Zoom Level'))
                    ->placeholder('12')
                    ->helperText(__('Zoom level (1-20). Higher numbers = more zoomed in')),
            ])
    );
});
