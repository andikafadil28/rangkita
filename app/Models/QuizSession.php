<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'package_id', 'mode', 'score', 'answers', 'time_spent', 'time_limit', 'total_points', 'max_points'])]
class QuizSession extends Model
{
    protected function casts(): array
    {
        return [
            'answers' => 'array',
            'total_points' => 'integer',
            'max_points' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(QuestionPackage::class, 'package_id');
    }
}
