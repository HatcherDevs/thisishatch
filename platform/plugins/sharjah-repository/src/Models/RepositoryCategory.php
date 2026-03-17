<?php

namespace ArchiElite\SharjahRepository\Models;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;

class RepositoryCategory extends BaseModel
{
    protected $table = 'repository_categories';

    protected $fillable = [
        'name',
        'status',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    public function repositories()
    {
        return $this->hasMany(RepositoryItem::class, 'category_id');
    }
}
