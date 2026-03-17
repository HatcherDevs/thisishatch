<?php

namespace Botble\SharjahEventCalendar\Http\Requests;

use Botble\Support\Http\Requests\Request;

class EventRegistrationRequest extends Request
{
    public function rules(): array
    {
        return [
            'event_id' => 'required|exists:events,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'registration_data' => 'nullable|array',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => trans('plugins/sharjah-event-calendar::registrations.form.name'),
            'email' => trans('plugins/sharjah-event-calendar::registrations.form.email'),
            'phone' => trans('plugins/sharjah-event-calendar::registrations.form.phone'),
        ];
    }
}
