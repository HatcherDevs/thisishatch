<?php

namespace Botble\Research\Models;

use Botble\Base\Casts\SafeContent;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Timeline extends BaseModel
{
    protected $table = 'research_timelines';

    protected $fillable = [
        'name',
        'subtitle',
        'description',
        'color',
        'order',
        'status',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
        'name' => SafeContent::class,
        'subtitle' => SafeContent::class,
        'description' => SafeContent::class,
    ];

    public function locations(): HasMany
    {
        return $this->hasMany(Location::class, 'timeline_id');
    }
}
