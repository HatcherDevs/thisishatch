<?php

namespace Botble\Projects\Http\Requests;

use Botble\Projects\Models\ProjectCategory;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class ProjectCategoryRequest extends Request
{
    public function rules(): array
    {
        $category = $this->route('category');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique((new ProjectCategory)->getTable(), 'name')->ignore($category?->getKey()),
            ],
        ];
    }
}
