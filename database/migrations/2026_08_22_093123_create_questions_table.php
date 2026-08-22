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
    Schema::create('questions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('package_id')->constrained('question_packages')->cascadeOnDelete();
        $table->text('question_text');
        $table->string('option_a');
        $table->string('option_b');
        $table->string('option_c');
        $table->string('option_d');
        // nullable: NULL = soal 4 opsi, terisi = soal 5 opsi (fleksibel utk CPNS/Polri/dll)
        $table->string('option_e')->nullable();
        $table->enum('correct_answer', ['a', 'b', 'c', 'd', 'e']);
        $table->text('explanation')->nullable();
        $table->enum('difficulty', ['mudah', 'sedang', 'sulit'])->default('sedang');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
