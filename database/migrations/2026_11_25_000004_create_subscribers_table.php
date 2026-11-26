<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations: create the "subscribers" table.
     */
    public function up(): void
    {
        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();              // Same email cannot subscribe twice
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations: drop the "subscribers" table.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscribers');
    }
};
