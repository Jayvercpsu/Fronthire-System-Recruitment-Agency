<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Seed the application's database with the default admin account.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@fronthire.ca'],
            [
                'first_name' => 'FrontHire',
                'last_name' => 'Admin',
                'role' => 'admin',
                'phone' => '+1 (403) 702-0088',
                'email_verified_at' => now(),
                'password' => Hash::make('Admin@12345!'),
            ]
        );
    }
}
