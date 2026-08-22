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
        DB::table('question_packages')->insert([
            [
                'category' => 'tiu',
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
                'category' => 'tiu',
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
                'category' => 'tiu',
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