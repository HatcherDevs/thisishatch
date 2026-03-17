<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Events Categories Table
        if (!Schema::hasTable('event_categories')) {
            Schema::create('event_categories', function (Blueprint $table) {
                $table->id();
                $table->string('name', 255);
                $table->string('slug', 255)->nullable()->unique();
                $table->text('description')->nullable();
                $table->foreignId('parent_id')->nullable()->constrained('event_categories')->onDelete('cascade');
                $table->string('image', 255)->nullable();
                $table->string('icon', 100)->nullable();
                $table->integer('order')->default(0);
                $table->string('status', 60)->default('published');
                $table->boolean('is_featured')->default(false);
                $table->timestamps();

                $table->index(['status', 'created_at']);
                $table->index('parent_id');
            });
        }

        // Event Categories Translations
        if (!Schema::hasTable('event_categories_translations')) {
            Schema::create('event_categories_translations', function (Blueprint $table) {
                $table->string('lang_code', 20);
                $table->foreignId('event_categories_id')->constrained('event_categories')->onDelete('cascade');
                $table->string('name', 255)->nullable();
                $table->text('description')->nullable();

                $table->primary(['lang_code', 'event_categories_id'], 'event_categories_translations_primary');
            });
        }

        // Event Tags Table
        if (!Schema::hasTable('event_tags')) {
            Schema::create('event_tags', function (Blueprint $table) {
                $table->id();
                $table->string('name', 255);
                $table->string('slug', 255)->nullable()->unique();
                $table->text('description')->nullable();
                $table->string('status', 60)->default('published');
                $table->timestamps();

                $table->index(['status', 'created_at']);
            });
        }

        // Event Tags Translations
        if (!Schema::hasTable('event_tags_translations')) {
            Schema::create('event_tags_translations', function (Blueprint $table) {
                $table->string('lang_code', 20);
                $table->foreignId('event_tags_id')->constrained('event_tags')->onDelete('cascade');
                $table->string('name', 255)->nullable();
                $table->text('description')->nullable();

                $table->primary(['lang_code', 'event_tags_id'], 'event_tags_translations_primary');
            });
        }

        // Event Locations Table
        if (!Schema::hasTable('event_locations')) {
            Schema::create('event_locations', function (Blueprint $table) {
                $table->id();
                $table->string('name', 255);
                $table->string('slug', 255)->nullable()->unique();
                $table->text('description')->nullable();
                $table->text('address')->nullable();
                $table->decimal('latitude', 10, 8)->nullable();
                $table->decimal('longitude', 11, 8)->nullable();
                $table->string('city', 255)->nullable();
                $table->string('country', 255)->nullable();
                $table->string('phone', 20)->nullable();
                $table->string('email', 255)->nullable();
                $table->string('website', 255)->nullable();
                $table->string('image', 255)->nullable();
                $table->integer('capacity')->nullable();
                $table->string('status', 60)->default('published');
                $table->timestamps();

                $table->index(['status', 'created_at']);
                $table->index(['latitude', 'longitude']);
            });
        }

        // Event Locations Translations
        if (!Schema::hasTable('event_locations_translations')) {
            Schema::create('event_locations_translations', function (Blueprint $table) {
                $table->string('lang_code', 20);
                $table->foreignId('event_locations_id')->constrained('event_locations')->onDelete('cascade');
                $table->string('name', 255)->nullable();
                $table->text('description')->nullable();
                $table->text('address')->nullable();
                $table->string('city', 255)->nullable();

                $table->primary(['lang_code', 'event_locations_id'], 'event_locations_translations_primary');
            });
        }

        // Events Table
        if (!Schema::hasTable('events')) {
            Schema::create('events', function (Blueprint $table) {
                $table->id();
                $table->string('name', 255);
                $table->string('slug', 255)->nullable()->unique();
                $table->text('description')->nullable();
                $table->longText('content')->nullable();
                $table->string('image', 255)->nullable();
                $table->date('start_date');
                $table->date('end_date')->nullable();
                $table->time('start_time')->nullable();
                $table->time('end_time')->nullable();
                $table->foreignId('event_category_id')->nullable()->constrained('event_categories')->onDelete('set null');
                $table->foreignId('event_location_id')->nullable()->constrained('event_locations')->onDelete('set null');
                $table->string('status', 60)->default('published');
                $table->boolean('is_featured')->default(false);
                $table->integer('order')->default(0);

                // Registration fields
                $table->boolean('has_registration')->default(false);
                $table->dateTime('registration_deadline')->nullable();
                $table->integer('max_attendees')->nullable();
                $table->integer('current_attendees')->default(0);
                $table->json('registration_fields')->nullable();
                $table->boolean('auto_approve_registration')->default(true);

                $table->timestamps();

                $table->index(['status', 'start_date']);
                $table->index('event_category_id');
                $table->index('event_location_id');
                $table->index('is_featured');
            });
        }

        // Events Translations
        if (!Schema::hasTable('events_translations')) {
            Schema::create('events_translations', function (Blueprint $table) {
                $table->string('lang_code', 20);
                $table->foreignId('events_id')->constrained('events')->onDelete('cascade');
                $table->string('name', 255)->nullable();
                $table->text('description')->nullable();
                $table->longText('content')->nullable();

                $table->primary(['lang_code', 'events_id'], 'events_translations_primary');
            });
        }

        // Event Tag Pivot Table
        if (!Schema::hasTable('event_tag')) {
            Schema::create('event_tag', function (Blueprint $table) {
                $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
                $table->foreignId('tag_id')->constrained('event_tags')->onDelete('cascade');

                $table->primary(['event_id', 'tag_id']);
            });
        }

        // Event Registrations Table
        if (!Schema::hasTable('event_registrations')) {
            Schema::create('event_registrations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
                $table->string('registration_number', 50)->unique();
                $table->string('name', 255);
                $table->string('email', 255);
                $table->string('phone', 20)->nullable();
                $table->json('registration_data')->nullable();
                $table->string('status', 60)->default('pending'); // pending, approved, rejected, cancelled, attended
                $table->text('notes')->nullable();
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->timestamp('confirmed_at')->nullable();
                $table->timestamp('attended_at')->nullable();
                $table->timestamps();

                $table->index(['event_id', 'status']);
                $table->index('email');
                $table->index('created_at');
            });
        }
    }

    public function down(): void
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
};
