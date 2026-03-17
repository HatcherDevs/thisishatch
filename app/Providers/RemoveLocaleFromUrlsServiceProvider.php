<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RemoveLocaleFromUrlsServiceProvider extends ServiceProvider
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
     * Override the Language plugin's filters to prevent adding locale prefixes
     * (en/, ar/) to URLs. Language will be handled via session only.
     */
    public function boot(): void
    {
        // Override FILTER_SLUG_PREFIX with high priority (1000) to run after Language plugin (priority 500)
        add_filter(FILTER_SLUG_PREFIX, function ($prefix) {
            // Remove locale from prefix (en/, ar/, etc.)
            $supportedLocales = ['en', 'ar'];

            foreach ($supportedLocales as $locale) {
                // Remove locale/ from beginning
                if (strpos($prefix, $locale . '/') === 0) {
                    $prefix = substr($prefix, strlen($locale) + 1);
                }
                // Remove /locale/ from anywhere
                $prefix = str_replace('/' . $locale . '/', '/', $prefix);
                // Remove standalone locale
                if ($prefix === $locale) {
                    $prefix = '';
                }
            }

            return $prefix;
        }, 1000);

        // Override MENU_FILTER_NODE_URL to prevent adding locale to menu URLs
        // This runs with priority 1000 (after Language plugin which uses priority 1)
        add_filter(MENU_FILTER_NODE_URL, function ($url) {
            // Remove locale prefix (en/, ar/) from URLs
            $supportedLocales = ['en', 'ar'];

            foreach ($supportedLocales as $locale) {
                $pattern = '#/' . $locale . '/#';
                $url = preg_replace($pattern, '/', $url, 1);
            }

            return $url;
        }, 1000);
    }
}
