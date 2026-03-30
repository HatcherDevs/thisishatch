<?php

use Botble\Media\Facades\RvMedia;
use Botble\Theme\Supports\ThemeSupport;

register_page_template([
    'default' => __('Default'),
    'about' => __('About'),
    'projects' => __('Projects'),
    'contact' => __('Contact'),
    'store' => __('Store'),
    'project-details' => __('Project Details'),
]);

app()->booted(function () {
    RvMedia::addSize('medium', 800, 800)
        ->addSize('thumb', 400, 400);

    ThemeSupport::registerSocialLinks();
    ThemeSupport::registerToastNotification();
    ThemeSupport::registerPreloader();
    ThemeSupport::registerSiteCopyright();
    ThemeSupport::registerDateFormatOption();
    ThemeSupport::registerLazyLoadImages();
    ThemeSupport::registerSocialSharing();
    ThemeSupport::registerSiteLogoHeight();
});
