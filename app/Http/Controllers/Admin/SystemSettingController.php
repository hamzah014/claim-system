<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class SystemSettingController extends Controller
{
    
    public function index()
    {
        $setting = SystemSetting::first();

        return view('admin.system-setting.index', compact('setting'));

    }
    
    public function update(Request $request, SystemSetting $setting)
    {
        
        $validated = $request->validate([
            'submit_day_allow'    => 'required|integer',
            'date_salary'         => 'required|integer',
            'working_start'       => 'required',
            'working_end'         => 'required',

            'meal_allowance'      => 'required|numeric',

            'ot_rate'             => 'required|numeric',
            'ot_weekend_rate'     => 'required|numeric',
            'ot_holiday_rate'     => 'required|numeric',

            'first_ot_meal_hrs'   => 'required|integer',
            'first_ot_meal_time'  => 'required',
            'extra_ot_meal_hrs'   => 'required|integer',
        ]);

        // Update the model
        $setting->update($validated);

        return redirect()->back()->with('success', 'System settings updated successfully.');
    }


}