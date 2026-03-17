<?php

namespace Botble\SharjahEventCalendar\Http\Controllers;

use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\SharjahEventCalendar\Forms\EventLocationForm;
use Botble\SharjahEventCalendar\Http\Requests\EventLocationRequest;
use Botble\SharjahEventCalendar\Models\EventLocation;
use Botble\SharjahEventCalendar\Tables\EventLocationTable;
use Exception;
use Illuminate\Http\Request;

class EventLocationController extends BaseController
{
    public function index(EventLocationTable $table)
    {
        $this->pageTitle(trans('plugins/sharjah-event-calendar::locations.name'));

        return $table->renderTable();
    }

    public function create()
    {
        $this->pageTitle(trans('plugins/sharjah-event-calendar::locations.create'));

        return EventLocationForm::create()->renderForm();
    }

    public function store(EventLocationRequest $request, BaseHttpResponse $response)
    {
        $location = EventLocation::query()->create($request->validated());

        event(new CreatedContentEvent(EVENT_LOCATION_MODULE_SCREEN_NAME, $request, $location));

        return $response
            ->setPreviousUrl(route('events.locations.index'))
            ->setNextUrl(route('events.locations.edit', $location->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(EventLocation $location)
    {
        $this->pageTitle(trans('plugins/sharjah-event-calendar::locations.edit') . ' "' . $location->name . '"');

        return EventLocationForm::createFromModel($location)->renderForm();
    }

    public function update(EventLocation $location, EventLocationRequest $request, BaseHttpResponse $response)
    {
        $location->update($request->validated());

        event(new UpdatedContentEvent(EVENT_LOCATION_MODULE_SCREEN_NAME, $request, $location));

        return $response
            ->setPreviousUrl(route('events.locations.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(EventLocation $location, Request $request, BaseHttpResponse $response)
    {
        try {
            $location->delete();

            event(new DeletedContentEvent(EVENT_LOCATION_MODULE_SCREEN_NAME, $request, $location));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }
}
