<?php

namespace App\Models;

use App\Enums\ServicePricingMode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TailoringService extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'pricing_mode',
        'base_price',
        'model_price_factor',
        'price_modifier',
        'requires_model',
        'requires_material',
        'requires_measurements',
        'applies_complexity',
        'applies_urgency',
        'applies_quantity',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'pricing_mode' => ServicePricingMode::class,
            'base_price' => 'decimal:2',
            'model_price_factor' => 'decimal:2',
            'price_modifier' => 'decimal:2',
            'requires_model' => 'boolean',
            'requires_material' => 'boolean',
            'requires_measurements' => 'boolean',
            'applies_complexity' => 'boolean',
            'applies_urgency' => 'boolean',
            'applies_quantity' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function measurementTypes(): BelongsToMany
    {
        return $this->belongsToMany(MeasurementType::class)
            ->withPivot(['is_required', 'sort_order'])
            ->withTimestamps()
            ->orderByPivot('sort_order')
            ->orderBy('name');
    }

    public function clothingModels(): BelongsToMany
    {
        return $this->belongsToMany(ClothingModel::class)
            ->withTimestamps()
            ->orderBy('sort_order')
            ->orderBy('name');
    }
}
