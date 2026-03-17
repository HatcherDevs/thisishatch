<?php

namespace SharjahStore\Http\Requests;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class CollectionRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'status' => [Rule::in(BaseStatusEnum::values())],
            'image' => ['nullable', 'string'],
        ];
    }
}
