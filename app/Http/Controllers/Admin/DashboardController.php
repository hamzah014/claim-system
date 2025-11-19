<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Claim;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{    

    public function index()
    {

        $view = 'admin.dashboard';
        $data = [];

        $admin = Auth::guard('admin')->user();
        
        if(Auth::guard('admin')->user()->role == 'admin')
        {
            $claimTotal = Claim::count();
            $userTotal = User::count();
            $departmentTotal = Department::count();

            $view = 'admin.dashboard.admin';
            $data = array(
                'staff_count' => $userTotal,
                'claim_count' => $claimTotal,
                'department_count' => $departmentTotal,
            );
        }
        elseif(Auth::guard('admin')->user()->role == 'approver')
        {
            $view = 'admin.dashboard.approver';

            $claimPending = Claim::whereIn('status',['pending'])
                        ->where('manager_id', $admin->id)
                        ->count();
            $data = array(
                'pending_approval_count' => $claimPending
            );
        }
        elseif(Auth::guard('admin')->user()->role == 'hr_admin')
        {
            $view = 'admin.dashboard.hrAdmin';

            $total_pending = Claim::whereIn('status',['pending'])->count();
            $total_approved = Claim::whereIn('status',['approved'])->count();
            $total_processed = Claim::whereIn('status',['processed'])->count();
            $total_rejected = Claim::whereIn('status',['paid'])->count();
            $data = array(
                'total_pending'     => $total_pending,
                'total_approved'    => $total_approved,
                'total_processed'   => $total_processed,
                'total_rejected'    => $total_rejected,
            );
        }
        elseif(Auth::guard('admin')->user()->role == 'payroll')
        {
            $view = 'admin.dashboard.payroll';
            $data = [];
        }      

        return view($view, compact('data'));
    }

}