<?php

namespace Botble\SharjahEventCalendar\Http\Controllers;

use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\SharjahEventCalendar\Forms\EventCategoryForm;
use Botble\SharjahEventCalendar\Http\Requests\EventCategoryRequest;
use Botble\SharjahEventCalendar\Models\EventCategory;
use Botble\SharjahEventCalendar\Tables\EventCategoryTable;
use Exception;
use Illuminate\Http\Request;

class EventCategoryController extends BaseController
{
    public function index(EventCategoryTable $table)
    {
        $this->pageTitle(trans('plugins/sharjah-event-calendar::categories.name'));

        return $table->renderTable();
    }

    public function create()
    {
        $this->pageTitle(trans('plugins/sharjah-event-calendar::categories.create'));

        return EventCategoryForm::create()->renderForm();
    }

    public function store(EventCategoryRequest $request, BaseHttpResponse $response)
    {
        $category = EventCategory::query()->create($request->validated());

        event(new CreatedContentEvent(EVENT_CATEGORY_MODULE_SCREEN_NAME, $request, $category));

        return $response
            ->setPreviousUrl(route('events.categories.index'))
            ->setNextUrl(route('events.categories.edit', $category->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(EventCategory $category)
    {
        $this->pageTitle(trans('plugins/sharjah-event-calendar::categories.edit') . ' "' . $category->name . '"');

        return EventCategoryForm::createFromModel($category)->renderForm();
    }

    public function update(EventCategory $category, EventCategoryRequest $request, BaseHttpResponse $response)
    {
        $category->update($request->validated());

        event(new UpdatedContentEvent(EVENT_CATEGORY_MODULE_SCREEN_NAME, $request, $category));

        return $response
            ->setPreviousUrl(route('events.categories.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(EventCategory $category, Request $request, BaseHttpResponse $response)
    {
        try {
            $category->delete();

            event(new DeletedContentEvent(EVENT_CATEGORY_MODULE_SCREEN_NAME, $request, $category));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }
}
