<?php

namespace ArchiElite\SharjahRepository\Forms;

use ArchiElite\SharjahRepository\Http\Requests\RepositoryItemRequest;
use ArchiElite\SharjahRepository\Models\RepositoryCategory;
use ArchiElite\SharjahRepository\Models\RepositoryItem;
use Botble\Base\Forms\FieldOptions\ContentFieldOption;
use Botble\Base\Forms\FieldOptions\MediaImageFieldOption;
use Botble\Base\Forms\FieldOptions\NameFieldOption;
use Botble\Base\Forms\FieldOptions\StatusFieldOption;
use Botble\Base\Forms\Fields\EditorField;
use Botble\Base\Forms\Fields\MediaImageField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FormAbstract;
use Botble\Slug\Forms\Fields\PermalinkField;

class RepositoryItemForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(RepositoryItem::class)
            ->setValidatorClass(RepositoryItemRequest::class)
            ->withCustomFields()
            ->add('title', TextField::class, NameFieldOption::make()->required()->label(trans('plugins/sharjah-repository::repository.title'))->toArray())
            ->add('content', EditorField::class, ContentFieldOption::make()->allowedShortcodes()->toArray())
            ->add('status', SelectField::class, StatusFieldOption::make()->toArray())
            ->add('category_id', SelectField::class, [
                'label' => trans('plugins/sharjah-repository::repository.category'),
                'required' => true,
                'choices' => RepositoryCategory::query()->pluck('name', 'id')->all(),
                'empty_value' => trans('plugins/sharjah-repository::repository.select_category'),
            ])
            ->add('image', MediaImageField::class, MediaImageFieldOption::make()->label(trans('plugins/sharjah-repository::repository.image'))->toArray())
            ->setBreakFieldPoint('status');
    }
}
