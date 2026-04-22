<?php

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Projects\Models\Project;
use Botble\Projects\Models\ProjectCategory;
use Botble\Theme\Facades\Theme;
use Illuminate\Support\Facades\Route;

// Custom routes
// You can delete this route group if you don't need to add your custom routes.
Theme::registerRoutes(function (): void {
    Route::redirect('/', '/home');

    Route::get('/projects', function () {
        $projects = Project::query()
            ->with(['category', 'tags'])
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->orderBy('order')
            ->orderByDesc('id')
            ->get();

        $categories = ProjectCategory::query()
            ->whereHas('projects', fn ($query) => $query->where('status', BaseStatusEnum::PUBLISHED))
            ->orderBy('name')
            ->get();

        return Theme::scope('projects', compact('projects', 'categories'))->render();
    })->name('public.projects');
});

Theme::routes();
