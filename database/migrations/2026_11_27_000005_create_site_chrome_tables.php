<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Header links, footer social icons, and the company block.
     */
    public function up(): void
    {
        Schema::create('header_links', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('url')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('social_links', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('url')->nullable();
            $table->string('icon');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('company_infos', function (Blueprint $table) {
            $table->id();
            $table->string('line_1');
            $table->string('line_2')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone_url')->nullable();
            $table->string('button_label')->default('Chat With Us');
            $table->string('button_url')->default('/contact');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Drop the header and footer tables.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_infos');
        Schema::dropIfExists('social_links');
        Schema::dropIfExists('header_links');
    }
};
