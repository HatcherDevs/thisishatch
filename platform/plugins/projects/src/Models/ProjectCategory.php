<?php

namespace Botble\Projects\Models;

use Botble\Base\Casts\SafeContent;
use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectCategory extends BaseModel
{
    protected $table = 'project_categories';

    protected $fillable = [
        'name',
    ];

    protected $casts = [
        'name' => SafeContent::class,
    ];

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'category_id');
    }
}
