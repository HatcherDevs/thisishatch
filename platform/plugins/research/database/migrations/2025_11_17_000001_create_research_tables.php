<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Research Timelines Table (Categories with time periods)
        if (!Schema::hasTable('research_timelines')) {
            Schema::create('research_timelines', function (Blueprint $table) {
                $table->id();
                $table->string('name', 255); // e.g., "Pre-1960", "1960-1980"
                $table->string('subtitle', 255)->nullable(); // e.g., "Early development phase"
                $table->text('description')->nullable();
                $table->string('color', 20)->nullable(); // Color picker
                $table->integer('order')->default(0);
                $table->string('status', 60)->default('published'); // published or draft
                $table->timestamps();

                $table->index(['status', 'order']);
            });
        }

        // Research Timelines Translations
        if (!Schema::hasTable('research_timelines_translations')) {
            Schema::create('research_timelines_translations', function (Blueprint $table) {
                $table->string('lang_code', 20);
                $table->foreignId('research_timelines_id')->constrained('research_timelines')->onDelete('cascade');
                $table->string('name', 255)->nullable();
                $table->string('subtitle', 255)->nullable();
                $table->text('description')->nullable();

                $table->primary(['lang_code', 'research_timelines_id'], 'research_timelines_translations_primary');
            });
        }

        // Research Locations Table
        if (!Schema::hasTable('research_locations')) {
            Schema::create('research_locations', function (Blueprint $table) {
                $table->id();
                $table->string('title', 255);
                $table->string('subtitle', 255)->nullable();
                $table->text('description')->nullable();
                $table->string('image', 255)->nullable();
                $table->string('typology', 255)->nullable();
                $table->string('zone', 255)->nullable();
                $table->string('plot_area', 255)->nullable();
                $table->string('built_up_area', 255)->nullable();
                $table->foreignId('timeline_id')->nullable()->constrained('research_timelines')->onDelete('set null');
                $table->integer('order')->default(0);
                $table->string('status', 60)->default('published'); // published or draft
                $table->timestamps();

                $table->index(['status', 'order']);
                $table->index('timeline_id');
            });
        }

        // Research Locations Translations
        if (!Schema::hasTable('research_locations_translations')) {
            Schema::create('research_locations_translations', function (Blueprint $table) {
                $table->string('lang_code', 20);
                $table->foreignId('research_locations_id')->constrained('research_locations')->onDelete('cascade');
                $table->string('title', 255)->nullable();
                $table->string('subtitle', 255)->nullable();
                $table->text('description')->nullable();
                $table->string('typology', 255)->nullable();
                $table->string('zone', 255)->nullable();
                $table->string('plot_area', 255)->nullable();
                $table->string('built_up_area', 255)->nullable();

                $table->primary(['lang_code', 'research_locations_id'], 'research_locations_translations_primary');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('research_locations_translations');
        Schema::dropIfExists('research_locations');
        Schema::dropIfExists('research_timelines_translations');
        Schema::dropIfExists('research_timelines');
    }
};
