<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class LanguageOverrideServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     * 
     * Override Language plugin's slug prefix to prevent adding locale to URLs.
     * Language will be handled by session only, not in URL.
     */
    public function boot(): void
    {
        // Override the FILTER_SLUG_PREFIX to remove locale from URLs
        // This runs with very high priority (9999) to ensure it runs last
        add_filter(FILTER_SLUG_PREFIX, function ($prefix, $model = null) {
            // Simply return the prefix without adding any locale
            // This prevents /en/ or /ar/ from being added to URLs
            return $prefix;
        }, 9999, 2);

        // Also override the cms_slug_prefix filter just in case
        add_filter('cms_slug_prefix', function ($prefix, $model = null) {
            // Remove any locale prefix that might have been added
            $locales = ['en', 'ar']; // Add your locales here

            foreach ($locales as $locale) {
                // Remove locale/ from the beginning
                if (strpos($prefix, $locale . '/') === 0) {
                    $prefix = substr($prefix, strlen($locale) + 1);
                }
                // Remove just locale if it's the only thing
                if ($prefix === $locale) {
                    $prefix = '';
                }
            }

            return $prefix;
        }, 9999, 2);
    }
}
