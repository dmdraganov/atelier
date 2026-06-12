<?php

namespace App\Models;

use App\Enums\ComplexityLevel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClothingModel extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'image_path',
        'base_price',
        'default_complexity',
        'estimated_days',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'base_price' => 'decimal:2',
            'default_complexity' => ComplexityLevel::class,
            'estimated_days' => 'integer',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ClothingCategory::class, 'category_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
