<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     * 
     * Remove locale prefixes (en/, ar/) from existing slugs
     */
    public function up(): void
    {
        $locales = ['en', 'ar']; // Add your locales here

        foreach ($locales as $locale) {
            // Update prefix column - remove "locale/" from beginning
            DB::table('slugs')
                ->where('prefix', 'LIKE', $locale . '/%')
                ->update([
                        'prefix' => DB::raw("REPLACE(prefix, '{$locale}/', '')")
                    ]);

            // Update prefix column - remove standalone "locale"
            DB::table('slugs')
                ->where('prefix', '=', $locale)
                ->update([
                        'prefix' => ''
                    ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Cannot reverse this migration as we don't know which slugs originally had locale prefixes
    }
};
