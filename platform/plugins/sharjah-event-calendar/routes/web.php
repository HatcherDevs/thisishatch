<?php

use Botble\Base\Facades\AdminHelper;
use Botble\SharjahEventCalendar\Http\Controllers\EventCategoryController;
use Botble\SharjahEventCalendar\Http\Controllers\EventController;
use Botble\SharjahEventCalendar\Http\Controllers\EventLocationController;
use Botble\SharjahEventCalendar\Http\Controllers\EventRegistrationController;
use Botble\SharjahEventCalendar\Http\Controllers\EventTagController;
use Illuminate\Support\Facades\Route;

// Admin Routes
AdminHelper::registerRoutes(function () {
    Route::group(['prefix' => 'events', 'as' => 'events.'], function () {
        // Events
        Route::resource('', EventController::class)->parameters(['' => 'event']);

        // Categories
        Route::group(['prefix' => 'categories', 'as' => 'categories.'], function () {
            Route::resource('', EventCategoryController::class)->parameters(['' => 'category']);
        });

        // Tags
        Route::group(['prefix' => 'tags', 'as' => 'tags.'], function () {
            Route::resource('', EventTagController::class)->parameters(['' => 'tag']);
        });

        // Locations
        Route::group(['prefix' => 'locations', 'as' => 'locations.'], function () {
            Route::resource('', EventLocationController::class)->parameters(['' => 'location']);
        });

        // Registrations
        Route::group(['prefix' => '{event}/registrations', 'as' => 'registrations.'], function () {
            Route::get('/', [EventRegistrationController::class, 'index'])->name('index');
            Route::get('/search', [EventRegistrationController::class, 'search'])->name('search');
            Route::post('/', [EventRegistrationController::class, 'index']); // For DataTables Ajax
            Route::get('/{registration}', [EventRegistrationController::class, 'show'])->name('show');
            Route::post('/{registration}/approve', [EventRegistrationController::class, 'approve'])->name('approve');
            Route::post('/{registration}/reject', [EventRegistrationController::class, 'reject'])->name('reject');
            Route::delete('/{registration}', [EventRegistrationController::class, 'destroy'])->name('destroy');
            Route::get('/export', [EventRegistrationController::class, 'export'])->name('export');
        });
    });
});

// Public Routes (Frontend)
Route::group(['namespace' => 'Botble\SharjahEventCalendar\Http\Controllers', 'middleware' => ['web', 'core']], function () {
    Route::group(['prefix' => 'events', 'as' => 'public.events.'], function () {
        Route::get('/', 'PublicEventController@index')->name('index');
        Route::get('/calendar', 'PublicEventController@calendar')->name('calendar');
        Route::get('/category/{slug}', 'PublicEventController@category')->name('category');
        Route::get('/tag/{slug}', 'PublicEventController@tag')->name('tag');
        Route::get('/location/{slug}', 'PublicEventController@location')->name('location');
        Route::get('/{slug}', 'PublicEventController@detail')->name('detail');

        // Registration (Rate Limited: 3 attempts per minute)
        Route::post('/{slug}/register', 'PublicRegistrationController@store')
            ->middleware('throttle:3,1')
            ->name('register');
    });
});
