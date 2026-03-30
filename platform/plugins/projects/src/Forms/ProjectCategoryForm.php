<?php

namespace Botble\Projects\Forms;

use Botble\Base\Forms\FieldOptions\NameFieldOption;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FormAbstract;
use Botble\Projects\Http\Requests\ProjectCategoryRequest;
use Botble\Projects\Models\ProjectCategory;

class ProjectCategoryForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(ProjectCategory::class)
            ->setValidatorClass(ProjectCategoryRequest::class)
            ->add(
                'name',
                TextField::class,
                NameFieldOption::make()
                    ->label(trans('plugins/projects::projects.form.name'))
                    ->required()
            );
    }
}
