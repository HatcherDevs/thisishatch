<?php

namespace Botble\SharjahEventCalendar\Models;

use Botble\Base\Models\BaseModel;

class EventLocationTranslation extends BaseModel
{
    protected $table = 'event_locations_translations';

    public $timestamps = false;

    protected $fillable = [
        'lang_code',
        'event_locations_id',
        'name',
        'description',
        'address',
        'city',
    ];
}
