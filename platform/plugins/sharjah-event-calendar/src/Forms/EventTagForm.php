<?php

namespace Botble\SharjahEventCalendar\Forms;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Forms\FormAbstract;
use Botble\SharjahEventCalendar\Http\Requests\EventTagRequest;
use Botble\SharjahEventCalendar\Models\EventTag;

class EventTagForm extends FormAbstract
{
    public function buildForm(): void
    {
        $this
            ->setupModel(new EventTag)
            ->setValidatorClass(EventTagRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label' => trans('plugins/sharjah-event-calendar::tags.name'),
                'required' => true,
                'attr' => [
                    'placeholder' => trans('plugins/sharjah-event-calendar::tags.name'),
                    'data-counter' => 120,
                ],
            ])
            ->add('description', 'textarea', [
                'label' => trans('core/base::forms.description'),
                'required' => false,
                'attr' => [
                    'rows' => 4,
                    'placeholder' => trans('core/base::forms.description_placeholder'),
                ],
            ])
            ->add('status', 'customSelect', [
                'label' => trans('core/base::tables.status'),
                'required' => true,
                'choices' => BaseStatusEnum::labels(),
            ])
            ->setBreakFieldPoint('status');
    }
}
