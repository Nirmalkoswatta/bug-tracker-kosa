<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bugs', function (Blueprint $table) {
            // Change ENUM to include 'inprogress', 'review', and 'done'
            DB::statement("ALTER TABLE bugs MODIFY status ENUM('open', 'inprogress', 'review', 'done', 'in_progress', 'completed', 'reassigned') DEFAULT 'open'");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bugs', function (Blueprint $table) {
            DB::statement("ALTER TABLE bugs MODIFY status ENUM('open', 'in_progress', 'review', 'done', 'completed', 'reassigned') DEFAULT 'open'");
        });
    }
};
