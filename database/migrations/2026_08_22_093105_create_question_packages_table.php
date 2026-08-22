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
    Schema::create('question_packages', function (Blueprint $table) {
        $table->id();
        $table->enum('category', ['twk', 'tiu', 'tkp']);
        $table->string('name');
        $table->string('slug')->unique();
        $table->unsignedInteger('total_questions');
        $table->enum('difficulty', ['mudah', 'sedang', 'sulit'])->default('sedang');
        $table->unsignedInteger('price')->default(0);
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_packages');
    }
};
