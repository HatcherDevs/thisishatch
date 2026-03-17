<?php

namespace Botble\SharjahEventCalendar\Models;

use Botble\Base\Casts\SafeContent;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventLocation extends BaseModel
{
    protected $table = 'event_locations';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'address',
        'latitude',
        'longitude',
        'city',
        'country',
        'phone',
        'email',
        'website',
        'image',
        'capacity',
        'status',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
        'name' => SafeContent::class,
        'description' => SafeContent::class,
        'address' => SafeContent::class,
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'capacity' => 'integer',
    ];

    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'event_location_id');
    }

    public function getUrlAttribute(): string
    {
        return route('public.events.location', $this->slug);
    }

    public function hasCoordinates(): bool
    {
        return !empty($this->latitude) && !empty($this->longitude);
    }
}
