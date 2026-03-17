<?php

namespace Botble\SharjahEventCalendar\Models;

use Botble\Base\Casts\SafeContent;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class EventTag extends BaseModel
{
    protected $table = 'event_tags';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'status',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
        'name' => SafeContent::class,
        'description' => SafeContent::class,
    ];

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_tag', 'tag_id', 'event_id');
    }

    public function getUrlAttribute(): string
    {
        return route('public.events.tag', $this->slug);
    }
}
