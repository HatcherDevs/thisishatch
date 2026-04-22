<?php

use Botble\Base\Facades\AdminHelper;
use Botble\Projects\Http\Controllers\ProjectCategoryController;
use Botble\Projects\Http\Controllers\ProjectController;
use Botble\Projects\Http\Controllers\ProjectTagController;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Botble\\Projects\\Http\\Controllers'], function (): void {
    AdminHelper::registerRoutes(function (): void {
        Route::group(['prefix' => 'projects', 'as' => 'projects.'], function (): void {
            Route::resource('', ProjectController::class)->parameters(['' => 'project']);

            Route::group(['permission' => 'projects.edit'], function (): void {
                Route::get('{project}/move-up', [ProjectController::class, 'moveUp'])->name('move-up');
                Route::get('{project}/move-down', [ProjectController::class, 'moveDown'])->name('move-down');
                Route::post('reorder', [ProjectController::class, 'reorder'])->name('reorder');
                Route::post('{project}/toggle-highlight', [ProjectController::class, 'toggleHighlight'])->name('toggle-highlight');
            });

            Route::group(['prefix' => 'categories', 'as' => 'categories.', 'permission' => 'projects.categories.index'], function (): void {
                Route::resource('', ProjectCategoryController::class)->parameters(['' => 'category']);
            });

            Route::group(['prefix' => 'tags', 'as' => 'tags.', 'permission' => 'projects.tags.index'], function (): void {
                Route::resource('', ProjectTagController::class)->parameters(['' => 'tag']);
            });
        });
    });
});
