<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('opportunities', function (Blueprint $table) {
            // Remove old unique index if exists
            try {
                $table->dropUnique('opportunities_permalink_unique');
            } catch (\Exception $e) {}
            // Add new unique index for slug
            $table->unique('slug');
        });
    }

    public function down(): void
    {
        Schema::table('opportunities', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->unique('permalink');
        });
    }
};
