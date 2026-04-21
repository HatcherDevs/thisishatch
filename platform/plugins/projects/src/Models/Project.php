<?php

namespace Botble\Projects\Models;

use Botble\Base\Casts\SafeContent;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends BaseModel
{
    protected $table = 'projects';

    protected $fillable = [
        'title',
        'image',
        'cover',
        'gallery_images',
        'videos',
        'year',
        'tagline',
        'description',
        'content',
        'category_id',
        'status',
        'highlight',
    ];

    protected $casts = [
        'title' => SafeContent::class,
        'year' => SafeContent::class,
        'tagline' => SafeContent::class,
        'description' => SafeContent::class,
        'content' => SafeContent::class,
        'gallery_images' => 'array',
        'videos' => 'array',
        'status' => BaseStatusEnum::class,
        'highlight' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProjectCategory::class, 'category_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(ProjectTag::class, 'project_project_tag', 'project_id', 'tag_id');
    }
}
