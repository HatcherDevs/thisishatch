<?php

namespace Botble\Projects\Models;

use Botble\Base\Casts\SafeContent;
use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProjectTag extends BaseModel
{
    protected $table = 'project_tags';

    protected $fillable = [
        'name',
    ];

    protected $casts = [
        'name' => SafeContent::class,
    ];

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'project_project_tag', 'tag_id', 'project_id');
    }
}
