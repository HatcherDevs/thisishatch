<?php

namespace Botble\Projects\Http\Controllers;

use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Projects\Forms\ProjectTagForm;
use Botble\Projects\Http\Requests\ProjectTagRequest;
use Botble\Projects\Models\ProjectTag;
use Botble\Projects\Tables\ProjectTagTable;

class ProjectTagController extends BaseController
{
    public function index(ProjectTagTable $table)
    {
        $this->pageTitle(trans('plugins/projects::projects.tags'));

        return $table->renderTable();
    }

    public function create(): string
    {
        $this->pageTitle(trans('plugins/projects::projects.create_tag'));

        return ProjectTagForm::create()->renderForm();
    }

    public function store(ProjectTagRequest $request)
    {
        ProjectTagForm::create()->setRequest($request)->saveOnlyValidatedData();

        return $this
            ->httpResponse()
            ->setNextUrl(route('projects.tags.index'))
            ->withCreatedSuccessMessage();
    }

    public function edit(ProjectTag $tag): string
    {
        $this->pageTitle(trans('core/base::forms.edit_item', ['name' => $tag->name]));

        return ProjectTagForm::createFromModel($tag)->renderForm();
    }

    public function update(ProjectTag $tag, ProjectTagRequest $request)
    {
        ProjectTagForm::createFromModel($tag)->setRequest($request)->saveOnlyValidatedData();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('projects.tags.index'))
            ->withUpdatedSuccessMessage();
    }

    public function destroy(ProjectTag $tag)
    {
        return DeleteResourceAction::make($tag);
    }
}
