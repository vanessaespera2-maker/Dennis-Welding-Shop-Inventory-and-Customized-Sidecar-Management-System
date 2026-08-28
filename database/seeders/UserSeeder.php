<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@denniswelding.com'],
            [
                'name' => 'Dennis Admin',
                'password' => 'password',
                'phone' => '0917 123 0001',
                'address' => 'Cabuyao, Laguna',
            ]
        );
        $admin->syncRoles(['super_admin']);

        $staff = User::firstOrCreate(
            ['email' => 'staff@denniswelding.com'],
            [
                'name' => 'Staff Member',
                'password' => 'password',
                'phone' => '0917 123 0002',
                'address' => 'Cabuyao, Laguna',
            ]
        );
        $staff->syncRoles(['staff']);

        $customers = [
            ['Juan Dela Cruz', 'juan@example.com', '0917 123 1001', 'San Pedro, Laguna'],
            ['Maria Santos', 'maria@example.com', '0917 123 1002', 'Biñan, Laguna'],
            ['Pedro Reyes', 'pedro@example.com', '0917 123 1003', 'Santa Rosa, Laguna'],
            ['Ana Gonzales', 'ana@example.com', '0917 123 1004', 'Calamba, Laguna'],
            ['Jose Garcia', 'jose@example.com', '0917 123 1005', 'Los Baños, Laguna'],
            ['Elena Mendoza', 'elena@example.com', '0917 123 1006', 'San Pablo, Laguna'],
            ['Ramon Aquino', 'ramon@example.com', '0917 123 1007', 'Sta. Cruz, Laguna'],
            ['Liza Bautista', 'liza@example.com', '0917 123 1008', 'Cabuyao, Laguna'],
            ['Carlos Villanueva', 'carlos@example.com', '0917 123 1009', 'Lipa, Batangas'],
            ['Grace Domingo', 'grace@example.com', '0917 123 1010', 'San Juan, Batangas'],
        ];

        foreach ($customers as [$name, $email, $phone, $address]) {
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'password' => 'password',
                    'phone' => $phone,
                    'address' => $address,
                ]
            );
            $user->syncRoles(['customer']);
        }
    }
}
