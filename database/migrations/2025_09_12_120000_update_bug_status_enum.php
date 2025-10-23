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
        // SQLite does not support MODIFY or ENUM. We'll change the column to TEXT for compatibility.
        if (Schema::getConnection()->getDriverName() === 'sqlite') {
            Schema::table('bugs', function (Blueprint $table) {
                $table->text('status')->default('open')->change();
            });
        } else {
            Schema::table('bugs', function (Blueprint $table) {
                DB::statement("ALTER TABLE bugs MODIFY status ENUM('open', 'inprogress', 'review', 'done', 'in_progress', 'completed', 'reassigned') DEFAULT 'open'");
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::getConnection()->getDriverName() === 'sqlite') {
            Schema::table('bugs', function (Blueprint $table) {
                $table->text('status')->default('open')->change();
            });
        } else {
            Schema::table('bugs', function (Blueprint $table) {
                DB::statement("ALTER TABLE bugs MODIFY status ENUM('open', 'in_progress', 'review', 'done', 'completed', 'reassigned') DEFAULT 'open'");
            });
        }
    }
};
