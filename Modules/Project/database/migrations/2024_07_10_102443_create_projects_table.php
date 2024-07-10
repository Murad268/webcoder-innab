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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->text('card_description')->nullable();
            $table->longText('text')->nullable();
            $table->text('product_description')->nullable();
            $table->string('product_price')->nullable();
            $table->string('mobile_title')->nullable();
            $table->longText('mobile_description')->nullable();
            $table->text('mobile_qr_text')->nullable();
            $table->string('seo_title')->nullable();
            $table->longText('meta_keywords')->nullable();
            $table->longText('meta_description')->nullable();
            $table->longText('seo_links')->nullable();
            $table->longText('seo_scripts')->nullable();
            $table->unsignedBigInteger('order')->default(0);
            $table->unsignedBigInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
