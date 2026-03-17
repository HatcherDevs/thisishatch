<?php

namespace Botble\SharjahEventCalendar\Http\Controllers;

use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\SharjahEventCalendar\Forms\EventForm;
use Botble\SharjahEventCalendar\Http\Requests\EventRequest;
use Botble\SharjahEventCalendar\Models\Event;
use Botble\SharjahEventCalendar\Tables\EventTable;
use Exception;
use Illuminate\Http\Request;

class EventController extends BaseController
{
    public function index(EventTable $table)
    {
        $this->pageTitle(trans('plugins/sharjah-event-calendar::events.name'));

        return $table->renderTable();
    }

    public function create()
    {
        $this->pageTitle(trans('plugins/sharjah-event-calendar::events.create'));

        return EventForm::create()->renderForm();
    }

    public function store(EventRequest $request, BaseHttpResponse $response)
    {
        $data = $request->validated();

        // Handle empty date/time fields - set to null if empty or invalid
        foreach (['start_date', 'end_date', 'registration_deadline'] as $field) {
            if (isset($data[$field])) {
                $value = trim($data[$field]);
                if ($value === '' || $value === 'Invalid date' || empty($value)) {
                    $data[$field] = null;
                }
            }
        }

        foreach (['start_time', 'end_time'] as $field) {
            if (isset($data[$field])) {
                $value = trim($data[$field]);
                if ($value === '' || $value === '00:00' || empty($value)) {
                    $data[$field] = null;
                }
            }
        }

        // Handle registration fields JSON
        if ($request->has('registration_fields')) {
            $data['registration_fields'] = $request->input('registration_fields');
        }

        $event = Event::query()->create($data);

        // Sync tags
        if ($request->has('tags')) {
            $event->tags()->sync($request->input('tags', []));
        }

        event(new CreatedContentEvent(EVENT_MODULE_SCREEN_NAME, $request, $event));

        return $response
            ->setPreviousUrl(route('events.index'))
            ->setNextUrl(route('events.edit', $event->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(Event $event)
    {
        $this->pageTitle(trans('plugins/sharjah-event-calendar::events.edit') . ' "' . $event->name . '"');

        return EventForm::createFromModel($event)->renderForm();
    }

    public function update(Event $event, EventRequest $request, BaseHttpResponse $response)
    {
        $data = $request->validated();

        // Handle empty date/time fields - set to null if empty or invalid
        foreach (['start_date', 'end_date', 'registration_deadline'] as $field) {
            if (isset($data[$field])) {
                $value = trim($data[$field]);
                if ($value === '' || $value === 'Invalid date' || empty($value)) {
                    $data[$field] = null;
                }
            }
        }

        foreach (['start_time', 'end_time'] as $field) {
            if (isset($data[$field])) {
                $value = trim($data[$field]);
                if ($value === '' || $value === '00:00' || empty($value)) {
                    $data[$field] = null;
                }
            }
        }

        // Handle registration fields JSON
        if ($request->has('registration_fields')) {
            $data['registration_fields'] = $request->input('registration_fields');
        }

        $event->update($data);

        // Sync tags
        if ($request->has('tags')) {
            $event->tags()->sync($request->input('tags', []));
        }

        event(new UpdatedContentEvent(EVENT_MODULE_SCREEN_NAME, $request, $event));

        return $response
            ->setPreviousUrl(route('events.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(Event $event, Request $request, BaseHttpResponse $response)
    {
        try {
            $event->delete();

            event(new DeletedContentEvent(EVENT_MODULE_SCREEN_NAME, $request, $event));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }
}
