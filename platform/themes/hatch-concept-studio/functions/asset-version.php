<?php

use Botble\Theme\Facades\Theme;

if (! function_exists('theme_asset_version')) {
    /*
     * @param  string  $relativePath  مسار الملف، إما نسبةً لمجلد الثيم زي "js/menu.js"
     */
    function theme_asset_version(string $relativePath): ?string
    {
        $relativePath = ltrim($relativePath, '/');

        if (! str_starts_with($relativePath, 'themes/')) {
            $relativePath = 'themes/' . Theme::getThemeName() . '/' . $relativePath;
        }

        $filePath = public_path($relativePath);

        if (! is_file($filePath)) {
            return null;
        }

        return filemtime($filePath) . '-' . filesize($filePath);
    }
}
