<?php

namespace Botble\Research\Http\Controllers;

use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Research\Forms\LocationForm;
use Botble\Research\Http\Requests\LocationRequest;
use Botble\Research\Models\Location;
use Botble\Research\Tables\LocationTable;
use Exception;
use Illuminate\Http\Request;

class LocationController extends BaseController
{
    public function index(LocationTable $table)
    {
        $this->pageTitle(trans('plugins/research::locations.name'));

        return $table->renderTable();
    }

    public function create()
    {
        $this->pageTitle(trans('plugins/research::locations.create'));

        return LocationForm::create()->renderForm();
    }

    public function store(LocationRequest $request, BaseHttpResponse $response)
    {
        $location = Location::query()->create($request->validated());

        event(new CreatedContentEvent('RESEARCH_LOCATION', $request, $location));

        return $response
            ->setPreviousUrl(route('research.locations.index'))
            ->setNextUrl(route('research.locations.edit', $location->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(Location $location)
    {
        $this->pageTitle(trans('plugins/research::locations.edit') . ' "' . $location->title . '"');

        return LocationForm::createFromModel($location)->renderForm();
    }

    public function update(Location $location, LocationRequest $request, BaseHttpResponse $response)
    {
        $location->update($request->validated());

        event(new UpdatedContentEvent('RESEARCH_LOCATION', $request, $location));

        return $response
            ->setPreviousUrl(route('research.locations.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(Location $location, Request $request, BaseHttpResponse $response)
    {
        try {
            $location->delete();

            event(new DeletedContentEvent('RESEARCH_LOCATION', $request, $location));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }
}
