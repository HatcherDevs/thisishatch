<?php

namespace Botble\SharjahEventCalendar\Models;

use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventRegistration extends BaseModel
{
    protected $table = 'event_registrations';

    // حماية من Mass Assignment - منع تعديل الحقول الحساسة
    protected $guarded = [
        'id',
        'status',              // لا يمكن تغيير الحالة مباشرة
        'confirmed_at',        // لا يمكن تأكيد التسجيل مباشرة
        'attended_at',         // لا يمكن تعديل الحضور مباشرة
        'registration_number', // رقم التسجيل يُنشأ تلقائياً
    ];

    protected $casts = [
        'registration_data' => 'array',
        'confirmed_at' => 'datetime',
        'attended_at' => 'datetime',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function approve(): void
    {
        $this->update([
            'status' => 'approved',
            'confirmed_at' => now(),
        ]);

        // Increment attendees count
        $this->event->increment('current_attendees');
    }

    public function reject(): void
    {
        $oldStatus = $this->status;

        $this->update(['status' => 'rejected']);

        // Decrement if was approved
        if ($oldStatus === 'approved') {
            $this->event->decrement('current_attendees');
        }
    }

    public function markAsAttended(): void
    {
        $this->update(['attended_at' => now()]);
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($registration) {
            if (empty($registration->registration_number)) {
                $registration->registration_number = 'REG-'.strtoupper(uniqid());
            }
        });
    }
}
