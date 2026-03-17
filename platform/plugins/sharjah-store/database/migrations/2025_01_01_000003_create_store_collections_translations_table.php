<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('store_collections_translations', function (Blueprint $table) {
            $table->id();
            $table->string('lang_code', 10);
            $table->unsignedBigInteger('store_collections_id');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            
            $table->unique(['store_collections_id', 'lang_code'], 'collections_translations_unique');
            $table->foreign('store_collections_id')->references('id')->on('store_collections')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('store_collections_translations');
    }
};
