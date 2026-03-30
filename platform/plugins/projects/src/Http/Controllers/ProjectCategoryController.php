<?php

namespace Botble\Projects\Http\Controllers;

use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Projects\Forms\ProjectCategoryForm;
use Botble\Projects\Http\Requests\ProjectCategoryRequest;
use Botble\Projects\Models\ProjectCategory;
use Botble\Projects\Tables\ProjectCategoryTable;

class ProjectCategoryController extends BaseController
{
    public function index(ProjectCategoryTable $table)
    {
        $this->pageTitle(trans('plugins/projects::projects.categories'));

        return $table->renderTable();
    }

    public function create(): string
    {
        $this->pageTitle(trans('plugins/projects::projects.create_category'));

        return ProjectCategoryForm::create()->renderForm();
    }

    public function store(ProjectCategoryRequest $request)
    {
        ProjectCategoryForm::create()->setRequest($request)->saveOnlyValidatedData();

        return $this
            ->httpResponse()
            ->setNextUrl(route('projects.categories.index'))
            ->withCreatedSuccessMessage();
    }

    public function edit(ProjectCategory $category): string
    {
        $this->pageTitle(trans('core/base::forms.edit_item', ['name' => $category->name]));

        return ProjectCategoryForm::createFromModel($category)->renderForm();
    }

    public function update(ProjectCategory $category, ProjectCategoryRequest $request)
    {
        ProjectCategoryForm::createFromModel($category)->setRequest($request)->saveOnlyValidatedData();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('projects.categories.index'))
            ->withUpdatedSuccessMessage();
    }

    public function destroy(ProjectCategory $category)
    {
        return DeleteResourceAction::make($category);
    }
}
