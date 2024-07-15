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
        Schema::create('vacancies', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->text('vacancy_header_text')->nullable();
            $table->text('vacancy_footer_text')->nullable();
            $table->longText('obligations')->nullable();
            $table->longText('skills')->nullable();
            $table->string("seo_title")->nullable();
            $table->text("seo_keywords")->nullable();
            $table->text("seo_description")->nullable();
            $table->text("seo_links")->nullable();
            $table->text("seo_scripts")->nullable();
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
        Schema::dropIfExists('vacancies');
    }
};
