<?php

use Botble\Shortcode\View\View;
use Botble\Theme\Theme;

return [

    /*
    |--------------------------------------------------------------------------
    | Inherit from another theme
    |--------------------------------------------------------------------------
    */

    'inherit' => null, //default

    /*
    |--------------------------------------------------------------------------
    | Listener from events
    |--------------------------------------------------------------------------
    |
    | You can hook a theme when event fired on activities
    | this is cool feature to set up a title, meta, default styles and scripts.
    |
    | [Notice] these events can be overridden by package config.
    |
    */

    'events' => [

        // Before event inherit from package config and the theme that call before,
        // you can use this event to set meta, breadcrumb template or anything
        // you want inheriting.
        'before' => function ($theme): void {
            // You can remove this line anytime.
        },

        // Listen on event before render a theme,
        // this event should call to assign some assets,
        // breadcrumb template.
        'beforeRenderTheme' => function (Theme $theme): void {
            $version = get_cms_version();

            $bootstrapCss = \Botble\Base\Facades\BaseHelper::isRtlEnabled() ? 'bootstrap.rtl.min.css' : 'bootstrap.min.css';

            // CSS Assets
            // $theme->asset()->usePath()->add('bootstrap', "css/$bootstrapCss");
            // $theme->asset()->usePath()->add('fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', [], [], '6.4.0');
            // $theme->asset()->usePath()->add('style', 'css/style.css', version: $version);
        
            // if (\Botble\Base\Facades\BaseHelper::isRtlEnabled()) {
            //     $theme->asset()->usePath()->add('rtl', 'css/rtl.css', version: $version);
            // }

            // JS Assets  
            // $theme->asset()->container('footer')->usePath()->add('jquery', 'https://code.jquery.com/jquery-3.7.0.min.js', [], [], '3.7.0');
            // $theme->asset()->container('footer')->usePath()->add('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js', ['jquery'], [], '5.3.0');
            // $theme->asset()->container('footer')->usePath()->add('main', 'js/main.js', ['jquery'], version: $version);
        
            // Social Login Plugin
            // if (is_plugin_active('social-login')) {
            //     $theme->asset()
            //         ->usePath(false)
            //         ->add('social-login-css', asset('vendor/core/plugins/social-login/css/social-login.css'), [], [], '1.0.0');
            // }
        
            // Shortcodes
            if (function_exists('shortcode')) {
                $theme->composer(['page', 'post'], function (View $view) {
                    $view->withShortcodes();
                });
            }
        },

        // Listen on event before render a layout,
        // this should call to assign style, script for a layout.
        'beforeRenderLayout' => [
            'default' => function ($theme): void {
                // $theme->asset()->usePath()->add('ipad', 'css/layouts/ipad.css');
            },
        ],
    ],
];
