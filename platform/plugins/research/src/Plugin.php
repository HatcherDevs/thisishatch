<?php

namespace Botble\Research;

use Botble\PluginManagement\Abstracts\PluginOperationAbstract;
use Illuminate\Support\Facades\Schema;

class Plugin extends PluginOperationAbstract
{
    public static function remove(): void
    {
        Schema::dropIfExists('research_locations_translations');
        Schema::dropIfExists('research_locations');
        Schema::dropIfExists('research_timelines_translations');
        Schema::dropIfExists('research_timelines');
    }
}
