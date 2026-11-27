<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Team photos do not need a name or a role.
     */
    public function up(): void
    {
        Schema::table('team_members', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
            $table->string('role')->nullable()->change();
        });
    }

    /**
     * Restore name and role as required columns.
     */
    public function down(): void
    {
        Schema::table('team_members', function (Blueprint $table) {
            $table->string('name')->nullable(false)->change();
            $table->string('role')->nullable(false)->change();
        });
    }
};
