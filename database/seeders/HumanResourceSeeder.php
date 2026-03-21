<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class HumanResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        DB::table('departments')->insert([
            [
                'name' => 'HR',
                'description' => 'Department Human Resource',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'IT',
                'description' => 'Department Information Technology',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Sales',
                'description' => 'Department Sales',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);

        DB::table('roles')->insert([
            [
                'title' => 'HR',
                'description' => 'Handling team',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Developer',
                'description' => 'Handling codes',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Sales',
                'description' => 'Handling selling',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);


        $employees = [];

        for ($i = 0; $i < 30; $i++) {
            $employees[] = [
                'fullname' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone_number' => $faker->phoneNumber,
                'address' => $faker->address,
                'birth_date' => $faker->dateTimeBetween('-40 years', '-20 years'),
                'hire_date' => $faker->dateTimeBetween('-10 years', 'now'),
                'department_id' => rand(1, 3),
                'role_id' => rand(1, 3),
                'status' => 'active',
                'salary' => $faker->randomFloat(2, 3000, 6000),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ];
        }

        DB::table('employees')->insert($employees);

        $tasks = [];

        for ($i = 0; $i < 15; $i++) {
            $tasks[] = [
                'title' => $faker->sentence,
                'description' => $faker->paragraph,
                'assigned_to' => rand(1, 30),
                'due_date' => $faker->dateTimeBetween('-10 days', 'now'),
                'status' => 'pending',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ];
        }

        DB::table('tasks')->insert($tasks);

        $payroll = [];

        for ($i = 0; $i < 30; $i++) {
            $payroll[] = [
                'employee_id' => rand(1, 30),
                'salary' => $faker->randomFloat(2, 3000, 6000),
                'bonuses' => $faker->randomFloat(2, 3000, 6000),
                'deductions' => $faker->randomFloat(2, 500, 1000),
                'net_salary' => $faker->randomFloat(2, 3000, 6000),
                'pay_date' => $faker->dateTimeBetween('-3 days', 'now'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ];
        }

        DB::table('payrolls')->insert($payroll);

        $presences = [];

        for ($i = 0; $i < 30; $i++) {
            // Ambil tanggal acak dalam 30 hari terakhir
            $date = Carbon::parse($faker->dateTimeBetween('-30 days', 'now'))->format('Y-m-d');

            // Buat waktu check-in antara 08:00 - 09:00
            $checkIn = Carbon::parse($date . ' ' . $faker->time('H:i:s', '09:00'))
                ->setTime(rand(8, 8), rand(0, 59));

            // Buat waktu check-out antara 17:00 - 18:30
            $checkOut = Carbon::parse($date . ' ' . $faker->time('H:i:s', '18:30'))
                ->setTime(rand(17, 18), rand(0, 59));

            $presences[] = [
                'employee_id' => rand(1, 30),
                'check_in'    => $checkIn->format('H:i:s'),
                'check_out'   => $checkOut->format('H:i:s'),
                'date'        => $date,
                'status'      => 'present',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
                'deleted_at'  => null,
            ];
        }

        DB::table('presences')->insert($presences);

        $leave_requests = [];

        for ($i = 0; $i < 30; $i++) {
            $leave_requests[] = [
                'employee_id' => rand(1, 30),
                'leave_type' => $faker->randomElement(['sick', 'vacation', 'maternity', 'paternity']),
                'start_date' => $faker->dateTimeBetween('-30 days', 'now'),
                'end_date' => $faker->dateTimeBetween('-30 days', 'now'),
                'status' => 'pending',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null,
            ];
        }

        DB::table('leave_requests')->insert($leave_requests);
    }
}
