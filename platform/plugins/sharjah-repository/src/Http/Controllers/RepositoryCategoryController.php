<?php

namespace ArchiElite\SharjahRepository\Http\Controllers;

use ArchiElite\SharjahRepository\Forms\RepositoryCategoryForm;
use ArchiElite\SharjahRepository\Http\Requests\RepositoryCategoryRequest;
use ArchiElite\SharjahRepository\Models\RepositoryCategory;
use ArchiElite\SharjahRepository\Tables\RepositoryCategoryTable;
use Botble\Base\Facades\PageTitle;
use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Illuminate\Http\Request;

class RepositoryCategoryController extends BaseController
{
    public function index(RepositoryCategoryTable $table)
    {
        PageTitle::setTitle(trans('plugins/sharjah-repository::repository.categories'));

        return $table->renderTable();
    }

    public function create()
    {
        PageTitle::setTitle(trans('plugins/sharjah-repository::repository.create_category'));

        return RepositoryCategoryForm::create()->renderForm();
    }

    public function store(RepositoryCategoryRequest $request)
    {
        $form = RepositoryCategoryForm::create();

        $form->setRequest($request)->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('repository-categories.index'))
            ->setNextUrl(route('repository-categories.edit', $form->getModel()->getKey()))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(RepositoryCategory $repositoryCategory, Request $request)
    {
        PageTitle::setTitle(trans('core/base::forms.edit_item', ['name' => $repositoryCategory->name]));

        return RepositoryCategoryForm::createFromModel($repositoryCategory)->renderForm();
    }

    public function update(RepositoryCategory $repositoryCategory, RepositoryCategoryRequest $request, BaseHttpResponse $response)
    {
        RepositoryCategoryForm::createFromModel($repositoryCategory)->setRequest($request)->save();

        return $response
            ->setPreviousUrl(route('repository-categories.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(RepositoryCategory $repositoryCategory)
    {
        return DeleteResourceAction::make($repositoryCategory);
    }
}
