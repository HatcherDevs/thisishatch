<?php

namespace Botble\SharjahEventCalendar\Http\Requests;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class EventLocationRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:400',
            'address' => 'nullable|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'image' => 'nullable|string|max:255',
            'capacity' => 'nullable|integer|min:1',
            'status' => Rule::in(BaseStatusEnum::values()),
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => trans('core/base::forms.name'),
            'description' => trans('core/base::forms.description'),
            'address' => trans('plugins/sharjah-event-calendar::locations.form.address'),
            'latitude' => trans('plugins/sharjah-event-calendar::locations.form.latitude'),
            'longitude' => trans('plugins/sharjah-event-calendar::locations.form.longitude'),
            'city' => trans('plugins/sharjah-event-calendar::locations.form.city'),
            'country' => trans('plugins/sharjah-event-calendar::locations.form.country'),
            'phone' => trans('plugins/sharjah-event-calendar::locations.form.phone'),
            'email' => trans('plugins/sharjah-event-calendar::locations.form.email'),
            'website' => trans('plugins/sharjah-event-calendar::locations.form.website'),
            'capacity' => trans('plugins/sharjah-event-calendar::locations.form.capacity'),
            'status' => trans('core/base::tables.status'),
        ];
    }
}
