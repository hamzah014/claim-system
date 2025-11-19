<?php

namespace App\Services;

use App\Models\Department;

class DropdownService
{
    public function claimType()
    {
        return [
            'ot' => __('Overtime'),
            'meal' => __('Meal Allowance'),
            'both' => __('Both'),
        ];
    }

    public function workLocation()
    {
        return [
            'office' => __('In-Office'),
            'outside' => __('Outside-of-Office'),
        ];
    }

    public function claimStatus()
    {
        return [
            'draft' => __('Draft'),
            'approved' => __('Approved'),
            'rejected' => __('Rejected'),
        ];
    }
    
    public function departmentList()
    {
        return Department::orderBy('name')
            ->pluck('name', 'id')
            ->toArray();
    }
    
    public function adminList()
    {
        return [
            'admin' => __('Admin'),
            'approver' => __('Approver'),
            'hr_admin' => __('HR Admin'),
            'payroll' => __('Payroll Admin'),
        ];
    }
}