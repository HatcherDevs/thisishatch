<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('opportunities_translations')) {
            // Drop foreign key
            try {
                \DB::statement('ALTER TABLE opportunities_translations DROP FOREIGN KEY opportunities_translations_opportunity_id_foreign');
            } catch (\Exception $e) {}
            // Drop unique index
            try {
                \DB::statement('DROP INDEX opportunities_translations_opportunity_id_lang_code_unique ON opportunities_translations');
            } catch (\Exception $e) {}
            // Rename column
            try {
                \DB::statement('ALTER TABLE opportunities_translations CHANGE opportunity_id opportunities_id BIGINT UNSIGNED');
            } catch (\Exception $e) {}
            // Recreate unique index
            try {
                \DB::statement('CREATE UNIQUE INDEX opportunities_translations_opportunities_id_lang_code_unique ON opportunities_translations (opportunities_id, lang_code)');
            } catch (\Exception $e) {}
            // Recreate foreign key
            try {
                \DB::statement('ALTER TABLE opportunities_translations ADD CONSTRAINT opportunities_translations_opportunities_id_foreign FOREIGN KEY (opportunities_id) REFERENCES opportunities(id) ON DELETE CASCADE');
            } catch (\Exception $e) {}
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('opportunities_translations')) {
            // Drop foreign key
            try {
                \DB::statement('ALTER TABLE opportunities_translations DROP FOREIGN KEY opportunities_translations_opportunities_id_foreign');
            } catch (\Exception $e) {}
            // Drop unique index
            try {
                \DB::statement('DROP INDEX opportunities_translations_opportunities_id_lang_code_unique ON opportunities_translations');
            } catch (\Exception $e) {}
            // Rename column
            try {
                \DB::statement('ALTER TABLE opportunities_translations CHANGE opportunities_id opportunity_id BIGINT UNSIGNED');
            } catch (\Exception $e) {}
            // Recreate unique index
            try {
                \DB::statement('CREATE UNIQUE INDEX opportunities_translations_opportunity_id_lang_code_unique ON opportunities_translations (opportunity_id, lang_code)');
            } catch (\Exception $e) {}
            // Recreate foreign key
            try {
                \DB::statement('ALTER TABLE opportunities_translations ADD CONSTRAINT opportunities_translations_opportunity_id_foreign FOREIGN KEY (opportunity_id) REFERENCES opportunities(id) ON DELETE CASCADE');
            } catch (\Exception $e) {}
        }
    }
};
