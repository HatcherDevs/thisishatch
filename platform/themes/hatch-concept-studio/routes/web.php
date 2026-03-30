<?php

use Botble\Theme\Facades\Theme;
use Illuminate\Support\Facades\Route;

// Custom routes
// You can delete this route group if you don't need to add your custom routes.
Theme::registerRoutes(function (): void {
    Route::redirect('/', '/home');
});

Theme::routes();
