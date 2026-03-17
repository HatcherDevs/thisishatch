<?php

namespace ArchiElite\SharjahRepository\Models;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;

class RepositoryItem extends BaseModel
{
    protected $table = 'repository_items';

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'image',
        'content',
        'status',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    public function category()
    {
        return $this->belongsTo(RepositoryCategory::class, 'category_id');
    }
}
