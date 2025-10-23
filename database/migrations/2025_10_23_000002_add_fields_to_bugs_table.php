<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bugs', function (Blueprint $table) {
            if (!Schema::hasColumn('bugs', 'classification')) {
                $table->string('classification', 60)->nullable()->after('title');
            }
            if (!Schema::hasColumn('bugs', 'severity')) {
                $table->string('severity', 20)->default('low')->after('classification');
            }
            if (!Schema::hasColumn('bugs', 'project_id')) {
                $table->unsignedBigInteger('project_id')->nullable()->after('assigned_to');
                $table->foreign('project_id')->references('id')->on('projects')->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bugs', function (Blueprint $table) {
            if (Schema::hasColumn('bugs', 'project_id')) {
                $table->dropForeign(['project_id']);
                $table->dropColumn('project_id');
            }
            if (Schema::hasColumn('bugs', 'severity')) {
                $table->dropColumn('severity');
            }
            if (Schema::hasColumn('bugs', 'classification')) {
                $table->dropColumn('classification');
            }
        });
    }
};
