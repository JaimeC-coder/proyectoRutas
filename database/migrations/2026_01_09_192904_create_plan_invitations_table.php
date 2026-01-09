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
        Schema::create('plan_invitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')->constrained('plans')->onDelete('cascade');
            $table->string('email');
            $table->string('role')->default('guest');
            $table->string('token')->unique();
            $table->timestamp('expires_at');
            $table->timestamp('accepted_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_invitations');
    }
};
