<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['package_id', 'question_text', 'option_a', 'option_b', 'option_c', 'option_d', 'option_e', 'correct_answer', 'explanation', 'difficulty'])]
class Question extends Model
{
    public function package(): BelongsTo
    {
        return $this->belongsTo(QuestionPackage::class);
    }
}
