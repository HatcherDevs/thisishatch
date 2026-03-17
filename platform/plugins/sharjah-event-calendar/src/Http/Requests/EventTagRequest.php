<?php

namespace Botble\SharjahEventCalendar\Http\Requests;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class EventTagRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:400',
            'status' => Rule::in(BaseStatusEnum::values()),
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => trans('core/base::forms.name'),
            'description' => trans('core/base::forms.description'),
            'status' => trans('core/base::tables.status'),
        ];
    }
}
