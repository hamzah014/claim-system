<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AssignAdmin extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $roles = [
            'approver' => 'approver@example.com',
            'hr_admin' => 'hradmin@example.com',
            'payroll' => 'payroll@example.com',
        ];
        
        foreach ($roles as $role => $email) {
            DB::transaction(function () use ($role, $email) {
                Admin::updateOrCreate(
                    ['email' => $email],
                    [
                        'name' => ucfirst(str_replace('_', ' ', $role)),
                        'password' => Hash::make('password'),
                        'role' => $role,
                    ]
                );
            });
        }
    }
}