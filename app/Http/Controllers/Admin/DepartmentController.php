<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\DepartmentDataTable;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Department;
use App\Models\User;
use App\Services\DropdownService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{

    protected $dropdownService;

    public function __construct()
    {
        $this->dropdownService = new DropdownService();
    }

    public function index(DepartmentDataTable $dataTable)
    {
        $adminApprover = Admin::where('role', 'approver')->get();
        return $dataTable->render('admin.department.index', compact('adminApprover'));
    }

    public function getData(Request $request)
    {

        $checkRequired = [
            'id'  => ['required'],
        ];

        $validator = Validator::make($request->all(), $checkRequired);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'error' => $validator->getMessageBag()->toArray()
            ], 400);
        }

        $findDepartment = Department::where('id', $request->id)->first();

        return response()->json([
            'success' => true,
            'data' => $findDepartment
        ], 200);
    }


    public function store(Request $request)
    {

        $request->validate([
            'depart_name' => 'required',
            'manager_id' => 'required',
        ]);

        try {

            DB::beginTransaction();
            $department = new Department();
            $department->name = $request->depart_name;
            $department->manager_id = $request->manager_id;

            $getAdmin = Admin::where('id', $request->manager_id)->first();

            $department->manager_name = $getAdmin->name ?? "";
            $department->manager_email = $getAdmin->email ?? "";
            $department->save();

            DB::commit();

            if ($request->action == 'submit') {
                return redirect()->route('admin.department.index')->with('success', 'Department submitted successfully.');
            } else {
                return redirect()->route('admin.department.index')->with('success', 'Department updated successfully.');
            }
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Error ' . $th->getMessage());
        }
    }

    public function update(Request $request, Department $department)
    {

        $request->validate([
            'depart_name' => 'required',
            'manager_id' => 'required',
        ]);

        try {

            DB::beginTransaction();

            $department->name = $request->depart_name;
            $department->manager_id = $request->manager_id;

            $getAdmin = Admin::where('id', $request->manager_id)->first();

            $department->manager_name = $getAdmin->name ?? "";
            $department->manager_email = $getAdmin->email ?? "";
            $department->save();

            DB::commit();

            if ($request->action == 'submit') {
                return redirect()->route('admin.department.index')->with('success', 'Department submitted successfully.');
            } else {
                return redirect()->route('admin.department.index')->with('success', 'Department updated successfully.');
            }
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Error ' . $th->getMessage());
        }
    }

    public function delete(Department $department)
    {
        try {

            $detectUsage = User::where('department_id', $department->id)->first();

            if ($detectUsage) {
                return redirect()->route('admin.department.index')->with('success', 'The department is still in usage. Please remove first before delete.');
            }

            DB::beginTransaction();
            $department->delete();

            DB::commit();

            return redirect()->route('admin.department.index')->with('success', 'Department deleted successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error: ' . $th->getMessage());
        }
    }
}