<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('store_products_translations', function (Blueprint $table) {
            $table->id();
            $table->string('lang_code', 10);
            $table->unsignedBigInteger('store_products_id');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->longText('content')->nullable();
            $table->longText('down_row')->nullable();
            
            $table->unique(['store_products_id', 'lang_code'], 'products_translations_unique');
            $table->foreign('store_products_id')->references('id')->on('store_products')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('store_products_translations');
    }
};
