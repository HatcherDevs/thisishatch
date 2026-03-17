<?php

namespace SharjahOpportunities\Forms;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Forms\FormAbstract;
use SharjahOpportunities\Http\Requests\OpportunityRequest;
use SharjahOpportunities\Models\Opportunity;

class OpportunityForm extends FormAbstract
{
    public function buildForm(): void
    {
        $this
            ->setupModel(new Opportunity())
            ->setValidatorClass(OpportunityRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label' => trans('plugins/sharjah-opportunities::opportunities.form.name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'placeholder' => trans('plugins/sharjah-opportunities::opportunities.form.name'),
                    'data-counter' => 255,
                ],
            ])

            ->add('description', 'textarea', [
                'label' => trans('plugins/sharjah-opportunities::opportunities.form.description'),
                'label_attr' => ['class' => 'control-label'],
                'attr' => [
                    'rows' => 4,
                    'placeholder' => trans('plugins/sharjah-opportunities::opportunities.form.description_placeholder'),
                    'data-counter' => 400,
                ],
            ])
            ->add('content', 'editor', [
                'label' => trans('plugins/sharjah-opportunities::opportunities.form.content'),
                'label_attr' => ['class' => 'control-label'],
                'attr' => [
                    'with-short-code' => true,
                    'without-buttons' => false,
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
                'label' => trans('plugins/sharjah-opportunities::opportunities.form.image'),
                'label_attr' => ['class' => 'control-label'],
            ]);
    }
}
