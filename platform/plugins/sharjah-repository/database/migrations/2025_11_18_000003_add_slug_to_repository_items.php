<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('repository_items', 'slug')) {
            Schema::table('repository_items', function (Blueprint $table): void {
                $table->string('slug', 255)->nullable()->after('title');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('repository_items', 'slug')) {
            Schema::table('repository_items', function (Blueprint $table): void {
                $table->dropColumn('slug');
            });
        }
    }
};
