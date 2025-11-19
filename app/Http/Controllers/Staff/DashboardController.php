<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Claim;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    
    public function index()
    {
        $setting = SystemSetting::first();

        $date_salary = $setting->date_salary;

        $claimPending = Claim::where('staff_id', Auth::guard('staff')->id())
                    ->whereIn('status',['pending'])
                    ->count();

        $totalHours = Claim::where('staff_id', Auth::guard('staff')->id())
                    ->whereIn('status',['approved','processed','paid'])
                    ->with('detail')
                    ->get()
                    ->sum(function ($claim) {
                        return $claim->detail->total_ot_hrs ?? 0;
                    });

        $data = array(
            'date_salary' => $date_salary,
            'claim_pending' => $claimPending,
            'totalHours' => $totalHours
        );

        return view('staff.dashboard', compact('data'));
    }

}