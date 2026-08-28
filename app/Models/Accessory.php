<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Accessory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'inventory_item_id',
        'quantity_required',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity_required' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function inventoryItem(): BelongsTo
    {
        return $this->belongsTo(InventoryItem::class);
    }

    public function customizationRequests(): BelongsToMany
    {
        return $this->belongsToMany(CustomizationRequest::class, 'customization_request_accessories')
            ->withPivot('price', 'quantity')
            ->withTimestamps();
    }
}
