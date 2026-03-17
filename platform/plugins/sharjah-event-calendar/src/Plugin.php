<?php

namespace Botble\SharjahEventCalendar;

use Botble\PluginManagement\Abstracts\PluginOperationAbstract;
use Illuminate\Support\Facades\Schema;

class Plugin extends PluginOperationAbstract
{
    public static function remove(): void
    {
        Schema::dropIfExists('event_registrations');
        Schema::dropIfExists('event_tag');
        Schema::dropIfExists('events_translations');
        Schema::dropIfExists('events');
        Schema::dropIfExists('event_locations_translations');
        Schema::dropIfExists('event_locations');
        Schema::dropIfExists('event_tags_translations');
        Schema::dropIfExists('event_tags');
        Schema::dropIfExists('event_categories_translations');
        Schema::dropIfExists('event_categories');
    }
}
