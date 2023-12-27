<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = fake();

        // Determine how many customers you want to create
        $numberOfCustomers = 50; // Example: creating 50 customers

        for ($i = 0; $i < $numberOfCustomers; $i++) {
            DB::table('users')->insert([
                'firstName' => $faker->firstName(),
                'lastName' => $faker->lastName(),
                'email' => $faker->unique()->safeEmail(),
                'mobile' => $faker->phoneNumber(),
                'password' => $faker->password(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
