<?php

use Botble\Base\Facades\AdminHelper;
use Illuminate\Support\Facades\Route;
use SharjahStore\Http\Controllers\CollectionController;
use SharjahStore\Http\Controllers\ProductController;
use SharjahStore\Models\Collection;
use SharjahStore\Models\Product;
use Botble\Base\Enums\BaseStatusEnum;

// Admin routes
AdminHelper::registerRoutes(function () {
    Route::prefix('store')->name('store.')->group(function () {
        
        // Collections Routes
        Route::prefix('collections')->name('collections.')->group(function () {
            Route::resource('', CollectionController::class, [
                'parameters' => ['' => 'collection'],
                'names' => [
                    'index' => 'index',
                    'create' => 'create', 
                    'store' => 'store',
                    'edit' => 'edit',
                    'update' => 'update',
                    'destroy' => 'destroy'
                ]
            ]);
        });

        // Products Routes
        Route::prefix('products')->name('products.')->group(function () {
            Route::resource('', ProductController::class, [
                'parameters' => ['' => 'product'],
                'names' => [
                    'index' => 'index',
                    'create' => 'create', 
                    'store' => 'store',
                    'edit' => 'edit',
                    'update' => 'update',
                    'destroy' => 'destroy'
                ]
            ]);
        });
    });
});

// Front-end routes
Route::get('/store/collections/{slug}', function ($slug) {
    $collection = Collection::where('slug', $slug)
        ->where('status', BaseStatusEnum::PUBLISHED)
        ->firstOrFail();
    
    $products = Product::where('collection_id', $collection->id)
        ->where('status', BaseStatusEnum::PUBLISHED)
        ->orderBy('created_at', 'desc')
        ->get();
    
    return view('theme.sharjah-triennial::layouts.collection-single', compact('collection', 'products'));
})->name('store.collection.single');

Route::get('/store/products/{slug}', function ($slug) {
    $product = Product::where('slug', $slug)
        ->where('status', BaseStatusEnum::PUBLISHED)
        ->with('collection')
        ->firstOrFail();
    
    return view('theme.sharjah-triennial::layouts.product-single', compact('product'));
})->name('store.product.single');
