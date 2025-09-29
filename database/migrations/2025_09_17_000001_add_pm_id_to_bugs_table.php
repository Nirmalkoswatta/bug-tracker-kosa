<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('bugs', function (Blueprint $table) {
            if (!Schema::hasColumn('bugs', 'pm_id')) {
                $table->unsignedBigInteger('pm_id')->nullable()->after('reviewed_by');
                $table->foreign('pm_id')->references('id')->on('users')->onDelete('set null');
            }
        });
    }
    public function down(): void
    {
        Schema::table('bugs', function (Blueprint $table) {
            if (Schema::hasColumn('bugs', 'pm_id')) {
                $table->dropForeign(['pm_id']);
                $table->dropColumn('pm_id');
            }
        });
    }
};
