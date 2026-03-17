<?php

namespace SharjahStore\Http\Requests;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class ProductRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'content' => ['nullable', 'string'],
            'down_row' => ['nullable', 'string'],
            'collection_id' => ['nullable', 'integer', 'exists:store_collections,id'],
            'status' => [Rule::in(BaseStatusEnum::values())],
            'image' => ['nullable', 'string'],
        ];
    }
}
