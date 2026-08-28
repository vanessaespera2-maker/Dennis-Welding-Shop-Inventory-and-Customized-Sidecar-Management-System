<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public const PERMISSIONS = [
        'dashboard.view',
        'users.manage',
        'roles.manage',
        'settings.manage',
        'activity_logs.view',
        'inventory.categories.manage',
        'inventory.items.manage',
        'inventory.transactions.view',
        'inventory.low_stock.view',
        'stock_in.manage',
        'stock_out.manage',
        'sidecars.manage',
        'sidecar_categories.manage',
        'materials.manage',
        'accessories.manage',
        'colors.manage',
        'customization_requests.manage',
        'customers.view',
        'suppliers.manage',
        'reports.view',
    ];

    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        foreach (self::PERMISSIONS as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $superAdmin = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $superAdmin->syncPermissions(self::PERMISSIONS);

        $staff = Role::firstOrCreate(['name' => 'staff', 'guard_name' => 'web']);
        $staff->syncPermissions([
            'dashboard.view',
            'inventory.categories.manage',
            'inventory.items.manage',
            'inventory.transactions.view',
            'inventory.low_stock.view',
            'stock_in.manage',
            'stock_out.manage',
            'sidecars.manage',
            'sidecar_categories.manage',
            'materials.manage',
            'accessories.manage',
            'colors.manage',
            'customization_requests.manage',
            'suppliers.manage',
            'reports.view',
        ]);

        $customer = Role::firstOrCreate(['name' => 'customer', 'guard_name' => 'web']);
        $customer->syncPermissions([]);
    }
}
