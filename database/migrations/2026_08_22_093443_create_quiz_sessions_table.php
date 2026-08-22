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
    Schema::create('quiz_sessions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->foreignId('package_id')->constrained('question_packages')->cascadeOnDelete();
        $table->enum('mode', ['latihan', 'test']);
        $table->unsignedInteger('score')->nullable();
        $table->json('answers')->nullable();
        $table->unsignedInteger('time_spent')->nullable();
        $table->unsignedInteger('time_limit')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_sessions');
    }
};
