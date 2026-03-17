<?php

namespace Botble\Research\Forms;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Forms\FormAbstract;
use Botble\Research\Http\Requests\TimelineRequest;
use Botble\Research\Models\Timeline;

class TimelineForm extends FormAbstract
{
    public function buildForm(): void
    {
        $this
            ->setupModel(new Timeline())
            ->setValidatorClass(TimelineRequest::class)
            ->add('name', 'text', [
                'label' => trans('plugins/research::timelines.name'),
                'required' => true,
                'attr' => [
                    'placeholder' => trans('plugins/research::timelines.name_placeholder'),
                    'data-counter' => 255,
                ],
            ])
            ->add('subtitle', 'text', [
                'label' => trans('plugins/research::timelines.subtitle'),
                'required' => false,
                'attr' => [
                    'placeholder' => trans('plugins/research::timelines.subtitle_placeholder'),
                    'data-counter' => 255,
                ],
            ])
            ->add('color', 'color', [
                'label' => trans('plugins/research::timelines.color'),
                'required' => false,
                'default_value' => '#000000',
            ])
            ->add('status', 'select', [
                'label' => trans('core/base::tables.status'),
                'required' => true,
                'choices' => BaseStatusEnum::labels(),
            ]);
    }
}
