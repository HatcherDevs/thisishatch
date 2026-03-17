<?php

namespace ArchiElite\SharjahRepository\Http\Controllers;

use ArchiElite\SharjahRepository\Forms\RepositoryItemForm;
use ArchiElite\SharjahRepository\Http\Requests\RepositoryItemRequest;
use ArchiElite\SharjahRepository\Models\RepositoryItem;
use ArchiElite\SharjahRepository\Tables\RepositoryItemTable;
use Botble\Base\Facades\PageTitle;
use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Illuminate\Http\Request;

class RepositoryItemController extends BaseController
{
    public function index(RepositoryItemTable $table)
    {
        PageTitle::setTitle(trans('plugins/sharjah-repository::repository.name'));

        return $table->renderTable();
    }

    public function create()
    {
        PageTitle::setTitle(trans('plugins/sharjah-repository::repository.create'));

        return RepositoryItemForm::create()->renderForm();
    }

    public function store(RepositoryItemRequest $request)
    {
        $form = RepositoryItemForm::create();

        $form->setRequest($request)->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('repository-items.index'))
            ->setNextUrl(route('repository-items.edit', $form->getModel()->getKey()))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(RepositoryItem $repositoryItem, Request $request)
    {
        PageTitle::setTitle(trans('core/base::forms.edit_item', ['name' => $repositoryItem->title]));

        return RepositoryItemForm::createFromModel($repositoryItem)->renderForm();
    }

    public function update(RepositoryItem $repositoryItem, RepositoryItemRequest $request, BaseHttpResponse $response)
    {
        RepositoryItemForm::createFromModel($repositoryItem)->setRequest($request)->save();

        return $response
            ->setPreviousUrl(route('repository-items.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(RepositoryItem $repositoryItem)
    {
        return DeleteResourceAction::make($repositoryItem);
    }
}
