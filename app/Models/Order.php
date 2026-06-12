<?php

namespace App\Models;

use App\Enums\ComplexityLevel;
use App\Enums\OrderStatus;
use App\Enums\UrgencyLevel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'customer_id',
        'master_id',
        'clothing_model_id',
        'material_id',
        'status',
        'quantity',
        'complexity',
        'urgency',
        'measurements',
        'parameters',
        'customer_comment',
        'admin_comment',
        'preliminary_price',
        'final_price',
        'cancelled_at',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => OrderStatus::class,
            'quantity' => 'integer',
            'complexity' => ComplexityLevel::class,
            'urgency' => UrgencyLevel::class,
            'measurements' => 'array',
            'parameters' => 'array',
            'preliminary_price' => 'decimal:2',
            'final_price' => 'decimal:2',
            'cancelled_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function master(): BelongsTo
    {
        return $this->belongsTo(User::class, 'master_id');
    }

    public function clothingModel(): BelongsTo
    {
        return $this->belongsTo(ClothingModel::class);
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    public function referenceImages(): HasMany
    {
        return $this->hasMany(OrderReferenceImage::class);
    }
}
