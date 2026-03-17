<?php

namespace SharjahOpportunities\Http\Requests;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class OpportunityRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:400',
            'content' => 'nullable|string',
            'image' => 'nullable|string',
            'status' => Rule::in(BaseStatusEnum::values()),
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => trans('plugins/sharjah-opportunities::opportunities.form.name'),
            'permalink' => trans('plugins/sharjah-opportunities::opportunities.form.permalink'),
            'description' => trans('plugins/sharjah-opportunities::opportunities.form.description'),
            'content' => trans('plugins/sharjah-opportunities::opportunities.form.content'),
            'image' => trans('plugins/sharjah-opportunities::opportunities.form.image'),
            'status' => trans('core/base::tables.status'),
        ];
    }
}
