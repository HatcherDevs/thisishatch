<?php

namespace Botble\Research\Http\Requests;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class TimelineRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'color' => 'nullable|string|max:20',
            'order' => 'nullable|integer|min:0',
            'status' => Rule::in(BaseStatusEnum::values()),
        ];
    }
}
