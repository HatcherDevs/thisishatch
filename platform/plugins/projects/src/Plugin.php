<?php

namespace Botble\Projects;

use Botble\PluginManagement\Abstracts\PluginOperationAbstract;
use Illuminate\Support\Facades\Schema;

class Plugin extends PluginOperationAbstract
{
    public static function remove(): void
    {
        Schema::dropIfExists('project_project_tag');
        Schema::dropIfExists('project_tags');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('project_categories');
    }
}
