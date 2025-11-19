<?php

namespace App\Http\Controllers\Staff;

use App\DataTables\ClaimDataTable;
use App\DataTables\StaffClaimDataTable;
use App\Http\Controllers\Controller;
use App\Mail\ClaimApprovalPending;
use App\Mail\ClaimRejected;
use App\Mail\SubmissionConfirmed;
use App\Models\Admin;
use App\Models\AuditTrail;
use App\Models\Claim;
use App\Models\ClaimDetail;
use App\Models\ClaimFile;
use App\Models\PublicHoliday;
use App\Models\SystemSetting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ClaimController extends Controller
{

    protected $setting;
    protected $user;

    public function __construct()
    {
        $this->setting = SystemSetting::first();
        $this->user = Auth::guard('staff')->user();
    }

    public function index(StaffClaimDataTable $dataTable)
    {
        return $dataTable->render('staff.claims.index');
    }

    public function create()
    {
        if (!$this->user->department) {
            return redirect()
                ->route('profile.index')
                ->with('error', 'Please select your department first.');
        }

        $formUrl = route('claims.store');
        $claim = new Claim();
        return view('staff.claims.create', compact('formUrl', 'claim'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'type' => 'required|string',
            'work_location' => 'required|string',
            'duty_date' => 'required|date',
            'duty_start_time' => 'required',
            'duty_end_time' => 'required',
        ]);

        if ($request->work_location == 'outside') {
            $request->validate([
                'travel_start_time' => 'required',
                'travel_end_time' => 'required',
                'travel_origin' => 'required|string',
                'travel_destination' => 'required|string',
                'travel_purpose' => 'required|string',
            ]);
        }

        $request->validate([
            'attend_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5000',
            'supporting_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5000',
        ]);

        try {

            DB::beginTransaction();

            $allowDayApply = $this->setting->submit_day_allow;
            $salaryDay = $this->setting->date_salary;

            $dutyDate = Carbon::parse($request->duty_date);
            $today = now();

            if ($today->day <= $salaryDay) {
                $cycleSalaryDate = Carbon::create($today->year, $today->month, $salaryDay);
            } else {
                $cycleSalaryDate = Carbon::create($today->year, $today->month, $salaryDay)->addMonth();
            }

            $allowedStart = $cycleSalaryDate->copy()->subDays($allowDayApply);

            if ($dutyDate->lt($allowedStart) || $dutyDate->gt($cycleSalaryDate)) {
                DB::rollBack();
                return redirect()->back()->withErrors([
                    'duty_date' => "Duty date must be between " .
                        $allowedStart->format('d M Y') . " and " .
                        $cycleSalaryDate->format('d M Y') . "."
                ])->withInput();
            }

            $claim = new Claim();
            $claim->reference_no = $claim->generateReferenceNo();
            $claim->staff_id = $this->user->id;
            $claim->manager_id = $this->user->department->manager_id;
            $claim->type = $request->type;
            $claim->duty_date = $request->duty_date;
            $claim->duty_start_time = $request->duty_start_time;
            $claim->duty_end_time = $request->duty_end_time;
            $claim->work_location = $request->work_location;

            if ($request->work_location == 'outside') {
                $claim->travel_start_time = $request->travel_start_time;
                $claim->travel_end_time = $request->travel_end_time;
                $claim->travel_origin = $request->travel_origin;
                $claim->travel_destination = $request->travel_destination;
                $claim->travel_purpose = $request->travel_purpose;
            }

            $claim->status = $request->action == 'submit' ? 'pending' : 'draft';
            $claim->save();

            // save attendance file
            $attend_uuid = Str::uuid();
            $attend_type = 'attend';
            $attend_file = $request->file('attend_file');
            $attend_originalName = $attend_file->getClientOriginalName();
            $attend_file_ext = $attend_file->getClientOriginalExtension();
            $attend_file_name = "attend_" . $claim->reference_no . "_" . time();
            $attend_file_path = 'uploads/claims/' . $claim->reference_no . '/' . $attend_file_name;
            Storage::disk('public')->put($attend_file_path, File::get($attend_file));

            $claimFile = new ClaimFile();
            $claimFile->claim_id = $claim->id;
            $claimFile->file_uuid = $attend_uuid;
            $claimFile->type = $attend_type;
            $claimFile->file_path = $attend_file_path;
            $claimFile->file_name = $attend_file_name;
            $claimFile->file_ext = $attend_file_ext;
            $claimFile->save();

            // save supporting file
            $supporting_uuid = Str::uuid();
            $supporting_type = 'support';
            $supporting_file = $request->file('supporting_file');
            $supporting_originalName = $supporting_file->getClientOriginalName();
            $supporting_file_ext = $supporting_file->getClientOriginalExtension();
            $supporting_file_name = "support_" . $claim->reference_no . "_" . time();
            $supporting_file_path = 'uploads/claims/' . $claim->reference_no . '/' . $supporting_file_name;
            Storage::disk('public')->put($supporting_file_path, File::get($supporting_file));

            $claimFile = new ClaimFile();
            $claimFile->claim_id = $claim->id;
            $claimFile->file_uuid = $supporting_uuid;
            $claimFile->type = $supporting_type;
            $claimFile->file_path = $supporting_file_path;
            $claimFile->file_name = $supporting_file_name;
            $claimFile->file_ext = $supporting_file_ext;
            $claimFile->save();

            // save to audit trail
            $auditTrail = new AuditTrail();
            $auditTrail->user_id = Auth::id();
            $auditTrail->transaction_id = $claim->id;
            $auditTrail->user_role = 'staff';
            $auditTrail->action = 'create_claim';
            $auditTrail->save();

            if ($request->action == 'submit') {
                $auditTrail = new AuditTrail();
                $auditTrail->user_id = Auth::id();
                $auditTrail->transaction_id = $claim->id;
                $auditTrail->user_role = 'staff';
                $auditTrail->action = 'submit_claim';
                $auditTrail->save();

                $returnCalculate = $this->calculateClaim($claim);
                if ($returnCalculate['success'] == false) {
                    DB::rollBack();
                    return redirect()->back()->withInput()->with('error', 'Error ' . $returnCalculate['error']);
                }

                $receiverEmail = Auth::user()->email;

                $sendEmail = $this->sendEmailSubmission($claim, $receiverEmail);
                $sendEmailApprove = $this->sendEmailSubmissionApprover($claim);
            }

            DB::commit();

            if ($request->action == 'submit') {
                return redirect()->route('claims.index')->with('success', 'Claim submitted successfully.');
            } else {
                return redirect()->route('claims.index')->with('success', 'Claim updated successfully.');
            }
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->back()->with('error', 'Error ' . $th->getMessage());
        }
    }

    public function edit(Claim $claim)
    {
        $formUrl = route('claims.update', $claim);
        return view('staff.claims.edit', compact('formUrl', 'claim'));
    }

    public function update(Request $request, Claim $claim)
    {

        $request->validate([
            'type' => 'required|string',
            'work_location' => 'required|string',
            'duty_date' => 'required|date',
            'duty_start_time' => 'required',
            'duty_end_time' => 'required',
        ]);

        if ($request->work_location == 'outside') {
            $request->validate([
                'travel_start_time' => 'required',
                'travel_end_time' => 'required',
                'travel_origin' => 'required|string',
                'travel_destination' => 'required|string',
                'travel_purpose' => 'required|string',
            ]);
        }

        $request->validate([
            'attend_file' => 'file|mimes:pdf,jpg,jpeg,png|max:5000',
            'supporting_file' => 'file|mimes:pdf,jpg,jpeg,png|max:5000',
        ]);

        try {

            DB::beginTransaction();

            $claim->type = $request->type;
            $claim->duty_date = $request->duty_date;
            $claim->duty_start_time = $request->duty_start_time;
            $claim->duty_end_time = $request->duty_end_time;
            $claim->work_location = $request->work_location;

            if ($request->work_location == 'outside') {
                $claim->travel_start_time = $request->travel_start_time;
                $claim->travel_end_time = $request->travel_end_time;
                $claim->travel_origin = $request->travel_origin;
                $claim->travel_destination = $request->travel_destination;
                $claim->travel_purpose = $request->travel_purpose;
            }

            $claim->status = $request->action == 'submit' ? 'pending' : 'draft';
            $claim->save();

            if ($request->hasFile('attend_file')) {
                // save attendance file
                $attend_uuid = Str::uuid();
                $attend_type = 'attend';
                $attend_file = $request->file('attend_file');
                $attend_originalName = $attend_file->getClientOriginalName();
                $attend_file_ext = $attend_file->getClientOriginalExtension();
                $attend_file_name = "attend_" . $claim->reference_no . "_" . time();
                $attend_file_path = 'uploads/claims/' . $claim->reference_no . '/' . $attend_file_name;
                Storage::disk('public')->put($attend_file_path, File::get($attend_file));

                $claimFile = new ClaimFile();
                $claimFile->claim_id = $claim->id;
                $claimFile->file_uuid = $attend_uuid;
                $claimFile->type = $attend_type;
                $claimFile->file_path = $attend_file_path;
                $claimFile->file_name = $attend_file_name;
                $claimFile->file_ext = $attend_file_ext;
                $claimFile->save();
            }

            if ($request->hasFile('supporting_file')) {
                // save supporting file
                $supporting_uuid = Str::uuid();
                $supporting_type = 'support';
                $supporting_file = $request->file('supporting_file');
                $supporting_originalName = $supporting_file->getClientOriginalName();
                $supporting_file_ext = $supporting_file->getClientOriginalExtension();
                $supporting_file_name = "support_" . $claim->reference_no . "_" . time();
                $supporting_file_path = 'uploads/claims/' . $claim->reference_no . '/' . $supporting_file_name;
                Storage::disk('public')->put($supporting_file_path, File::get($supporting_file));

                $claimFile = new ClaimFile();
                $claimFile->claim_id = $claim->id;
                $claimFile->file_uuid = $supporting_uuid;
                $claimFile->type = $supporting_type;
                $claimFile->file_path = $supporting_file_path;
                $claimFile->file_name = $supporting_file_name;
                $claimFile->file_ext = $supporting_file_ext;
                $claimFile->save();
            }

            if ($request->action == 'submit') {
                $auditTrail = new AuditTrail();
                $auditTrail->user_id = Auth::id();
                $auditTrail->transaction_id = $claim->id;
                $auditTrail->user_role = 'staff';
                $auditTrail->action = 'submit_claim';
                $auditTrail->save();

                $returnCalculate = $this->calculateClaim($claim);
                if ($returnCalculate['success'] == false) {
                    DB::rollBack();
                    return redirect()->back()->withInput()->with('error', 'Error ' . $returnCalculate['error']);
                }

                $receiverEmail = Auth::user()->email;

                $sendEmail = $this->sendEmailSubmission($claim, $receiverEmail);
                $sendEmailApprove = $this->sendEmailSubmissionApprover($claim);
            }

            DB::commit();

            if ($request->action == 'submit') {
                return redirect()->route('claims.index')->with('success', 'Claim submitted successfully.');
            } else {
                return redirect()->route('claims.index')->with('success', 'Claim updated successfully.');
            }
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Error ' . $th->getMessage());
        }
    }

    public function delete(Claim $claim)
    {
        try {
            DB::beginTransaction();

            // delete claim files from storage
            $claimFiles = ClaimFile::where('claim_id', $claim->id)->get();
            foreach ($claimFiles as $file) {
                if (Storage::disk('public')->exists($file->file_path)) {
                    Storage::disk('public')->delete($file->file_path);
                }
                $file->delete();
            }

            // delete claim
            $claim->delete();

            DB::commit();

            return redirect()->route('claims.index')->with('success', 'Claim deleted successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while deleting the claim.');
        }
    }

    public function calculateClaim($claim)
    {

        try {

            DB::beginTransaction();

            $setting = SystemSetting::first();
            $standard_start = $setting->working_start;
            $standard_end = $setting->working_end;
            $firstMealTime = $setting->first_ot_meal_time;
            $firstMealHour = $setting->first_ot_meal_hrs;
            $extraMealHour = $setting->extra_ot_meal_hrs;
            $standard_rate = $setting->ot_rate;
            $weekend_rate = $setting->ot_weekend_rate;
            $holiday_rate = $setting->ot_holiday_rate;
            $meal_rate = $setting->meal_allowance;

            $type = $claim->type;
            $duty_date = $claim->duty_date;
            $duty_start_time = $claim->duty_start_time;
            $duty_end_time = $claim->duty_end_time;
            $is_out_of_office = $claim->work_location == 'outside' ? true : false;
            $travel_start_time = $claim->travel_start_time;
            $travel_end_time = $claim->travel_end_time;

            $user_id = $claim->staff_id;
            $user = User::where('id', $user_id)->first();
            $is_indicate_driving = $user->req_driving == 1 ? true : false;

            // check duty date is on holiday date
            $checkHoliday = PublicHoliday::whereDate('assign_date', $duty_date)->first();
            $is_public_holiday = $checkHoliday ? true : false;
            $is_weekend = false;

            if ($is_public_holiday == false) {
                // check weekend on duty date
                $date = Carbon::parse($duty_date);
                $is_weekend = $date->isWeekend();
            }

            $ot_rate = $is_public_holiday ? $holiday_rate : ($is_weekend ? $weekend_rate : $standard_rate);
            $ot_hours = 0;
            $meal_allowance_applicable = false;
            $additional_meal_applicable = false;

            if ($is_weekend || $is_public_holiday) {
                $ot_hours = $this->calculateTimeDifference($duty_start_time, $duty_end_time);
            } else {
                $ot_before = $this->calculateOTBefore($duty_start_time, $standard_start);
                $ot_after = $this->calculateOTAfter($duty_end_time, $standard_end);
                $ot_hours = $ot_before + $ot_after;

                if ($is_out_of_office && !$is_indicate_driving) {
                    $travel_time = $this->calculateTravelTime($travel_start_time, $travel_end_time);
                    $ot_hours = max(0, $ot_hours - $travel_time);
                }
            }

            if ($type === 'meal_allowance' || $type === 'both') {
                // Meal allowance check [cite: 59]
                $duty_end_datetime = $duty_date . ' ' . $duty_end_time;
                $meal_cutoff_datetime = $duty_date . ' ' . $firstMealTime;

                if ($ot_hours >= $firstMealHour && strtotime($duty_end_datetime) > strtotime($meal_cutoff_datetime)) {
                    $meal_allowance_applicable = true;

                    // Additional meal allowance check [cite: 60]
                    if ($ot_hours > $extraMealHour) {
                        $additional_meal_applicable = true;
                    }
                }
            }

            $totalOtCost = $ot_hours * $ot_rate;
            $totalAllowance = $additional_meal_applicable == true ? $meal_rate * 2 : ($meal_allowance_applicable == true ? $meal_rate : 0);

            $claimDetail = new ClaimDetail();
            $claimDetail->claim_id = $claim->id;
            $claimDetail->normal_rate = $standard_rate;
            $claimDetail->weekend_rate = $weekend_rate;
            $claimDetail->holiday_rate = $holiday_rate;
            $claimDetail->meal_rate = $meal_rate;
            $claimDetail->total_ot = round($totalOtCost, 2);
            $claimDetail->total_ot_hrs = round($ot_hours, 2);
            $claimDetail->total_allowance = round($totalAllowance, 2);
            $claimDetail->overall = round($totalOtCost + $totalAllowance, 2);
            $claimDetail->save();

            DB::commit();

            return array(
                'success' => true,
                'data' => $claimDetail
            );
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return array(
                'success' => false,
                'error' => $th->getMessage()
            );
        }
    }

    public function sendEmailSubmission($claim, $receiverEmail)
    {

        $subject = "Submission Confirmed: Overtime/Meal Claim for " . Carbon::parse($claim->duty_date)->format('d M, Y');
        $detailEmail['app_name'] = env('APP_NAME', 'Claim System');
        $detailEmail['sender_email'] = env('MAIL_FROM_ADDRESS', 'muhdhamzah121@gmail.com');

        $data_content = array(
            'duty_date'         => Carbon::parse($claim->duty_date)->format('d M, Y'),
            'staff_name'        => $claim->staff->name,
            'claim_referenceNo' => $claim->reference_no,
            'claim_type'        => ucwords($claim->type),
            'claim_link'        => route('claims.edit', $claim)
        );

        try {
            Mail::to($receiverEmail)->send(new SubmissionConfirmed($data_content, $detailEmail, $subject));
        } catch (\Throwable $th) {
            info($th);
            return back();
        }
    }

    public function sendEmailSubmissionApprover($claim)
    {

        $subject = "🚨 Action Required: New Overtime/Meal Claim from " . $claim->staff->name;
        $detailEmail['app_name'] = env('APP_NAME', 'Claim System');
        $detailEmail['sender_email'] = env('MAIL_FROM_ADDRESS', 'muhdhamzah121@gmail.com');

        $manager = Admin::where('id', $claim->manager_id)->first();

        $data_content = array(
            'staff_name'         => $claim->staff->name,
            'approver_name'      => $manager->name ?? "-",
            'submit_date'        => Carbon::now()->format('d M, Y'),
            'duty_date'          => Carbon::parse($claim->duty_date)->format('d M, Y'),
            'total_amount'       => "RM" . number_format($claim->detail->overall, 2),
            'claim_link'         => route('admin.claim.view', $claim)
        );

        try {
            Mail::to($manager->email)->send(new ClaimApprovalPending($data_content, $detailEmail, $subject));
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            return back();
        }
    }
}