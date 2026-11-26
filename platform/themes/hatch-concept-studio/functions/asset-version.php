<?php

use Botble\Theme\Facades\Theme;

if (! function_exists('theme_asset_version')) {
    /**
     * رقم نسخة الأصل (asset) مبني على وقت آخر تعديل للملف + حجمه.
     *
     * الفايدة: الرقم بيتغيّر تلقائيًا مع أي تعديل للملف، فبيتفادى كاش المتصفح
     * من غير ما نكتب رقم ثابت كل مرة. لو رقم الملف اتساوى (تعديل في نفس الثانية)
     * حجم الملف بيفرّق بينهم.
     *
     * @param  string  $relativePath  مسار الملف، إما نسبةً لمجلد الثيم زي "js/menu.js"
     *                                أو نسبةً لمجلد public زي "themes/hatch-concept-studio/js/menu.js"
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
