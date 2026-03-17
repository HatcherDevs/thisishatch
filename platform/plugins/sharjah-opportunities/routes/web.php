<?php

use Botble\Base\Facades\AdminHelper;
use Illuminate\Support\Facades\Route;
use SharjahOpportunities\Http\Controllers\OpportunityController;


use SharjahOpportunities\Models\Opportunity;
use Botble\Base\Enums\BaseStatusEnum;

// Admin routes
AdminHelper::registerRoutes(function () {
    Route::group(['prefix' => 'opportunities', 'as' => 'opportunities.'], function () {
        Route::resource('', OpportunityController::class, [
            'parameters' => ['' => 'opportunity'],
            'names' => [
                'index' => 'index',
                'create' => 'create', 
                'store' => 'store',
                'show' => 'show',
                'edit' => 'edit',
                'update' => 'update',
                'destroy' => 'destroy'
            ]
        ]);
    });
});



Route::get('/opportunities/{slug}', function ($slug) {

    $opportunity = Opportunity::where('slug', $slug)
        ->where('status', BaseStatusEnum::PUBLISHED)
        ->firstOrFail();
    return view('theme.sharjah-triennial::layouts.opportunity-single', compact('opportunity'));
})->name('opportunity.single');


//    return view('theme.sharjah-triennial::layouts.repository-single', compact('repository'));