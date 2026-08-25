<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tiuId = DB::table('soal_categories')->where('slug', 'tiu')->first()->id;

        DB::table('question_packages')->insert([
            [
                'soal_category_id' => $tiuId,
                'name' => 'TIU Verbal',
                'slug' => 'tiu-verbal',
                'total_questions' => 30,
                'difficulty' => 'sedang',
                'price' => 0,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'soal_category_id' => $tiuId,
                'name' => 'TIU Numerik',
                'slug' => 'tiu-numerik',
                'total_questions' => 50,
                'difficulty' => 'sedang',
                'price' => 15000,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'soal_category_id' => $tiuId,
                'name' => 'TIU Penalaran',
                'slug' => 'tiu-penalaran',
                'total_questions' => 20,
                'difficulty' => 'sedang',
                'price' => 0,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}