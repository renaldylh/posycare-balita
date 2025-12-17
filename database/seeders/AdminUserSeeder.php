<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create or update default admin
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@posycare.com'],
            [
                'nama' => 'Admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'email_verified_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Create or update requested admin
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@gmail.com'],
            [
                'nama' => 'Admin User',
                'password' => Hash::make('admin123'),
                'role' => 'admin', // Assuming role 'admin' is appropriate
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $this->command->info('Admin users seeded successfully!');
        $this->command->info('1. admin@posycare.com / admin123');
        $this->command->info('2. admin@gmail.com / admin123');
    }
}
