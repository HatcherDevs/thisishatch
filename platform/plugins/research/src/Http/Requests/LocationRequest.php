<?php

namespace Botble\Research\Http\Requests;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class LocationRequest extends Request
{
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:5000',
            'typology' => 'nullable|string|max:255',
            'zone' => 'nullable|string|max:255',
            'plot_area' => 'nullable|string|max:255',
            'built_up_area' => 'nullable|string|max:255',
            'timeline_id' => 'required|exists:research_timelines,id',
            'image' => 'required|string|max:255',
            'order' => 'nullable|integer|min:0',
            'status' => Rule::in(BaseStatusEnum::values()),
        ];
    }
}
