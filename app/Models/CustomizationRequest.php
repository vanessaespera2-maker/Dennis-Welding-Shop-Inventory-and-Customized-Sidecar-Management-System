<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CustomizationRequest extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_REVIEWING = 'reviewing';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_IN_PRODUCTION = 'in_production';
    public const STATUS_READY_FOR_PICKUP = 'ready_for_pickup';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';
    public const STATUS_REJECTED = 'rejected';

    public const STATUSES = [
        self::STATUS_PENDING => 'Pending',
        self::STATUS_REVIEWING => 'Reviewing',
        self::STATUS_APPROVED => 'Approved',
        self::STATUS_IN_PRODUCTION => 'In Production',
        self::STATUS_READY_FOR_PICKUP => 'Ready for Pickup',
        self::STATUS_COMPLETED => 'Completed',
        self::STATUS_CANCELLED => 'Cancelled',
        self::STATUS_REJECTED => 'Rejected',
    ];

    public const STATUS_COLORS = [
        self::STATUS_PENDING => 'warning',
        self::STATUS_REVIEWING => 'info',
        self::STATUS_APPROVED => 'success',
        self::STATUS_IN_PRODUCTION => 'primary',
        self::STATUS_READY_FOR_PICKUP => 'info',
        self::STATUS_COMPLETED => 'success',
        self::STATUS_CANCELLED => 'gray',
        self::STATUS_REJECTED => 'danger',
    ];

    protected $fillable = [
        'request_number',
        'user_id',
        'sidecar_id',
        'material_id',
        'color_id',
        'estimated_price',
        'final_price',
        'status',
        'special_instructions',
        'preferred_dimensions',
        'design_notes',
        'design_image',
        'status_notes',
        'date_submitted',
        'approved_at',
        'rejected_at',
        'in_production_at',
        'completed_at',
    ];

    protected $casts = [
        'estimated_price' => 'decimal:2',
        'final_price' => 'decimal:2',
        'date_submitted' => 'datetime',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'in_production_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sidecar(): BelongsTo
    {
        return $this->belongsTo(Sidecar::class);
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class);
    }

    public function accessories(): BelongsToMany
    {
        return $this->belongsToMany(Accessory::class, 'customization_request_accessories')
            ->withPivot('price', 'quantity')
            ->withTimestamps();
    }

    public function requestItems(): HasMany
    {
        return $this->hasMany(CustomizationRequestItem::class);
    }

    public function stockOuts(): HasMany
    {
        return $this->hasMany(StockOut::class);
    }

    public function statusLabel(): string
    {
        return self::STATUSES[$this->status] ?? ucfirst($this->status);
    }

    public static function generateRequestNumber(): string
    {
        $year = now()->format('Y');

        $count = static::whereYear('created_at', now()->year)->count() + 1;

        return 'CR-' . $year . '-' . str_pad((string) $count, 4, '0', STR_PAD_LEFT);
    }
}
