<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('training_categories', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('seo_title')->nullable();
            $table->string('slug')->nullable();
            $table->string('subtitle')->nullable();
            $table->longText('seo_keywords')->nullable();
            $table->longText('seo_description')->nullable();
            $table->longText('seo_links')->nullable();
            $table->longText('seo_scripts')->nullable();
            $table->unsignedBigInteger('order')->default(0);
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_categories');
    }
};
