<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Botble\SharjahRepository\Models\RepositoryItem;

Route::get('/set-lang/{locale}', function ($locale) {
    // Validate locale
    if (!in_array($locale, ['en', 'ar'])) {
        abort(404);
    }

    // Use same session key as Language plugin
    Session::put('language', $locale);

    // For frontend language switching - LocaleMiddleware fallback
    session(['site-locale' => $locale]);



    // Set app locale immediately
    app()->setLocale($locale);

    return redirect()->back()->withHeaders([
        'Cache-Control' => 'no-cache, no-store, must-revalidate',
        'Pragma' => 'no-cache',
        'Expires' => '0',
    ]);
})->name('set.language');


Route::get('/admin/set-lang/{locale}', function ($locale) {
    // Validate locale
    if (!in_array($locale, ['en', 'ar'])) {
        abort(404);
    }
    session(['dashboard_locale' => $locale]);
    session(['dashboard_locale_direction' => $locale === 'ar' ? 'rtl' : 'ltr']);

    // Store in admin_language session for admin area
    session(['admin_language' => $locale]);
    

    return redirect()->back()->withHeaders([
        'Cache-Control' => 'no-cache, no-store, must-revalidate',
        'Pragma' => 'no-cache',
        'Expires' => '0',
    ]);
})->name('admin.set.language');
