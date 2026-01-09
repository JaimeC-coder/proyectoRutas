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
        Schema::create('user_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained()->cascadeOnDelete();
            $table->string('status')->default('pending');
            $table->string('invited_email')->nullable();
            $table->string('invitation_token')->nullable();
            $table->timestamp('invitation_sent_at')->nullable();
            $table->timestamp('invitation_accepted_at')->nullable();
            $table->string('role');
            $table->timestamps();

            $table->unique(['user_id', 'plan_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_plans');
    }
};
