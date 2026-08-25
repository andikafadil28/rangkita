<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Buat tabel kategori
        Schema::create('soal_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('icon')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // 2. Seed default kategori
        $now = now();
        DB::table('soal_categories')->insert([
            [
                'name' => 'Tes Wawasan Kebangsaan',
                'slug' => 'twk',
                'icon' => '🇮🇩',
                'description' => 'Nasionalisme, integritas, bela negara, pilar negara, dan bahasa Indonesia.',
                'sort_order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Tes Intelegensia Umum',
                'slug' => 'tiu',
                'icon' => '🧠',
                'description' => 'Kemampuan verbal, numerik, penalaran logis, dan analitis.',
                'sort_order' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Tes Karakteristik Pribadi',
                'slug' => 'tkp',
                'icon' => '🎯',
                'description' => 'Pelayanan publik, kejujuran, komitmen, disiplin, dan kerja sama.',
                'sort_order' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        // 3. Tambah kolom FK (nullable sementara)
        Schema::table('question_packages', function (Blueprint $table) {
            $table->foreignId('soal_category_id')->after('id')->nullable();
        });

        // 4. Migrate data dari enum → FK
        $map = DB::table('soal_categories')->pluck('id', 'slug')->toArray();
        foreach (['twk', 'tiu', 'tkp'] as $slug) {
            if (isset($map[$slug])) {
                DB::table('question_packages')
                    ->where('category', $slug)
                    ->update(['soal_category_id' => $map[$slug]]);
            }
        }

        // 5. Make non-nullable + FK constraint
        DB::statement('ALTER TABLE question_packages MODIFY soal_category_id BIGINT UNSIGNED NOT NULL');

        Schema::table('question_packages', function (Blueprint $table) {
            $table->foreign('soal_category_id')
                ->references('id')
                ->on('soal_categories')
                ->cascadeOnDelete();
        });

        // 6. Drop kolom enum lama
        Schema::table('question_packages', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }

    public function down(): void
    {
        Schema::table('question_packages', function (Blueprint $table) {
            $table->dropForeign(['soal_category_id']);
            $table->dropColumn('soal_category_id');
            $table->enum('category', ['twk', 'tiu', 'tkp'])->after('id');
        });

        $map = DB::table('soal_categories')->pluck('id', 'slug')->toArray();
        foreach (['twk', 'tiu', 'tkp'] as $slug) {
            if (isset($map[$slug])) {
                DB::table('question_packages')
                    ->where('soal_category_id', $map[$slug])
                    ->update(['category' => $slug]);
            }
        }

        Schema::dropIfExists('soal_categories');
    }
};
