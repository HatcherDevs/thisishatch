<?php

namespace ArchiElite\SharjahRepository;

use Botble\PluginManagement\Abstracts\PluginOperationAbstract;
use Illuminate\Support\Facades\Schema;

class Plugin extends PluginOperationAbstract
{
    public static function remove(): void
    {
        Schema::dropIfExists('repository_items');
        Schema::dropIfExists('repository_items_translations');
        Schema::dropIfExists('repository_categories');
        Schema::dropIfExists('repository_categories_translations');
    }
}
