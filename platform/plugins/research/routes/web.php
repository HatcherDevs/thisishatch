<?php

use Botble\Base\Facades\BaseHelper;
use Botble\Research\Http\Controllers\LocationController;
use Botble\Research\Http\Controllers\TimelineController;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Botble\Research\Http\Controllers', 'middleware' => ['web', 'core']], function () {
    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {
        // Timelines
        Route::group(['prefix' => 'research/timelines', 'as' => 'research.timelines.'], function () {
            Route::resource('', TimelineController::class)->parameters(['' => 'timeline']);
        });

        // Locations
        Route::group(['prefix' => 'research/locations', 'as' => 'research.locations.'], function () {
            Route::resource('', LocationController::class)->parameters(['' => 'location']);
        });
    });
});
