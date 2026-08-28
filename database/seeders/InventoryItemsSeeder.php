<?php

namespace Database\Seeders;

use App\Models\InventoryCategory;
use App\Models\InventoryItem;
use App\Models\Supplier;
use App\Services\InventoryService;
use Illuminate\Database\Seeder;

class InventoryItemsSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['Steel Pipe', 'STL-PIPE-001', 'metals', 'sales@steeldepot.ph', '1.5-inch galvanized steel pipe, 6m length.', 'meters', 120, 20, 350],
            ['Stainless Steel Sheet', 'STL-SHEET-002', 'metals', 'sales@steeldepot.ph', '4x8 ft stainless steel sheet, 16 gauge.', 'pcs', 25, 5, 2500],
            ['Mild Steel Bar', 'STL-BAR-003', 'metals', 'sales@steeldepot.ph', 'Square mild steel bar 10mm x 6m.', 'meters', 200, 30, 180],
            ['Aluminum Sheet', 'STL-ALU-004', 'metals', 'sales@steeldepot.ph', '4x8 ft aluminum sheet 18 gauge.', 'pcs', 15, 5, 1800],
            ['Welding Rod E6013', 'WLD-ROD-005', 'welding-supplies', 'info@rodsupply.ph', '3/32 inch welding rods, 5kg box.', 'kg', 80, 15, 120],
            ['Welding Wire', 'WLD-WIRE-006', 'welding-supplies', 'info@rodsupply.ph', 'MIG welding wire 0.8mm, 5kg spool.', 'kg', 40, 10, 150],
            ['Bolt M10', 'HDW-BOLT-007', 'hardware', 'hsph@example.com', 'Hex bolt M10 x 30mm, per piece.', 'pcs', 500, 100, 8],
            ['Nut M10', 'HDW-NUT-008', 'hardware', 'hsph@example.com', 'Hex nut M10, per piece.', 'pcs', 500, 100, 5],
            ['Sidecar Tire', 'TIR-SIDE-009', 'tires', 'metro.tires@example.com', '3.00-10 tubeless sidecar tire.', 'pcs', 20, 6, 900],
            ['Rim 10 inch', 'TIR-RIM-010', 'tires', 'metro.tires@example.com', '10-inch sidecar wheel rim.', 'pcs', 12, 4, 1500],
            ['LED Light Set', 'ELC-LED-011', 'electrical', 'hsph@example.com', 'Waterproof LED headlight and signal set.', 'sets', 30, 8, 1200],
            ['Automotive Paint Black', 'PNT-BLK-012', 'paint', 'hsph@example.com', 'High-gloss automotive paint, 1 liter.', 'liters', 25, 5, 650],
            ['Automotive Paint Red', 'PNT-RED-013', 'paint', 'hsph@example.com', 'High-gloss automotive paint, 1 liter.', 'liters', 20, 5, 650],
            ['Sidecar Seat', 'ACC-SEAT-014', 'accessories', null, 'Padded sidecar passenger seat with upholstery.', 'pcs', 10, 3, 1500],
            ['Cushion Set', 'ACC-CUSH-015', 'accessories', null, 'Premium foam cushion set for sidecar seating.', 'sets', 8, 2, 800],
        ];

        foreach ($items as [$name, $sku, $catSlug, $supplierEmail, $description, $unit, $stock, $min, $cost]) {
            $category = InventoryCategory::where('slug', $catSlug)->first();
            $supplier = $supplierEmail ? Supplier::where('email', $supplierEmail)->first() : null;

            $item = InventoryItem::firstOrCreate(
                ['sku' => $sku],
                [
                    'name' => $name,
                    'inventory_category_id' => $category->id,
                    'supplier_id' => $supplier?->id,
                    'description' => $description,
                    'unit' => $unit,
                    'current_stock' => 0,
                    'minimum_stock' => $min,
                    'unit_cost' => $cost,
                    'is_active' => true,
                ]
            );

            app(InventoryService::class)->stockIn(
                $item,
                $stock,
                'INIT-' . $sku,
                'Initial stock',
                'Initial inventory setup.',
                $cost,
                now()->subMonths(rand(1, 4))
            );
        }
    }
}
