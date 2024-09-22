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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('sub_title', 255)->nullable();
            $table->string('source_uuid');
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->string('url')->nullable();
            $table->string('api_url')->nullable();
            $table->string('category')->nullable();
            $table->string('sub_category')->nullable();
            $table->string('language')->nullable();
            $table->string('country')->nullable();
            $table->string('type')->nullable();
            $table->string('author')->nullable();
            $table->string('source')->nullable();
            $table->string('uri')->nullable();
            $table->string('image_url')->nullable();
            $table->string('published_date')->nullable();
            $table->string('created_date')->nullable();
            $table->string('updated_date')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->jsonb('source_payload')->nullable();
            $table->jsonb('image_payload')->nullable();

            // foreign keys below
            $table->unsignedBigInteger('platform_id')->nullable();
            $table->foreign('platform_id')->references('id')->on('platforms')->onDelete('cascade');

            $table->unsignedBigInteger('source_id')->nullable();
            $table->foreign('source_id')->references('id')->on('sources')->onDelete('cascade');

            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
