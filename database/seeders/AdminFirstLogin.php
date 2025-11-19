<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminFirstLogin extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $admin = Admin::firstOrCreate(
            [
                'email' => 'admin@localhost.com',
            ],
            [
                'email_verified_at' => now(),
                'name' => 'Administrator',
                'password' => Hash::make('1234'),
                'role' => 'admin',
                'remember_token' => '',
            ]
        );
        
    }
}