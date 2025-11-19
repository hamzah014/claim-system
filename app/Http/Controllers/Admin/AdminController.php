<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\AdminDataTable;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Services\DropdownService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    protected $dropdownServices;

    public function __construct() {
        $this->dropdownServices = new DropdownService();
    }
    
    public function index(AdminDataTable $dataTable)
    {
        $adminRoleList = $this->dropdownServices->adminList();
        return $dataTable->render('admin.index', compact('adminRoleList'));
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

        $findData = Admin::where('id', $request->id)->first();

        return response()->json([
            'success' => true,
            'data' => $findData
        ], 200);

    }
    
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required',
        ]);

        try {
            
            DB::beginTransaction();
            $data = new Admin();
            $data->name = $request->name;
            $data->email = $request->email;
            $data->password = Hash::make($request->password);
            $data->role = $request->role;
            $data->save();

            DB::commit();

            if($request->action == 'submit') {
                return redirect()->route('admin.account.index')->with('success', 'Admin submitted successfully.');
            } else {
                return redirect()->route('admin.account.index')->with('success', 'Admin updated successfully.');
            }
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Error ' . $th->getMessage());
        }

    }

    public function update(Request $request, Admin $admin)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
        ]);

        try {
            
            DB::beginTransaction();
            
            $admin->name = $request->name;
            $admin->email = $request->email;
            $admin->role = $request->role;
            $admin->save();

            DB::commit();

            if($request->action == 'submit') {
                return redirect()->route('admin.account.index')->with('success', 'Admin submitted successfully.');
            } else {
                return redirect()->route('admin.account.index')->with('success', 'Admin updated successfully.');
            }
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Error ' . $th->getMessage());
        }

    }

    public function delete(Admin $admin)
    {
        try {

            DB::beginTransaction();
            $admin->delete();

            DB::commit();

            return redirect()->route('admin.account.index')->with('success', 'Department deleted successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error: ' . $th->getMessage());
        }
    }
}