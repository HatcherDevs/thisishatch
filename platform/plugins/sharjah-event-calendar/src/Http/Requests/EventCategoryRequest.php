<?php

namespace Botble\SharjahEventCalendar\Http\Requests;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class EventCategoryRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:400',
            'parent_id' => 'nullable|exists:event_categories,id',
            'image' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:100',
            'order' => 'nullable|integer|min:0',
            'status' => Rule::in(BaseStatusEnum::values()),
            'is_featured' => 'nullable|boolean',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => trans('core/base::forms.name'),
            'description' => trans('core/base::forms.description'),
            'parent_id' => trans('plugins/sharjah-event-calendar::categories.form.parent'),
            'image' => trans('core/base::forms.image'),
            'icon' => trans('plugins/sharjah-event-calendar::categories.form.icon'),
            'status' => trans('core/base::tables.status'),
        ];
    }
}
