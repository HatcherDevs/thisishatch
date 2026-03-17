<?php

namespace SharjahStore\Http\Controllers;

use Botble\Base\Events\BeforeEditContentEvent;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Forms\FormBuilder;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Exception;
use Illuminate\Http\Request;
use SharjahStore\Forms\CollectionForm;
use SharjahStore\Http\Requests\CollectionRequest;
use SharjahStore\Models\Collection;
use SharjahStore\Tables\CollectionTable;

class CollectionController extends BaseController
{
    public function index(CollectionTable $table)
    {
        $this->pageTitle(trans('plugins/sharjah-store::collections.name'));

        return $table->renderTable();
    }

    public function create(FormBuilder $formBuilder)
    {
        $this->pageTitle(trans('plugins/sharjah-store::collections.create'));

        return $formBuilder->create(CollectionForm::class)->renderForm();
    }

    public function store(CollectionRequest $request, BaseHttpResponse $response)
    {
        $data = $request->input();
        if (empty($data['slug']) && !empty($data['name'])) {
            $baseSlug = \Str::slug($data['name']);
            $slug = $baseSlug;
            $i = 1;
            while (\DB::table('store_collections')->where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $i;
                $i++;
            }
            $data['slug'] = $slug;
        }
        $collection = Collection::query()->create($data);

        event(new CreatedContentEvent(STORE_COLLECTION_MODULE_SCREEN_NAME, $request, $collection));

        return $response
            ->setPreviousUrl(route('store.collections.index'))
            ->setNextUrl(route('store.collections.edit', $collection->getKey()))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(Collection $collection, FormBuilder $formBuilder, Request $request)
    {
        event(new BeforeEditContentEvent($request, $collection));

        $this->pageTitle(trans('core/base::forms.edit_item', ['name' => $collection->name]));

        return $formBuilder->create(CollectionForm::class, ['model' => $collection])->renderForm();
    }

    public function update(Collection $collection, CollectionRequest $request, BaseHttpResponse $response)
    {
        $collection->fill($request->input());
        $collection->save();

        event(new UpdatedContentEvent(STORE_COLLECTION_MODULE_SCREEN_NAME, $request, $collection));

        return $response
            ->setPreviousUrl(route('store.collections.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(Collection $collection, Request $request, BaseHttpResponse $response)
    {
        try {
            $collection->delete();

            event(new DeletedContentEvent(STORE_COLLECTION_MODULE_SCREEN_NAME, $request, $collection));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }
}
