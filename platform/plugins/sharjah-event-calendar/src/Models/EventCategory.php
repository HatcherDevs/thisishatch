<?php

namespace Botble\SharjahEventCalendar\Models;

use Botble\Base\Casts\SafeContent;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventCategory extends BaseModel
{
    protected $table = 'event_categories';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'image',
        'icon',
        'order',
        'status',
        'is_featured',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
        'name' => SafeContent::class,
        'description' => SafeContent::class,
        'is_featured' => 'boolean',
    ];

    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'event_category_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(EventCategory::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(EventCategory::class, 'parent_id');
    }

    public function getUrlAttribute(): string
    {
        return route('public.events.category', $this->slug);
    }
}
