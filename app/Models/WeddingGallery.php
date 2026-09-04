<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['wedding_id', 'photo_path', 'caption', 'sort_order'])]
class WeddingGallery extends Model
{
    protected $table = 'wedding_gallery';

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    public function wedding(): BelongsTo
    {
        return $this->belongsTo(Wedding::class);
    }
}
