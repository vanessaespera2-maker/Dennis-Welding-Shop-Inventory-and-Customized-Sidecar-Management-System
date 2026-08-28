<?php

namespace Database\Seeders;

use App\Models\Accessory;
use App\Models\Color;
use App\Models\CustomizationRequest;
use App\Models\Material;
use App\Models\Sidecar;
use App\Models\User;
use Illuminate\Database\Seeder;

class CustomizationRequestSeeder extends Seeder
{
    public function run(): void
    {
        $customers = User::role('customer')->get();
        $sidecars = Sidecar::all();
        $materials = Material::all();
        $colors = Color::all();
        $accessories = Accessory::all();

        $statuses = [
            'pending', 'reviewing', 'approved', 'in_production',
            'ready_for_pickup', 'completed', 'cancelled', 'rejected',
        ];

        foreach ($customers->take(10) as $index => $customer) {
            $sidecar = $sidecars->random();
            $material = $materials->random();
            $color = $colors->random();
            $selectedAccessories = $accessories->random(rand(0, 4));

            $estimated = (float) $sidecar->base_price
                + (float) $material->additional_price
                + (float) $color->additional_price
                + $selectedAccessories->sum('price');

            $status = $statuses[$index % count($statuses)];
            $final = in_array($status, ['in_production', 'ready_for_pickup', 'completed'])
                ? $estimated * (rand(0, 10) > 5 ? 1 : 1.05)
                : null;

            $request = CustomizationRequest::create([
                'request_number' => CustomizationRequest::generateRequestNumber(),
                'user_id' => $customer->id,
                'sidecar_id' => $sidecar->id,
                'material_id' => $material->id,
                'color_id' => $color->id,
                'estimated_price' => $estimated,
                'final_price' => $final ? round($final, 2) : null,
                'status' => $status,
                'special_instructions' => 'Please add extra reinforcement on the mounting brackets.',
                'preferred_dimensions' => rand(150, 180) . 'cm x ' . rand(90, 110) . 'cm',
                'design_notes' => 'Customer prefers a matte finish and a compact look.',
                'date_submitted' => now()->subDays(rand(1, 120))->subHours(rand(1, 12)),
                'approved_at' => in_array($status, ['approved', 'in_production', 'ready_for_pickup', 'completed']) ? now()->subDays(rand(1, 60)) : null,
                'in_production_at' => in_array($status, ['in_production', 'ready_for_pickup', 'completed']) ? now()->subDays(rand(1, 30)) : null,
                'completed_at' => in_array($status, ['completed']) ? now()->subDays(rand(1, 10)) : null,
                'rejected_at' => $status === 'rejected' ? now()->subDays(rand(1, 30)) : null,
            ]);

            foreach ($selectedAccessories as $accessory) {
                $request->accessories()->attach($accessory->id, [
                    'price' => $accessory->price,
                    'quantity' => 1,
                ]);
            }
        }
    }
}
