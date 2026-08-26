<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['soal_category_id', 'name', 'slug', 'total_questions', 'difficulty', 'price', 'is_active', 'point_correct', 'point_blank', 'point_wrong', 'display_mode', 'allow_back', 'time_limit'])]
class QuestionPackage extends Model
{
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'allow_back' => 'boolean',
            'time_limit' => 'integer',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function soalCategory(): BelongsTo
    {
        return $this->belongsTo(SoalCategory::class, 'soal_category_id');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, 'package_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'package_id');
    }

    public function quizSessions(): HasMany
    {
        return $this->hasMany(QuizSession::class, 'package_id');
    }

    public function userAccess(): HasMany
    {
        return $this->hasMany(UserAccess::class, 'package_id');
    }

    public function isFree(): bool
    {
        return $this->price === 0;
    }
}
