<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sidecar extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'sidecar_category_id',
        'description',
        'image',
        'base_price',
        'available_quantity',
        'status',
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'available_quantity' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(SidecarCategory::class, 'sidecar_category_id');
    }

    public function customizationRequests(): HasMany
    {
        return $this->hasMany(CustomizationRequest::class);
    }

    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
