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
    Schema::create('transactions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->foreignId('package_id')->constrained('question_packages')->cascadeOnDelete();
        $table->string('order_id')->unique();
        $table->unsignedInteger('gross_amount');
        $table->string('payment_type')->nullable();
        $table->enum('status', ['pending', 'paid', 'failed', 'expired', 'cancelled'])->default('pending');
        $table->string('snap_token')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
