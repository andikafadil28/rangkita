<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('weddings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')->constrained()->restrictOnDelete();
            $table->string('slug')->unique();
            $table->string('groom_short_name');
            $table->string('groom_full_name');
            $table->string('groom_parent')->nullable();
            $table->string('bride_short_name');
            $table->string('bride_full_name');
            $table->string('bride_parent')->nullable();
            $table->dateTime('wedding_date');
            $table->json('events');
            $table->text('maps_url')->nullable();
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->timestamps();

            $table->index(['status', 'wedding_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('weddings');
    }
};
