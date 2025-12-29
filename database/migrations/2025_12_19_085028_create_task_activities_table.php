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
        Schema::create('task_activities', function (Blueprint $table) {
            $table->id();

            $table->foreignId('task_id')->constrained()->cascadeOnDelete();

            // who did it (employee/manager/admin/scheduler). nullable for scheduler.
            $table->foreignId('actor_id')->nullable()->constrained('users')->nullOnDelete();

            // what happened (keep it string for flexibility)
            $table->string('action'); 
            // examples: created, updated, status_changed, sent_for_review, approved, sent_back, reassigned, marked_overdue

            // optional details: old/new status, notes, etc.
            $table->json('meta')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_activities');
    }
};
