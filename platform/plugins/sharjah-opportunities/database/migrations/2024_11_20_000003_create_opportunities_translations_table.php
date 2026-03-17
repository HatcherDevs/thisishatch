<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('opportunities_translations', function (Blueprint $table) {
            $table->id();
            $table->string('lang_code', 10);
            $table->unsignedBigInteger('opportunities_id');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->longText('content')->nullable();
            $table->unique(['opportunities_id', 'lang_code']);
            $table->foreign('opportunities_id')->references('id')->on('opportunities')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('opportunities_translations');
    }
};
