<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['slug', 'name', 'style', 'theme_class', 'description', 'features', 'icon', 'message'])]
class Template extends Model
{
    protected function casts(): array
    {
        return [
            'features' => 'array',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function weddings(): HasMany
    {
        return $this->hasMany(Wedding::class);
    }
}
