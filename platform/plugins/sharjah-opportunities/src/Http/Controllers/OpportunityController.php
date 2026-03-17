<?php

namespace SharjahOpportunities\Http\Controllers;

use Botble\Base\Events\BeforeEditContentEvent;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Forms\FormBuilder;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Base\Tables\TableBuilder;
use Exception;
use Illuminate\Http\Request;
use SharjahOpportunities\Forms\OpportunityForm;
use SharjahOpportunities\Http\Requests\OpportunityRequest;
use SharjahOpportunities\Models\Opportunity;
use SharjahOpportunities\Tables\OpportunityTable;

class OpportunityController extends BaseController
{
    public function index(OpportunityTable $table)
    {
        $this->pageTitle(trans('plugins/sharjah-opportunities::opportunities.name'));

        return $table->renderTable();
    }

    public function create(FormBuilder $formBuilder)
    {
        $this->pageTitle(trans('plugins/sharjah-opportunities::opportunities.create'));

        return $formBuilder->create(OpportunityForm::class)->renderForm();
    }

    public function store(OpportunityRequest $request, BaseHttpResponse $response)
    {
        $data = $request->input();
        if (empty($data['slug']) && !empty($data['name'])) {
            $baseSlug = \Str::slug($data['name']);
            $slug = $baseSlug;
            $i = 1;
            while (\DB::table('opportunities')->where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $i;
                $i++;
            }
            $data['slug'] = $slug;
        }
        $opportunity = Opportunity::query()->create($data);

        event(new CreatedContentEvent(OPPORTUNITY_MODULE_SCREEN_NAME, $request, $opportunity));

        return $response
            ->setPreviousUrl(route('opportunities.index'))
            ->setNextUrl(route('opportunities.edit', $opportunity->getKey()))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function show(Opportunity $opportunity)
    {
        $this->pageTitle($opportunity->name);

        return view('plugins/sharjah-opportunities::opportunities.show', compact('opportunity'));
    }

    public function edit(Opportunity $opportunity, FormBuilder $formBuilder, Request $request)
    {
        event(new BeforeEditContentEvent($request, $opportunity));

        $this->pageTitle(trans('core/base::forms.edit_item', ['name' => $opportunity->name]));

        return $formBuilder->create(OpportunityForm::class, ['model' => $opportunity])->renderForm();
    }

    public function update(Opportunity $opportunity, OpportunityRequest $request, BaseHttpResponse $response)
    {
        $opportunity->fill($request->input());
        $opportunity->save();

        event(new UpdatedContentEvent(OPPORTUNITY_MODULE_SCREEN_NAME, $request, $opportunity));

        return $response
            ->setPreviousUrl(route('opportunities.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(Opportunity $opportunity, Request $request, BaseHttpResponse $response)
    {
        try {
            $opportunity->delete();

            event(new DeletedContentEvent(OPPORTUNITY_MODULE_SCREEN_NAME, $request, $opportunity));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }
}
