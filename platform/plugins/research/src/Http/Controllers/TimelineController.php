<?php

namespace Botble\Research\Http\Controllers;

use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Research\Forms\TimelineForm;
use Botble\Research\Http\Requests\TimelineRequest;
use Botble\Research\Models\Timeline;
use Botble\Research\Tables\TimelineTable;
use Exception;
use Illuminate\Http\Request;

class TimelineController extends BaseController
{
    public function index(TimelineTable $table)
    {
        $this->pageTitle(trans('plugins/research::timelines.name'));

        return $table->renderTable();
    }

    public function create()
    {
        $this->pageTitle(trans('plugins/research::timelines.create'));

        return TimelineForm::create()->renderForm();
    }

    public function store(TimelineRequest $request, BaseHttpResponse $response)
    {
        $timeline = Timeline::query()->create($request->validated());

        event(new CreatedContentEvent('RESEARCH_TIMELINE', $request, $timeline));

        return $response
            ->setPreviousUrl(route('research.timelines.index'))
            ->setNextUrl(route('research.timelines.edit', $timeline->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(Timeline $timeline)
    {
        $this->pageTitle(trans('plugins/research::timelines.edit') . ' "' . $timeline->name . '"');

        return TimelineForm::createFromModel($timeline)->renderForm();
    }

    public function update(Timeline $timeline, TimelineRequest $request, BaseHttpResponse $response)
    {
        $timeline->update($request->validated());

        event(new UpdatedContentEvent('RESEARCH_TIMELINE', $request, $timeline));

        return $response
            ->setPreviousUrl(route('research.timelines.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(Timeline $timeline, Request $request, BaseHttpResponse $response)
    {
        try {
            $timeline->delete();

            event(new DeletedContentEvent('RESEARCH_TIMELINE', $request, $timeline));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }
}
