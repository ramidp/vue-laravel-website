<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tables for the homepage blocks a client can edit.
     */
    public function up(): void
    {
        Schema::create('client_logos', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('alt')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('work_items', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->unsignedTinyInteger('row')->default(1);
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('service_groups', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->string('line1');
            $table->string('line2');
            $table->text('text');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('service_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_group_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->unsignedTinyInteger('column')->default(1);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('journey_steps', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->string('label');
            $table->string('image');
            $table->string('title');
            $table->text('body');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('platforms', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('alt')->nullable();
            $table->unsignedTinyInteger('row')->default(1);
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('email_shots', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->boolean('is_wide')->default(false);
            $table->boolean('is_dim')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Drop the homepage content tables.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_shots');
        Schema::dropIfExists('platforms');
        Schema::dropIfExists('journey_steps');
        Schema::dropIfExists('service_items');
        Schema::dropIfExists('service_groups');
        Schema::dropIfExists('work_items');
        Schema::dropIfExists('client_logos');
    }
};
