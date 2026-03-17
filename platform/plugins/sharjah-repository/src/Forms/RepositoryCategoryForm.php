<?php

namespace ArchiElite\SharjahRepository\Forms;

use ArchiElite\SharjahRepository\Http\Requests\RepositoryCategoryRequest;
use ArchiElite\SharjahRepository\Models\RepositoryCategory;
use Botble\Base\Forms\FieldOptions\NameFieldOption;
use Botble\Base\Forms\FieldOptions\StatusFieldOption;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FormAbstract;

class RepositoryCategoryForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(RepositoryCategory::class)
            ->setValidatorClass(RepositoryCategoryRequest::class)
            ->withCustomFields()
            ->add('name', TextField::class, NameFieldOption::make()->required()->toArray())
            ->add('status', SelectField::class, StatusFieldOption::make()->toArray())
            ->setBreakFieldPoint('status');
    }
}
