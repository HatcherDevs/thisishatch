<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('opportunities', 'permalink')) {
            Schema::table('opportunities', function (Blueprint $table) {
                $table->renameColumn('permalink', 'slug');
            });
        } elseif (!Schema::hasColumn('opportunities', 'slug')) {
            Schema::table('opportunities', function (Blueprint $table) {
                $table->string('slug', 255)->unique()->after('name');
                $table->index('slug');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('opportunities', 'slug')) {
            Schema::table('opportunities', function (Blueprint $table) {
                $table->renameColumn('slug', 'permalink');
            });
        }
    }
};
