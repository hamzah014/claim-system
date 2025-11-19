<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\DropdownService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    protected $dropdownService;
    
    public function __construct()
    {
        $this->dropdownService = new DropdownService();
    }

    public function index()
    {
        $departmentList = $this->dropdownService->departmentList();
        $user = Auth::guard('staff')->user();
        return view('staff.profile', compact('user','departmentList'));
        
    }

    public function update(Request $request, User $user)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'department_id' => 'required|integer',
        ]);

        try {
            DB::beginTransaction();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->department_id = $request->department_id;
            $user->save();

            DB::commit();

            return redirect()->route('profile.index')->with('success', 'Profile updated successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'An error occurred while updating the staff.');
            //throw $th;
        }
    }

    public function update_password(Request $request, User $user)
    {

        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password updated successfully.');
        
    }

    
}