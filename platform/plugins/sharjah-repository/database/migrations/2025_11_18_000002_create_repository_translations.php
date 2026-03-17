<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('repository_categories_translations', function (Blueprint $table): void {
            $table->id();
            $table->string('lang_code', 20);
            $table->foreignId('repository_categories_id')->constrained('repository_categories', 'id', 'repo_cat_trans_cat_id_fk')->cascadeOnDelete();
            $table->string('name', 255)->nullable();

            $table->unique(['lang_code', 'repository_categories_id'], 'repo_cat_trans_unique');
        });

        Schema::create('repository_items_translations', function (Blueprint $table): void {
            $table->id();
            $table->string('lang_code', 20);
            $table->foreignId('repository_items_id')->constrained('repository_items', 'id', 'repo_item_trans_item_id_fk')->cascadeOnDelete();
            $table->string('title', 255)->nullable();
            $table->longText('content')->nullable();

            $table->unique(['lang_code', 'repository_items_id'], 'repo_item_trans_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('repository_items_translations');
        Schema::dropIfExists('repository_categories_translations');
    }
};
