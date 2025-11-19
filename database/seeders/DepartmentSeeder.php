<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
            ],
            [
                'name'          => 'Finance',
                'manager_name'  => 'Michael Lim',
                'manager_email' => 'michael.finance@example.com',
                'manager_phone' => '013-9876543',
            ],
            [
                'name'          => 'IT Department',
                'manager_name'  => 'Faizal',
                'manager_email' => 'faizal.it@example.com',
                'manager_phone' => '014-1122334',
            ],
        ];

        foreach ($departments as $dept) {
            Department::firstOrCreate(
                ['name' => $dept['name']],
                $dept
            );
        }
        
    }
}