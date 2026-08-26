<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('question_packages', function (Blueprint $table) {
            $table->integer('point_correct')->nullable()->after('price');
            $table->integer('point_blank')->nullable()->default(0)->after('point_correct');
            $table->integer('point_wrong')->nullable()->default(0)->after('point_blank');
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->integer('point_correct')->nullable()->after('difficulty');
            $table->integer('point_blank')->nullable()->after('point_correct');
            $table->integer('point_wrong')->nullable()->after('point_blank');
        });
    }

    public function down(): void
    {
        Schema::table('question_packages', function (Blueprint $table) {
            $table->dropColumn(['point_correct', 'point_blank', 'point_wrong']);
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn(['point_correct', 'point_blank', 'point_wrong']);
        });
    }
};
