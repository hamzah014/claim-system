<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $departments = [
            [
                'name'          => 'Human Resources',
                'manager_name'  => 'Alice Tan',
                'manager_email' => 'alice.hr@example.com',
                'manager_phone' => '012-3456789',
                'role'          => 'approver',
            ],
            [
                'name'          => 'Finance',
                'manager_name'  => 'Michael Lim',
                'manager_email' => 'michael.finance@example.com',
                'manager_phone' => '013-9876543',
                'role'          => 'approver',
            ],
            [
                'name'          => 'IT Department',
                'manager_name'  => 'Faizal',
                'manager_email' => 'faizal.it@example.com',
                'manager_phone' => '014-1122334',
                'role'          => 'approver',
            ],
        ];
        
        foreach ($departments as $dept) {
            DB::transaction(function () use ($dept) {
                // Create or get Admin for the department
                $admin = Admin::updateOrCreate(
                    ['email' => $dept['manager_email']],
                    [
                        'name' => $dept['manager_name'],
                        'password' => Hash::make('password123'), // default password
                        'role' => $dept['role'],
                    ]
                );

                // Create or update Department with manager_id
                Department::updateOrCreate(
                    ['name' => $dept['name']],
                    [
                        'manager_id' => $admin->id,
                        'manager_name' => $dept['manager_name'],
                        'manager_email' => $dept['manager_email'],
                        'manager_phone' => $dept['manager_phone'],
                    ]
                );
            });
        }
        
    }
}