<?php

namespace Database\Seeders;

use App\Models\Sidecar;
use App\Models\SidecarCategory;
use Illuminate\Database\Seeder;

class SidecarDataSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Ordinary', 'slug' => 'ordinary', 'sort_order' => 1, 'description' => 'Affordable everyday sidecar built for practical transport. Simple, sturdy, and budget-friendly.', 'icon' => 'heroicon-m-truck'],
            ['name' => 'Semi Deluxe', 'slug' => 'semi-deluxe', 'sort_order' => 2, 'description' => 'A balanced upgrade with better comfort, extra seating, and improved finishing at a mid-range price.', 'icon' => 'heroicon-m-user-group'],
            ['name' => 'Deluxe', 'slug' => 'deluxe', 'sort_order' => 3, 'description' => 'Premium comfort with cushioned seating, armrests, safety features, and refined styling.', 'icon' => 'heroicon-m-archive-box'],
            ['name' => 'Super Deluxe', 'slug' => 'super-deluxe', 'sort_order' => 4, 'description' => 'The top-of-the-line sidecar with luxury finishing, roof options, premium upholstery, and every extra feature.', 'icon' => 'heroicon-m-paint-brush'],
        ];

        foreach ($categories as $data) {
            SidecarCategory::firstOrCreate(['slug' => $data['slug']], $data);
        }

        SidecarCategory::whereNotIn('slug', ['ordinary', 'semi-deluxe', 'deluxe', 'super-deluxe'])
            ->update(['is_active' => false]);

        $sidecars = [
            ['Dennis Classic 250', 'dennis-classic-250', 'ordinary', 'A timeless ordinary sidecar built for comfort and reliability. Features a reinforced steel frame and a padded single seat.', 18000, 5, 'available'],
            ['Rider Basic', 'rider-basic', 'ordinary', 'The most affordable everyday sidecar — light, simple, and dependable for daily rides.', 14000, 6, 'available'],
            ['Companion Semi Deluxe', 'companion-deluxe', 'semi-deluxe', 'A spacious semi deluxe sidecar with a roomy cabin, cushioned seat, armrests, and extra safety handles for a smooth ride.', 25000, 3, 'available'],
            ['Express Delivery 500', 'express-delivery-500', 'semi-deluxe', 'A semi deluxe model built for delivery riders. Features a waterproof storage box, cargo rack, and an ergonomic seating position.', 32000, 2, 'available'],
            ['Hauler Pro', 'hauler-pro', 'deluxe', 'A heavy-duty deluxe sidecar with a large load platform, reinforced suspension, and premium tie-down points for secure transport.', 30000, 4, 'available'],
            ['Rider Comfort', 'rider-comfort', 'deluxe', 'A premium deluxe sidecar with upholstered seating, roof option, and premium finishing.', 38000, 0, 'unavailable'],
            ['Cargo Max', 'cargo-max', 'super-deluxe', 'The largest super deluxe sidecar available, perfect for heavy loads and business transport needs.', 42000, 0, 'discontinued'],
            ['Luxury Voyager', 'luxury-voyager', 'super-deluxe', 'The flagship super deluxe sidecar. Luxurious upholstery, full roof, sound system, and a flawless custom finish.', 55000, 2, 'available'],
        ];

        foreach ($sidecars as [$name, $slug, $catSlug, $description, $price, $qty, $status]) {
            $category = SidecarCategory::where('slug', $catSlug)->first();
            Sidecar::updateOrCreate(['slug' => $slug], [
                'name' => $name,
                'sidecar_category_id' => $category->id,
                'description' => $description,
                'base_price' => $price,
                'available_quantity' => $qty,
                'status' => $status,
            ]);
        }
    }
}
