<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('repository_categories', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 255);
            $table->string('status', 60)->default('published');
            $table->timestamps();
        });

        Schema::create('repository_items', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('repository_categories')->nullOnDelete();
            $table->string('title', 255);
            $table->string('link', 500)->nullable();
            $table->string('image', 255)->nullable();
            $table->longText('content')->nullable();
            $table->string('status', 60)->default('published');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('repository_items');
        Schema::dropIfExists('repository_categories');
    }
};
