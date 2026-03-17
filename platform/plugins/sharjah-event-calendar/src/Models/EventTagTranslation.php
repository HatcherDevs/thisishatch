<?php

namespace Botble\SharjahEventCalendar\Models;

use Botble\Base\Models\BaseModel;

class EventTagTranslation extends BaseModel
{
    protected $table = 'event_tags_translations';

    public $timestamps = false;

    protected $fillable = [
        'lang_code',
        'event_tags_id',
        'name',
        'description',
    ];
}
