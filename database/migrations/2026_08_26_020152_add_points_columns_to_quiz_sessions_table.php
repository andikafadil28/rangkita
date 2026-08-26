<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quiz_sessions', function (Blueprint $table) {
            $table->integer('total_points')->nullable()->after('score');
            $table->integer('max_points')->nullable()->after('total_points');
        });
    }

    public function down(): void
    {
        Schema::table('quiz_sessions', function (Blueprint $table) {
            $table->dropColumn(['total_points', 'max_points']);
        });
    }
};
