<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * A second demo reel file for phones.
     */
    public function up(): void
    {
        Schema::table('demo_reels', function (Blueprint $table) {
            $table->string('video_mobile')->nullable()->after('video');
        });
    }

    /**
     * Remove the phone demo reel column.
     */
    public function down(): void
    {
        Schema::table('demo_reels', function (Blueprint $table) {
            $table->dropColumn('video_mobile');
        });
    }
};
