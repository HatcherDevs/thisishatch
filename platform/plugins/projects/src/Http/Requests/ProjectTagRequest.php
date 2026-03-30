<?php

namespace Botble\Projects\Http\Requests;

use Botble\Projects\Models\ProjectTag;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class ProjectTagRequest extends Request
{
    public function rules(): array
    {
        $tag = $this->route('tag');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique((new ProjectTag)->getTable(), 'name')->ignore($tag?->getKey()),
            ],
        ];
    }
}
