<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\PublicHolidayDataTable;
use App\Http\Controllers\Controller;
use App\Models\PublicHoliday;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PublicHolidayController extends Controller
{
    public function index(PublicHolidayDataTable $dataTable)
    {
        return $dataTable->render('admin.holiday.index');
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

        $findData = PublicHoliday::where('id', $request->id)->first();

        return response()->json([
            'success' => true,
            'data' => $findData
        ], 200);

    }
    
    
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'assign_date' => 'required',
        ]);

        try {
            
            DB::beginTransaction();
            $data = new PublicHoliday();
            $data->name = $request->name;
            $data->assign_date = $request->assign_date;
            $data->save();

            DB::commit();

            return redirect()->route('admin.holiday.index')->with('success', 'Public Holiday submitted successfully.');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Error ' . $th->getMessage());
        }

    }

    public function update(Request $request, PublicHoliday $data)
    {

        $request->validate([
            'name' => 'required',
            'assign_date' => 'required',
        ]);

        try {
            
            DB::beginTransaction();

            $data->update([
                'name' => $request->name,
                'assign_date' => $request->assign_date
            ]);

            DB::commit();
            
            return redirect()->route('admin.holiday.index')->with('success', 'Public Holiday updated successfully.');
            
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Error ' . $th->getMessage());
        }

    }

    public function delete(PublicHoliday $holiday)
    {
        try {

            DB::beginTransaction();
            
            $holiday->delete();

            DB::commit();

            return redirect()->route('admin.holiday.index')->with('success', 'Public Holiday deleted successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error: ' . $th->getMessage());
        }
    }
}