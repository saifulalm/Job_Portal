<?php

namespace Database\Seeders;

use App\Models\CompanyProfile;
use App\Models\User;
use App\Models\Job;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create a default Admin User
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Create a default Employee User
        User::factory()->create([
            'name' => 'Employee User',
            'email' => 'employee@example.com',
            'password' => Hash::make('password'),
            'role' => 'employee',
        ]);

        // 3. Create 15 companies, and for each company, create between 3 and 10 jobs
        CompanyProfile::factory(15)
            ->has(Job::factory()->count(rand(3, 10)))
            ->create();

        $this->command->info('Database seeded successfully!');
        $this->command->info('Default users created:');
        $this->command->info('Admin: admin@example.com | password: password');
        $this->command->info('Employee: employee@example.com | password: password');
    }
}
