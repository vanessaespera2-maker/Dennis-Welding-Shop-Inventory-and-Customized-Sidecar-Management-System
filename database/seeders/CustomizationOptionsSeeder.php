<?php

namespace Database\Seeders;

use App\Models\Accessory;
use App\Models\Color;
use App\Models\InventoryItem;
use App\Models\Material;
use Illuminate\Database\Seeder;

class CustomizationOptionsSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedMaterials();
        $this->seedAccessories();
        $this->seedColors();
    }

    private function seedMaterials(): void
    {
        $materials = [
            ['Mild Steel', 'Durable and economical standard steel used for most sidecar frames.', 0, 'STL-BAR-003', 6],
            ['Stainless Steel', 'Rust-resistant premium steel for a polished, long-lasting finish.', 5000, 'STL-SHEET-002', 3],
            ['Aluminum', 'Lightweight corrosion-resistant metal for better fuel efficiency.', 7000, 'STL-ALU-004', 3],
            ['Galvanized Steel', 'Zinc-coated steel offering superior protection against rust.', 3000, 'STL-PIPE-001', 6],
            ['Carbon Steel', 'High-strength steel for heavy-duty and cargo sidecars.', 4500, 'STL-PIPE-001', 8],
        ];

        foreach ($materials as [$name, $description, $price, $sku, $qty]) {
            $item = InventoryItem::where('sku', $sku)->first();
            Material::firstOrCreate(['name' => $name], [
                'description' => $description,
                'additional_price' => $price,
                'inventory_item_id' => $item?->id,
                'quantity_required' => $qty,
                'is_active' => true,
            ]);
        }
    }

    private function seedAccessories(): void
    {
        $accessories = [
            ['LED Lights', 'Waterproof LED headlight and tail light set for added visibility.', 1500, 'ELC-LED-011', 1],
            ['Windshield', 'Clear acrylic windshield that protects passengers from wind and rain.', 1200, null, 1],
            ['Roof', 'Durable steel roof with cover for full protection from the elements.', 3000, null, 1],
            ['Extra Seat', 'Additional padded seat to accommodate another passenger.', 2000, 'ACC-SEAT-014', 1],
            ['Storage Box', 'Lockable steel storage box mounted behind the passenger seat.', 2500, null, 1],
            ['Cargo Rack', 'Sturdy rear cargo rack for extra luggage capacity.', 2000, null, 1],
            ['Side Cover', 'Stylish protective side cover panels for the sidecar body.', 1500, null, 1],
            ['Custom Decals', 'Personalized vinyl decals and graphics for a unique look.', 800, null, 1],
            ['Cushion Upgrade', 'Premium multi-layer foam cushions for maximum comfort.', 1200, 'ACC-CUSH-015', 1],
            ['Speaker System', 'Bluetooth speaker system with handlebar controls.', 1800, null, 1],
        ];

        foreach ($accessories as [$name, $description, $price, $sku, $qty]) {
            $item = $sku ? InventoryItem::where('sku', $sku)->first() : null;
            Accessory::firstOrCreate(['name' => $name], [
                'description' => $description,
                'price' => $price,
                'inventory_item_id' => $item?->id,
                'quantity_required' => $qty,
                'is_active' => true,
            ]);
        }
    }

    private function seedColors(): void
    {
        $colors = [
            ['Black', '#1F2937', 0],
            ['White', '#F9FAFB', 0],
            ['Red', '#DC2626', 500],
            ['Blue', '#2563EB', 500],
            ['Gray', '#6B7280', 0],
            ['Custom Color', '#F59E0B', 1500],
        ];

        foreach ($colors as [$name, $code, $price]) {
            Color::firstOrCreate(['name' => $name], [
                'color_code' => $code,
                'additional_price' => $price,
                'is_active' => true,
            ]);
        }
    }
}
