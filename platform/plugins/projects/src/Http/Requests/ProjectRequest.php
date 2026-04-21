<?php

namespace Botble\Projects\Http\Requests;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class ProjectRequest extends Request
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'string', 'max:255'],
            'cover' => ['nullable', 'string', 'max:255'],
            'gallery_images' => ['nullable', 'array'],
            'gallery_images.*' => ['nullable', 'string', 'max:255'],
            'videos_json' => ['nullable', 'string'],
            'videos' => ['nullable', 'array'],
            'year' => ['nullable', 'string', 'max:10'],
            'tagline' => ['nullable', 'string', 'max:65000'],
            'description' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'category_id' => ['nullable', Rule::exists('project_categories', 'id')],
            'tag_names' => ['nullable'],
            'status' => Rule::in(BaseStatusEnum::values()),
            'highlight' => ['nullable', 'boolean'],
        ];
    }
}
