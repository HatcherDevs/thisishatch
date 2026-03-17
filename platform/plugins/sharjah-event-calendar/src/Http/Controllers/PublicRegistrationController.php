<?php

namespace Botble\SharjahEventCalendar\Http\Controllers;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Http\Controllers\BaseController;
use Botble\SharjahEventCalendar\Enums\RegistrationStatusEnum;
use Botble\SharjahEventCalendar\Models\Event;
use Botble\SharjahEventCalendar\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PublicRegistrationController extends BaseController
{
    public function store(Request $request, string $slug)
    {
        // إصلاح IDOR: استخدام الـ slug المُمرر
        $event = Event::query()
            ->where('slug', $slug)
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->firstOrFail();

        // Check if registration is enabled
        if (! $event->has_registration) {
            return redirect()
                ->back()
                ->with('error', trans('plugins/sharjah-event-calendar::events.messages.registration_disabled'));
        }

        // Check if registration is still open
        if (! $event->canRegister()) {
            return redirect()
                ->back()
                ->with('error', trans('plugins/sharjah-event-calendar::events.messages.registration_closed'));
        }

        // Check if event is full
        if ($event->isFull()) {
            return redirect()
                ->back()
                ->with('error', trans('plugins/sharjah-event-calendar::events.messages.event_full'));
        }

        // Validate request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        // Check if user already registered
        $existingRegistration = EventRegistration::query()
            ->where('event_id', $event->id)
            ->where('email', $validated['email'])
            ->first();

        if ($existingRegistration) {
            return redirect()
                ->back()
                ->with('error', trans('plugins/sharjah-event-calendar::events.messages.already_registered'));
        }

        // Create registration
        $registration = new EventRegistration;
        $registration->event_id = $event->id;
        $registration->registration_number = 'REG-'.strtoupper(Str::random(10));
        $registration->name = $validated['name'];
        $registration->email = $validated['email'];
        $registration->phone = $validated['phone'] ?? null;
        $registration->registration_data = [];
        $registration->status = $event->auto_approve_registration
            ? RegistrationStatusEnum::APPROVED
            : RegistrationStatusEnum::PENDING;
        $registration->ip_address = $request->ip();
        $registration->user_agent = $request->userAgent();
        $registration->save();

        $message = $event->auto_approve_registration
            ? trans('plugins/sharjah-event-calendar::events.messages.registration_success')
            : trans('plugins/sharjah-event-calendar::events.messages.registration_pending');

        return redirect()
            ->back()
            ->with('success', $message);
    }
}
