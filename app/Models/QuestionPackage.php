<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['category', 'name', 'slug', 'total_questions', 'difficulty', 'price', 'is_active'])]
class QuestionPackage extends Model
{
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, 'package_id');
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
