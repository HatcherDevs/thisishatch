<?php

use ArchiElite\SharjahRepository\Models\RepositoryItem;
use Botble\Base\Facades\BaseHelper;
use Botble\Base\Enums\BaseStatusEnum;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'ArchiElite\SharjahRepository\Http\Controllers', 'middleware' => ['web', 'core']], function (): void {
    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function (): void {
        Route::group(['prefix' => 'repository-categories', 'as' => 'repository-categories.'], function (): void {
            Route::resource('', 'RepositoryCategoryController')->parameters(['' => 'repositoryCategory']);
        });

        Route::group(['prefix' => 'repository-items', 'as' => 'repository-items.'], function (): void {
            Route::resource('', 'RepositoryItemController')->parameters(['' => 'repositoryItem']);
        });
    });
});


Route::get('/repositories', function () {
    $repositories = RepositoryItem::with(['category'])
        ->where('status', BaseStatusEnum::PUBLISHED)
        ->whereHas('category', function ($query) {
            $query->where('status', BaseStatusEnum::PUBLISHED);
        })
        ->get();

    $categories = \ArchiElite\SharjahRepository\Models\RepositoryCategory::where('status', BaseStatusEnum::PUBLISHED)->get();

    return view('theme.sharjah-triennial::layouts.repository', compact('repositories', 'categories'));
});

Route::get('/repositories/{slug}', function ($slug) {
    $repository = RepositoryItem::with(['category'])
        ->where('slug', $slug)
        ->where('status', BaseStatusEnum::PUBLISHED)
        ->whereHas('category', function ($query) {
            $query->where('status', BaseStatusEnum::PUBLISHED);
        })
        ->firstOrFail();
    return view('theme.sharjah-triennial::layouts.repository-single', compact('repository'));
});
