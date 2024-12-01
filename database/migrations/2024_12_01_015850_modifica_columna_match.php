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
        Schema::table('matches', function (Blueprint $table) {
            $table->string('team_b')->nullable()->change(); // Permitir NULL en `team_b`
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};