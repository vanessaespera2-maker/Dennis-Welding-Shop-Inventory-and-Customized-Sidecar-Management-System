<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            SettingsSeeder::class,
            UserSeeder::class,
            SidecarDataSeeder::class,
            InventoryBaseSeeder::class,
            InventoryItemsSeeder::class,
            CustomizationOptionsSeeder::class,
            CustomizationRequestSeeder::class,
        ]);
    }
}
