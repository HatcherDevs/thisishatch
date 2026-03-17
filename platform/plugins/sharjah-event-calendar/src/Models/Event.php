<?php

namespace Botble\SharjahEventCalendar\Models;

use Botble\Base\Casts\SafeContent;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends BaseModel
{
    protected $table = 'events';

    // حماية من Mass Assignment - منع تعديل الحقول الحساسة
    protected $guarded = [
        'id',
        'current_attendees',   // يُحدّث تلقائياً عند التسجيل
        'slug',                // يُنشأ تلقائياً من الاسم
    ];

    // الحقول المسموح بها للتعبئة
    protected $fillable = [
        'name',
        'description',
        'content',
        'image',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'event_category_id',
        'event_location_id',
        'status',
        'has_registration',
        'registration_deadline',
        'max_attendees',
        'registration_fields',
        'auto_approve_registration',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
        'name' => SafeContent::class,
        'description' => SafeContent::class,
        'has_registration' => 'boolean',
        'auto_approve_registration' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
        'registration_deadline' => 'datetime',
        'registration_fields' => 'array',
        'current_attendees' => 'integer',
        'max_attendees' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(EventCategory::class, 'event_category_id');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(EventLocation::class, 'event_location_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(EventTag::class, 'event_tag', 'event_id', 'tag_id');
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class, 'event_id');
    }

    public function approvedRegistrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class, 'event_id')->where('status', 'approved');
    }

    public function getUrlAttribute(): string
    {
        return route('public.events.detail', $this->slug);
    }

    public function isFull(): bool
    {
        if (! $this->max_attendees) {
            return false;
        }

        return $this->current_attendees >= $this->max_attendees;
    }

    public function canRegister(): bool
    {
        if (! $this->has_registration) {
            return false;
        }

        if ($this->isFull()) {
            return false;
        }

        if ($this->registration_deadline && now()->greaterThan($this->registration_deadline)) {
            return false;
        }

        return true;
    }
}
