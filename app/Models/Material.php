<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'additional_price',
        'inventory_item_id',
        'quantity_required',
        'is_active',
    ];

    protected $casts = [
        'additional_price' => 'decimal:2',
        'quantity_required' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function inventoryItem(): BelongsTo
    {
        return $this->belongsTo(InventoryItem::class);
    }

    public function customizationRequests(): HasMany
    {
        return $this->hasMany(CustomizationRequest::class);
    }
}
