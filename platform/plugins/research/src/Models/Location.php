<?php

namespace Botble\Research\Models;

use Botble\Base\Casts\SafeContent;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Location extends BaseModel
{
    protected $table = 'research_locations';

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'image',
        'typology',
        'zone',
        'plot_area',
        'built_up_area',
        'timeline_id',
        'order',
        'status',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
        'title' => SafeContent::class,
        'subtitle' => SafeContent::class,
        'description' => SafeContent::class,
    ];

    public function timeline(): BelongsTo
    {
        return $this->belongsTo(Timeline::class, 'timeline_id');
    }
}
