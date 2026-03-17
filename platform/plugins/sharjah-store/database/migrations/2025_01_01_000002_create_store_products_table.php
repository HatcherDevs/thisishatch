<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('store_products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('slug', 255)->unique();
            $table->text('description')->nullable();
            $table->longText('content')->nullable();
            $table->longText('down_row')->nullable();
            $table->string('image')->nullable();
            $table->unsignedBigInteger('collection_id')->nullable();
            $table->string('status', 60)->default('published');
            $table->integer('order')->default(0);
            $table->timestamps();

            $table->foreign('collection_id')->references('id')->on('store_collections')->onDelete('set null');
            $table->index(['status', 'collection_id', 'order']);
            $table->index('slug');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('store_products');
    }
};
