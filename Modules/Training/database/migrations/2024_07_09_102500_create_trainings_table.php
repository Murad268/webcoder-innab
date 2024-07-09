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
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->text("short_description");
            $table->string('top_text_title');
            $table->text("top_text");
            $table->string('bottom_text_title');
            $table->string('bottom_text');
            $table->string('seo_title');
            $table->text("list");
            $table->longText('seo_keywords')->nullable();
            $table->longText('seo_description')->nullable();
            $table->longText('seo_links')->nullable();
            $table->longText('seo_scripts')->nullable();
            $table->unsignedBigInteger('order')->default(0);
            $table->boolean('status')->default(1);
            $table->unsignedBigInteger('category_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainings');
    }
};
