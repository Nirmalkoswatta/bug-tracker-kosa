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
            // Change ENUM to include 'inprogress' and 'review' and increase VARCHAR length if needed
            DB::statement("ALTER TABLE bugs MODIFY status ENUM('open', 'inprogress', 'review', 'in_progress', 'completed', 'reassigned') DEFAULT 'open'");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bugs', function (Blueprint $table) {
            DB::statement("ALTER TABLE bugs MODIFY status ENUM('open', 'in_progress', 'review', 'completed', 'reassigned') DEFAULT 'open'");
        });
    }
};
