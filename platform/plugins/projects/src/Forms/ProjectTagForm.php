<?php

namespace Botble\Projects\Forms;

use Botble\Base\Forms\FieldOptions\NameFieldOption;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FormAbstract;
use Botble\Projects\Http\Requests\ProjectTagRequest;
use Botble\Projects\Models\ProjectTag;

class ProjectTagForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(ProjectTag::class)
            ->setValidatorClass(ProjectTagRequest::class)
            ->add(
                'name',
                TextField::class,
                NameFieldOption::make()
                    ->label(trans('plugins/projects::projects.form.name'))
                    ->required()
            );
    }
}
