<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MeasurementType extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'unit',
        'help_text',
        'is_required',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_required' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function tailoringServices(): BelongsToMany
    {
        return $this->belongsToMany(TailoringService::class)
            ->withPivot(['is_required', 'sort_order'])
            ->withTimestamps();
    }
}
