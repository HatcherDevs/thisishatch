<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('research_timelines') && !Schema::hasColumn('research_timelines', 'color')) {
            Schema::table('research_timelines', function (Blueprint $table) {
                $table->string('color', 20)->nullable()->after('subtitle');
            });
        }

        if (Schema::hasTable('research_locations') && !Schema::hasColumn('research_locations', 'typology')) {
            Schema::table('research_locations', function (Blueprint $table) {
                $table->string('typology', 255)->nullable()->after('description');
                $table->string('zone', 255)->nullable()->after('typology');
                $table->string('plot_area', 255)->nullable()->after('zone');
                $table->string('built_up_area', 255)->nullable()->after('plot_area');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('research_timelines', 'color')) {
            Schema::table('research_timelines', function (Blueprint $table) {
                $table->dropColumn('color');
            });
        }

        if (Schema::hasColumn('research_locations', 'typology')) {
            Schema::table('research_locations', function (Blueprint $table) {
                $table->dropColumn(['typology', 'zone', 'plot_area', 'built_up_area']);
            });
        }
    }
};
