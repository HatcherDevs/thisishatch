<?php

namespace Botble\Research\Forms;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Forms\FormAbstract;
use Botble\Research\Http\Requests\LocationRequest;
use Botble\Research\Models\Location;
use Botble\Research\Models\Timeline;

class LocationForm extends FormAbstract
{
    public function buildForm(): void
    {
        $timelines = Timeline::query()
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->orderBy('order')
            ->pluck('name', 'id')
            ->all();

        $this
            ->setupModel(new Location())
            ->setValidatorClass(LocationRequest::class)
            ->withCustomFields()
            ->add('title', 'text', [
                'label' => trans('plugins/research::locations.title'),
                'required' => true,
                'attr' => [
                    'placeholder' => trans('plugins/research::locations.title_placeholder'),
                    'data-counter' => 255,
                ],
            ])
            ->add('subtitle', 'text', [
                'label' => trans('plugins/research::locations.subtitle'),
                'required' => false,
                'attr' => [
                    'placeholder' => trans('plugins/research::locations.subtitle_placeholder'),
                    'data-counter' => 255,
                ],
            ])
            ->add('description', 'editor', [
                'label' => trans('core/base::forms.description'),
                'required' => false,
                'attr' => [
                    'placeholder' => trans('core/base::forms.description_placeholder'),
                    'with-short-code' => true,
                ],
            ])
            ->add('typology', 'text', [
                'label' => trans('plugins/research::locations.typology'),
                'required' => false,
                'attr' => [
                    'placeholder' => trans('plugins/research::locations.typology_placeholder'),
                ],
            ])
            ->add('zone', 'text', [
                'label' => trans('plugins/research::locations.zone'),
                'required' => false,
                'attr' => [
                    'placeholder' => trans('plugins/research::locations.zone_placeholder'),
                ],
            ])
            ->add('plot_area', 'text', [
                'label' => trans('plugins/research::locations.plot_area'),
                'required' => false,
                'attr' => [
                    'placeholder' => trans('plugins/research::locations.plot_area_placeholder'),
                ],
            ])
            ->add('built_up_area', 'text', [
                'label' => trans('plugins/research::locations.built_up_area'),
                'required' => false,
                'attr' => [
                    'placeholder' => trans('plugins/research::locations.built_up_area_placeholder'),
                ],
            ])
            ->add('status', 'select', [
                'label' => trans('core/base::tables.status'),
                'required' => true,
                'choices' => BaseStatusEnum::labels(),
            ])
            ->add('timeline_id', 'select', [
                'label' => trans('plugins/research::locations.timeline'),
                'required' => true,
                'choices' => ['' => trans('plugins/research::locations.select_timeline')] + $timelines,
                'attr' => [
                    'class' => 'form-control select-search-full',
                ],
            ])
            ->add('image', 'mediaImage', [
                'label' => trans('core/base::forms.image'),
                'required' => true,
            ])
            ->setBreakFieldPoint('status');
    }
}
