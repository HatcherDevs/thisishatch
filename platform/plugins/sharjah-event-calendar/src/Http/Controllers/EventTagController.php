<?php

namespace Botble\SharjahEventCalendar\Http\Controllers;

use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\SharjahEventCalendar\Forms\EventTagForm;
use Botble\SharjahEventCalendar\Http\Requests\EventTagRequest;
use Botble\SharjahEventCalendar\Models\EventTag;
use Botble\SharjahEventCalendar\Tables\EventTagTable;
use Exception;
use Illuminate\Http\Request;

class EventTagController extends BaseController
{
    public function index(EventTagTable $table)
    {
        $this->pageTitle(trans('plugins/sharjah-event-calendar::tags.name'));

        return $table->renderTable();
    }

    public function create()
    {
        $this->pageTitle(trans('plugins/sharjah-event-calendar::tags.create'));

        return EventTagForm::create()->renderForm();
    }

    public function store(EventTagRequest $request, BaseHttpResponse $response)
    {
        $tag = EventTag::query()->create($request->validated());

        event(new CreatedContentEvent(EVENT_TAG_MODULE_SCREEN_NAME, $request, $tag));

        return $response
            ->setPreviousUrl(route('events.tags.index'))
            ->setNextUrl(route('events.tags.edit', $tag->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(EventTag $tag)
    {
        $this->pageTitle(trans('plugins/sharjah-event-calendar::tags.edit') . ' "' . $tag->name . '"');

        return EventTagForm::createFromModel($tag)->renderForm();
    }

    public function update(EventTag $tag, EventTagRequest $request, BaseHttpResponse $response)
    {
        $tag->update($request->validated());

        event(new UpdatedContentEvent(EVENT_TAG_MODULE_SCREEN_NAME, $request, $tag));

        return $response
            ->setPreviousUrl(route('events.tags.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(EventTag $tag, Request $request, BaseHttpResponse $response)
    {
        try {
            $tag->delete();

            event(new DeletedContentEvent(EVENT_TAG_MODULE_SCREEN_NAME, $request, $tag));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }
}
