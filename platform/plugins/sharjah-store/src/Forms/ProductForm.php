<?php

namespace SharjahStore\Forms;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Forms\FormAbstract;
use Botble\Base\Forms\Fields\EditorField;
use Botble\Base\Forms\FieldOptions\EditorFieldOption;
use SharjahStore\Http\Requests\ProductRequest;
use SharjahStore\Models\Product;
use SharjahStore\Models\Collection;

class ProductForm extends FormAbstract
{
    public function buildForm(): void
    {
        $collections = Collection::where('status', BaseStatusEnum::PUBLISHED)
            ->orderBy('created_at', 'desc')
            ->pluck('name', 'id')
            ->toArray();

        $this
            ->setupModel(new Product())
            ->setValidatorClass(ProductRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label' => trans('plugins/sharjah-store::products.form.name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'placeholder' => trans('plugins/sharjah-store::products.form.name'),
                    'data-counter' => 255,
                ],
            ])
            ->add('description', 'textarea', [
                'label' => trans('plugins/sharjah-store::products.form.description'),
                'label_attr' => ['class' => 'control-label'],
                'attr' => [
                    'rows' => 4,
                    'placeholder' => trans('plugins/sharjah-store::products.form.description'),
                    'data-counter' => 400,
                ],
            ])
            ->add('content', EditorField::class, EditorFieldOption::make()
                ->label(trans('plugins/sharjah-store::products.form.content'))
                ->allowedShortcodes()
            )
            ->add('down_row', EditorField::class, EditorFieldOption::make()
                ->label(trans('plugins/sharjah-store::products.form.down_row'))
                ->allowedShortcodes()
            )

            ->setBreakFieldPoint('status')
            ->add('status', 'customSelect', [
                'label' => trans('core/base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'class' => 'form-control select-full',
                ],
                'choices' => BaseStatusEnum::labels(),
            ])
                        ->add('collection_id', 'customSelect', [
                'label' => trans('plugins/sharjah-store::products.form.collection'),
                'label_attr' => ['class' => 'control-label'],
                'attr' => [
                    'class' => 'form-control select-search-full',
                ],
                'choices' => ['' => trans('plugins/sharjah-store::products.form.select_collection')] + $collections,
            ])
            ->add('image', 'mediaImage', [
                'label' => trans('plugins/sharjah-store::products.form.image'),
                'label_attr' => ['class' => 'control-label'],
            ]);
    }
}
