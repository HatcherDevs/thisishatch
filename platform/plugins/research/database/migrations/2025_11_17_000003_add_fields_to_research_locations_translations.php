<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('research_locations_translations')) {
            if (!Schema::hasColumn('research_locations_translations', 'typology')) {
                Schema::table('research_locations_translations', function (Blueprint $table) {
                    $table->string('typology', 255)->nullable()->after('description');
                    $table->string('zone', 255)->nullable()->after('typology');
                    $table->string('plot_area', 255)->nullable()->after('zone');
                    $table->string('built_up_area', 255)->nullable()->after('plot_area');
                });
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('research_locations_translations')) {
            if (Schema::hasColumn('research_locations_translations', 'typology')) {
                Schema::table('research_locations_translations', function (Blueprint $table) {
                    $table->dropColumn(['typology', 'zone', 'plot_area', 'built_up_area']);
                });
            }
        }
    }
};
