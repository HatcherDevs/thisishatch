<?php

namespace SharjahStore\Forms;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Forms\FormAbstract;
use Botble\Base\Forms\Fields\EditorField;
use Botble\Base\Forms\FieldOptions\EditorFieldOption;
use SharjahStore\Http\Requests\CollectionRequest;
use SharjahStore\Models\Collection;

class CollectionForm extends FormAbstract
{
    public function buildForm(): void
    {
        $this
            ->setupModel(new Collection())
            ->setValidatorClass(CollectionRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label' => trans('plugins/sharjah-store::collections.form.name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'placeholder' => trans('plugins/sharjah-store::collections.form.name'),
                    'data-counter' => 255,
                ],
            ])
            ->add('description', 'textarea', [
                'label' => trans('plugins/sharjah-store::collections.form.description'),
                'label_attr' => ['class' => 'control-label'],
                'attr' => [
                    'rows' => 4,
                    'placeholder' => trans('plugins/sharjah-store::collections.form.description'),
                    'data-counter' => 400,
                ],
            ])
            ->setBreakFieldPoint('status')
            ->add('status', 'customSelect', [
                'label' => trans('core/base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'class' => 'form-control select-full',
                ],
                'choices' => BaseStatusEnum::labels(),
            ])
            ->add('image', 'mediaImage', [
                'label' => trans('plugins/sharjah-store::collections.form.image'),
                'label_attr' => ['class' => 'control-label'],
            ]);
    }
}
