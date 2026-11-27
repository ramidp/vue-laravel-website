<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations: create the "testimonials" table.
     */
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role');
            $table->text('quote');
            $table->string('photo');                         // Path relative to public/, e.g. images/abc.png
            $table->string('photo_position')->nullable();    // CSS object-position, e.g. "center bottom"
            $table->string('logo');                          // Path relative to public/
            $table->string('logo_alt');
            $table->unsignedSmallInteger('logo_width');
            $table->unsignedSmallInteger('logo_height');
            $table->string('logo_blend')->nullable();        // CSS mix-blend-mode, when the logo needs it
            $table->json('logo_crop')->nullable();           // Crop box: width, height, left, top
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations: drop the "testimonials" table.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
