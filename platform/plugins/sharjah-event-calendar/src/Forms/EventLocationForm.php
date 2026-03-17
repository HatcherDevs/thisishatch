<?php

namespace Botble\SharjahEventCalendar\Forms;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Forms\FormAbstract;
use Botble\SharjahEventCalendar\Http\Requests\EventLocationRequest;
use Botble\SharjahEventCalendar\Models\EventLocation;

class EventLocationForm extends FormAbstract
{
    public function buildForm(): void
    {
        $this
            ->setupModel(new EventLocation)
            ->setValidatorClass(EventLocationRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label' => trans('plugins/sharjah-event-calendar::locations.name'),
                'required' => true,
                'attr' => [
                    'placeholder' => trans('plugins/sharjah-event-calendar::locations.name'),
                    'data-counter' => 120,
                ],
            ])
            ->add('address', 'text', [
                'label' => trans('plugins/sharjah-event-calendar::locations.address'),
                'required' => false,
                'attr' => [
                    'placeholder' => trans('plugins/sharjah-event-calendar::locations.address'),
                ],
            ])
            ->add('city', 'text', [
                'label' => trans('plugins/sharjah-event-calendar::locations.city'),
                'required' => false,
                'attr' => [
                    'placeholder' => trans('plugins/sharjah-event-calendar::locations.city'),
                ],
            ])
            ->add('state', 'text', [
                'label' => trans('plugins/sharjah-event-calendar::locations.state'),
                'required' => false,
                'attr' => [
                    'placeholder' => trans('plugins/sharjah-event-calendar::locations.state'),
                ],
            ])
            ->add('country', 'text', [
                'label' => trans('plugins/sharjah-event-calendar::locations.country'),
                'required' => false,
                'attr' => [
                    'placeholder' => trans('plugins/sharjah-event-calendar::locations.country'),
                ],
            ])
            ->add('latitude', 'text', [
                'label' => trans('plugins/sharjah-event-calendar::locations.latitude'),
                'required' => false,
                'attr' => [
                    'placeholder' => trans('plugins/sharjah-event-calendar::locations.latitude_placeholder'),
                ],
            ])
            ->add('longitude', 'text', [
                'label' => trans('plugins/sharjah-event-calendar::locations.longitude'),
                'required' => false,
                'attr' => [
                    'placeholder' => trans('plugins/sharjah-event-calendar::locations.longitude_placeholder'),
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
