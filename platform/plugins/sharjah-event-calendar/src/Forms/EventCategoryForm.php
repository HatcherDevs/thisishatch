<?php

namespace Botble\SharjahEventCalendar\Forms;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Forms\FormAbstract;
use Botble\SharjahEventCalendar\Http\Requests\EventCategoryRequest;
use Botble\SharjahEventCalendar\Models\EventCategory;

class EventCategoryForm extends FormAbstract
{
    public function buildForm(): void
    {
        $parentCategories = EventCategory::query()
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->pluck('name', 'id')
            ->all();

        if ($this->getModel()) {
            $parentCategories = array_filter($parentCategories, function ($key) {
                return $key != $this->getModel()->id;
            }, ARRAY_FILTER_USE_KEY);
        }

        $this
            ->setupModel(new EventCategory)
            ->setValidatorClass(EventCategoryRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label' => trans('plugins/sharjah-event-calendar::categories.name'),
                'required' => true,
                'attr' => [
                    'placeholder' => trans('plugins/sharjah-event-calendar::categories.name'),
                    'data-counter' => 120,
                ],
            ])
            ->add('parent_id', 'select', [
                'label' => trans('plugins/sharjah-event-calendar::categories.parent'),
                'required' => false,
                'choices' => [0 => trans('plugins/sharjah-event-calendar::categories.none')] + $parentCategories,
                'attr' => [
                    'class' => 'form-control select-search-full',
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
