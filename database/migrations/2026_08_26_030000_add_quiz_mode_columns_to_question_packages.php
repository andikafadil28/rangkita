<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('question_packages', function (Blueprint $table) {
            $table->enum('display_mode', ['scroll', 'step'])->default('scroll')->after('is_active');
            $table->boolean('allow_back')->default(true)->after('display_mode');
            $table->unsignedInteger('time_limit')->nullable()->after('allow_back');
        });
    }

    public function down(): void
    {
        Schema::table('question_packages', function (Blueprint $table) {
            $table->dropColumn(['display_mode', 'allow_back', 'time_limit']);
        });
    }
};
