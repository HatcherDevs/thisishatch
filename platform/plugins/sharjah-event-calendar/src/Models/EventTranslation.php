<?php

namespace Botble\SharjahEventCalendar\Models;

use Botble\Base\Models\BaseModel;

class EventTranslation extends BaseModel
{
    protected $table = 'events_translations';

    public $timestamps = false;

    protected $fillable = [
        'lang_code',
        'events_id',
        'name',
        'description',
        'content',
    ];
}
