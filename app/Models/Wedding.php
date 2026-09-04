<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['template_id', 'slug', 'groom_short_name', 'groom_full_name', 'groom_parent', 'bride_short_name', 'bride_full_name', 'bride_parent', 'wedding_date', 'events', 'maps_url', 'status'])]
class Wedding extends Model
{
    protected function casts(): array
    {
        return [
            'wedding_date' => 'datetime',
            'events' => 'array',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class);
    }

    public function gallery(): HasMany
    {
        return $this->hasMany(WeddingGallery::class)->orderBy('sort_order');
    }

    public function wishes(): HasMany
    {
        return $this->hasMany(WeddingWish::class);
    }

    public function approvedWishes(): HasMany
    {
        return $this->hasMany(WeddingWish::class)
            ->where('is_approved', true)
            ->latest();
    }
}
