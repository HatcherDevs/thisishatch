<?php

namespace Botble\SharjahEventCalendar\Http\Requests;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class EventRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:400',
            'content' => 'nullable|string',
            'image' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'event_category_id' => 'nullable|exists:event_categories,id',
            'event_location_id' => 'nullable|exists:event_locations,id',
            'status' => Rule::in(BaseStatusEnum::values()),
            'tags' => 'nullable|array',
            'tags.*' => 'exists:event_tags,id',

            // Registration fields
            'has_registration' => 'nullable|boolean',
            'registration_deadline' => 'nullable|date',
            'max_attendees' => 'nullable|integer|min:1',
            'registration_fields' => 'nullable|json',
            'auto_approve_registration' => 'nullable|boolean',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => trans('plugins/sharjah-event-calendar::events.form.name'),
            'description' => trans('plugins/sharjah-event-calendar::events.form.description'),
            'content' => trans('plugins/sharjah-event-calendar::events.form.content'),
            'image' => trans('core/base::forms.image'),
            'start_date' => trans('plugins/sharjah-event-calendar::events.form.start_date'),
            'end_date' => trans('plugins/sharjah-event-calendar::events.form.end_date'),
            'start_time' => trans('plugins/sharjah-event-calendar::events.form.start_time'),
            'end_time' => trans('plugins/sharjah-event-calendar::events.form.end_time'),
            'event_category_id' => trans('plugins/sharjah-event-calendar::events.form.category'),
            'event_location_id' => trans('plugins/sharjah-event-calendar::events.form.location'),
            'status' => trans('core/base::tables.status'),
        ];
    }
}
