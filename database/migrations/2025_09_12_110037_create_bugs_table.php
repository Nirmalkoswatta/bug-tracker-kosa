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
        Schema::create('bugs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('attachment')->nullable(); // file path
            $table->unsignedBigInteger('created_by'); // QA user id
            $table->unsignedBigInteger('assigned_to')->nullable(); // Dev user id
            $table->enum('status', ['open', 'in_progress', 'review', 'completed', 'reassigned'])->default('open');
            $table->unsignedBigInteger('reviewed_by')->nullable(); // QA user id for review
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('set null');
            $table->foreign('reviewed_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bugs');
    }
};
