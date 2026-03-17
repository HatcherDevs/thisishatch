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
use SharjahStore\Forms\ProductForm;
use SharjahStore\Http\Requests\ProductRequest;
use SharjahStore\Models\Product;
use SharjahStore\Tables\ProductTable;

class ProductController extends BaseController
{
    public function index(ProductTable $table)
    {
        $this->pageTitle(trans('plugins/sharjah-store::products.name'));

        return $table->renderTable();
    }

    public function create(FormBuilder $formBuilder)
    {
        $this->pageTitle(trans('plugins/sharjah-store::products.create'));

        return $formBuilder->create(ProductForm::class)->renderForm();
    }

    public function store(ProductRequest $request, BaseHttpResponse $response)
    {
        $data = $request->input();
        if (empty($data['slug']) && !empty($data['name'])) {
            $baseSlug = \Str::slug($data['name']);
            $slug = $baseSlug;
            $i = 1;
            while (\DB::table('store_products')->where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $i;
                $i++;
            }
            $data['slug'] = $slug;
        }
        $product = Product::query()->create($data);

        event(new CreatedContentEvent(STORE_PRODUCT_MODULE_SCREEN_NAME, $request, $product));

        return $response
            ->setPreviousUrl(route('store.products.index'))
            ->setNextUrl(route('store.products.edit', $product->getKey()))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(Product $product, FormBuilder $formBuilder, Request $request)
    {
        event(new BeforeEditContentEvent($request, $product));

        $this->pageTitle(trans('core/base::forms.edit_item', ['name' => $product->name]));

        return $formBuilder->create(ProductForm::class, ['model' => $product])->renderForm();
    }

    public function update(Product $product, ProductRequest $request, BaseHttpResponse $response)
    {
        $product->fill($request->input());
        $product->save();

        event(new UpdatedContentEvent(STORE_PRODUCT_MODULE_SCREEN_NAME, $request, $product));

        return $response
            ->setPreviousUrl(route('store.products.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(Product $product, Request $request, BaseHttpResponse $response)
    {
        try {
            $product->delete();

            event(new DeletedContentEvent(STORE_PRODUCT_MODULE_SCREEN_NAME, $request, $product));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }
}
