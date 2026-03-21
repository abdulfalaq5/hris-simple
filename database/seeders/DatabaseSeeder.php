<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed employees, roles, departments dulu
        $this->call([
            HumanResourceSeeder::class,
        ]);

        // Setelah employees ada, baru insert users
        // User HR — employee_id = 3
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'employee_id'       => 3,
                'name'              => 'User HR',
                'password'          => '$2y$12$vytKzrKHVRWdC/1Gj0hl4.L4WYCzdob07SFS3Hq7V1/w807q8d7Fy',
                'email_verified_at' => '2026-03-21 20:40:33',
            ]
        );

        // User Developer — employee_id = 4
        User::firstOrCreate(
            ['email' => 'developer@mail.com'],
            [
                'employee_id'       => 4,
                'name'              => 'User Develop',
                'password'          => '$2y$12$vytKzrKHVRWdC/1Gj0hl4.L4WYCzdob07SFS3Hq7V1/w807q8d7Fy',
                'email_verified_at' => '2026-03-21 20:40:33',
            ]
        );

        // User Sales/Employee — employee_id = 1
        User::firstOrCreate(
            ['email' => 'emp@example.com'],
            [
                'employee_id'       => 1,
                'name'              => 'User Employee',
                'password'          => '$2y$12$vytKzrKHVRWdC/1Gj0hl4.L4WYCzdob07SFS3Hq7V1/w807q8d7Fy',
                'email_verified_at' => '2026-03-21 20:40:33',
            ]
        );
    }
}
