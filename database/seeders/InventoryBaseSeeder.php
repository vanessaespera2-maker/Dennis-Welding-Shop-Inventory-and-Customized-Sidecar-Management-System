<?php

namespace Database\Seeders;

use App\Models\InventoryCategory;
use Illuminate\Database\Seeder;

class InventoryBaseSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['Metals', 'metals'],
            ['Welding Supplies', 'welding-supplies'],
            ['Tires', 'tires'],
            ['Electrical', 'electrical'],
            ['Hardware', 'hardware'],
            ['Accessories', 'accessories'],
            ['Paint', 'paint'],
        ];

        foreach ($categories as [$name, $slug]) {
            InventoryCategory::firstOrCreate(['slug' => $slug], ['name' => $name]);
        }

        $suppliers = [
            ['Steel Depot Inc.', 'Mr. Ramos', '0922 111 2001', 'sales@steeldepot.ph', 'Binan, Laguna'],
            ['Rod Supply Co.', 'Ms. Torres', '0922 111 2002', 'info@rodsupply.ph', 'Sta. Rosa, Laguna'],
            ['Metro Tires Trading', 'Mr. Lim', '0922 111 2003', 'metro.tires@example.com', 'Calamba, Laguna'],
            ['Hardware Solutions PH', 'Ms. Cruz', '0922 111 2004', 'hsph@example.com', 'San Pedro, Laguna'],
        ];

        foreach ($suppliers as [$name, $person, $phone, $email, $address]) {
            \App\Models\Supplier::firstOrCreate(['email' => $email], [
                'name' => $name,
                'contact_person' => $person,
                'phone' => $phone,
                'address' => $address,
            ]);
        }
    }
}
