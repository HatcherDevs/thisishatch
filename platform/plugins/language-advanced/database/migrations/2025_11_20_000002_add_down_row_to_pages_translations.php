<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('pages_translations') && ! Schema::hasColumn('pages_translations', 'down_row')) {
            Schema::table('pages_translations', function (Blueprint $table): void {
                $table->longText('down_row')->nullable()->after('content');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('pages_translations') && Schema::hasColumn('pages_translations', 'down_row')) {
            Schema::table('pages_translations', function (Blueprint $table): void {
                $table->dropColumn('down_row');
            });
        }
    }
};
