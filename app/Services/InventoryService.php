<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\InventoryItem;
use App\Models\InventoryTransaction;
use Illuminate\Support\Facades\DB;

class InventoryService
{
    public function stockIn(
        InventoryItem $item,
        float $quantity,
        ?string $referenceNumber = null,
        ?string $reason = null,
        ?string $notes = null,
        ?float $unitCost = null,
        ?\DateTimeInterface $date = null
    ): InventoryTransaction {
        return DB::transaction(function () use ($item, $quantity, $referenceNumber, $reason, $notes, $unitCost, $date) {
            $previous = (float) $item->current_stock;
            $new = $previous + $quantity;

            $item->update([
                'current_stock' => $new,
                'unit_cost' => $unitCost !== null ? $unitCost : $item->unit_cost,
            ]);

            $transaction = InventoryTransaction::create([
                'inventory_item_id' => $item->id,
                'type' => InventoryTransaction::TYPE_STOCK_IN,
                'quantity' => $quantity,
                'previous_stock' => $previous,
                'new_stock' => $new,
                'reason' => $reason ?? 'Stock received',
                'reference_number' => $referenceNumber,
                'user_id' => auth()->id(),
                'date' => $date ?? now(),
                'notes' => $notes,
            ]);

            ActivityLog::log('Stock In', "{$quantity} {$item->unit} of {$item->name} was added to inventory.", $item, [
                'quantity' => $quantity,
                'new_stock' => $new,
            ]);

            return $transaction;
        });
    }

    public function stockOut(
        InventoryItem $item,
        float $quantity,
        ?string $reason = null,
        ?int $customizationRequestId = null,
        ?string $notes = null,
        ?\DateTimeInterface $date = null
    ): InventoryTransaction {
        return DB::transaction(function () use ($item, $quantity, $reason, $customizationRequestId, $notes, $date) {
            $previous = (float) $item->current_stock;

            if ($quantity > $previous) {
                throw new \InvalidArgumentException(
                    "Insufficient stock for {$item->name}. Available: {$previous} {$item->unit}."
                );
            }

            $new = $previous - $quantity;

            $item->update(['current_stock' => $new]);

            $transaction = InventoryTransaction::create([
                'inventory_item_id' => $item->id,
                'type' => InventoryTransaction::TYPE_STOCK_OUT,
                'quantity' => $quantity,
                'previous_stock' => $previous,
                'new_stock' => $new,
                'reason' => $reason ?? 'Stock issued',
                'reference_number' => null,
                'user_id' => auth()->id(),
                'date' => $date ?? now(),
                'notes' => $notes,
            ]);

            ActivityLog::log('Stock Out', "{$quantity} {$item->unit} of {$item->name} was issued from inventory.", $item, [
                'quantity' => $quantity,
                'new_stock' => $new,
            ]);

            return $transaction;
        });
    }

    public function adjust(
        InventoryItem $item,
        float $newStock,
        ?string $reason = null,
        ?string $notes = null
    ): InventoryTransaction {
        return DB::transaction(function () use ($item, $newStock, $reason, $notes) {
            $previous = (float) $item->current_stock;
            $quantity = $newStock - $previous;

            $item->update(['current_stock' => $newStock]);

            $transaction = InventoryTransaction::create([
                'inventory_item_id' => $item->id,
                'type' => InventoryTransaction::TYPE_ADJUSTMENT,
                'quantity' => abs($quantity),
                'previous_stock' => $previous,
                'new_stock' => $newStock,
                'reason' => $reason ?? 'Manual adjustment',
                'user_id' => auth()->id(),
                'date' => now(),
                'notes' => $notes,
            ]);

            ActivityLog::log('Adjustment', "{$item->name} stock adjusted from {$previous} to {$newStock}.", $item, [
                'previous' => $previous,
                'new' => $newStock,
            ]);

            return $transaction;
        });
    }
}
