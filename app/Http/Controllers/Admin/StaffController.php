<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\StaffDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\DropdownService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    protected $dropdownService;

    public function __construct()
    {
        $this->dropdownService = new DropdownService();
    }

    public function index(StaffDataTable $dataTable)
    {
        return $dataTable->render('admin.staff.index');
    }

    public function create()
    {
        $departmentList = $this->dropdownService->departmentList();
        
        $formUrl = route('admin.staff.store');
        $type = 'create';
        $staff = new User();
        return view('admin.staff.create', 
        compact(
            'departmentList',
            'formUrl', 'staff', 'type'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'department_id' => 'required|integer',
            'req_driving' => 'required|boolean',
            'password' => 'required|string|min:8',
        ]);

        try {
            DB::beginTransaction();
            $staff = new User();
            $staff->name = $request->name;
            $staff->email = $request->email;
            $staff->department_id = $request->department_id;
            $staff->req_driving = $request->req_driving;
            $staff->password = Hash::make($request->password);
            $staff->save();

            DB::commit();

            return redirect()->route('admin.staff.index')->with('success', 'Staff created successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'An error occurred while creating the staff.');
            //throw $th;
        }
    }

    public function edit(User $staff)
    {
        $departmentList = $this->dropdownService->departmentList();
        $formUrl = route('admin.staff.update', $staff);
        $type = 'edit';
        return view('admin.staff.edit', 
        compact(
            'departmentList',
            'staff', 'formUrl', 'type'
        ));
    }

    public function update(Request $request, User $staff)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$staff->id,
            'department_id' => 'required|integer',
            'req_driving' => 'required|boolean',
            'password' => 'nullable|string|min:8',
        ]);

        try {
            DB::beginTransaction();
            $staff->name = $request->name;
            $staff->email = $request->email;
            $staff->department_id = $request->department_id;
            $staff->req_driving = $request->req_driving;
            if ($request->filled('password')) {
                $staff->password = Hash::make($request->password);
            }
            $staff->save();

            DB::commit();

            return redirect()->route('admin.staff.index')->with('success', 'Staff updated successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'An error occurred while updating the staff.');
            //throw $th;
        }
    }

    public function delete(User $staff)
    {
        try {
            $staff->delete();
            return redirect()->route('admin.staff.index')->with('success', 'Staff deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->route('admin.staff.index')->with('error', 'An error occurred while deleting the staff.');
            //throw $th;
        }
    }
        
}