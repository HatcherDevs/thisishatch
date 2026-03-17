<?php

namespace Botble\SharjahEventCalendar\Models;

use Botble\Base\Models\BaseModel;

class EventCategoryTranslation extends BaseModel
{
    protected $table = 'event_categories_translations';

    public $timestamps = false;

    protected $fillable = [
        'lang_code',
        'event_categories_id',
        'name',
        'description',
    ];
}
