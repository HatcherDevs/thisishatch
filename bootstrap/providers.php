<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\EventServiceProvider::class,
    App\Providers\LanguageOverrideServiceProvider::class,
    App\Providers\RemoveLocaleFromUrlsServiceProvider::class,
    App\Providers\RouteServiceProvider::class,
    // 🔒 Security: Password Policy Provider
    App\Providers\PasswordPolicyServiceProvider::class,
];
