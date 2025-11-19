<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ClaimDataTable;
use App\Http\Controllers\Controller;
use App\Mail\ClaimApprovalPending;
use App\Mail\ClaimApproved;
use App\Mail\ClaimRejected;
use App\Models\Admin;
use App\Models\AuditTrail;
use App\Models\Claim;
use App\Models\ClaimFile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ClaimController extends Controller
{

    public function index(ClaimDataTable $dataTable, Request $request)
    {

        $status = $request->get('status', null);
        return $dataTable->with(['status' => $status])->render('admin.claims.index');
    }

    public function view(Claim $claim)
    {
        return view('admin.claims.view', compact('claim'));
    }

    public function updateStatus(Request $request, Claim $claim)
    {
        $request->validate([
            'action' => 'required|string|in:draft,pending,approved,rejected,processed,paid',
            'receipt' => 'required_if:action,paid|file|mimes:pdf,jpg,jpeg,png|max:5000'
        ]);

        try {
            DB::beginTransaction();

            $action = $request->action;
            $logType = "";

            $claim->status = $action;

            if ($action == 'rejected') {
                $logType = 'reject_claim';

                $claim->approver_id = Auth::guard('admin')->id();
                $claim->rejected_at = Carbon::now();
                $claim->rejection_reason = $request->reject_reason;
                $claim->save();

                $receiverEmail = $claim->staff->email;
                $sendEmail = $this->sendEmailRejected($claim, $receiverEmail);
            } else if ($action == 'approved') {
                $logType = 'approve_claim';

                $claim->approver_id = Auth::guard('admin')->id();
                $claim->approved_at = Carbon::now();
                $claim->approve_remark = $request->approve_remark;
                $claim->save();

                $receiverEmail = $claim->staff->email;
                $sendEmail = $this->sendEmailApproved($claim, $receiverEmail);
            } else if ($action == 'processed') {
                $logType = 'process_claim';

                $claim->proccessor_id = Auth::guard('admin')->id();
                $claim->processed_at = Carbon::now();
            } else if ($action == 'paid') {
                $logType = 'paid_claim';

                $claim->payer_id = Auth::guard('admin')->id();
                $claim->payment_date = $request->payment_date;
                $claim->paid_at = Carbon::now();

                // save receipt file
                $receipt_uuid = Str::uuid();
                $receipt_type = 'receipt';
                $receipt_file = $request->file('receipt');
                $receipt_originalName = $receipt_file->getClientOriginalName();
                $receipt_file_ext = $receipt_file->getClientOriginalExtension();
                $receipt_file_name = "receipt_" . $claim->reference_no . "_" . time();
                $receipt_file_path = 'uploads/claims/' . $claim->reference_no . '/' . $receipt_file_name;
                Storage::disk('public')->put($receipt_file_path, File::get($receipt_file));

                $claimFile = new ClaimFile();
                $claimFile->claim_id = $claim->id;
                $claimFile->file_uuid = $receipt_uuid;
                $claimFile->type = $receipt_type;
                $claimFile->file_path = $receipt_file_path;
                $claimFile->file_name = $receipt_file_name;
                $claimFile->file_ext = $receipt_file_ext;
                $claimFile->save();
            }

            $claim->save();

            // save to audit trail
            $auditTrail = new AuditTrail();
            $auditTrail->user_id = Auth::guard('admin')->id();
            $auditTrail->transaction_id = $claim->id;
            $auditTrail->user_role = 'admin';
            $auditTrail->action = $logType;
            $auditTrail->save();
            
            DB::commit();

            return redirect()->route('admin.claim.index', ['status' => 'all'])->with('success', 'Staff ' . $action . ' successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Error: ' . $th->getMessage());
            //throw $th;
        }
    }


    public function sendEmailApproved($claim, $receiverEmail)
    {

        $subject = "✅ Claim Approved: Your Submission for " . $claim->reference_no;
        $detailEmail['app_name'] = env('APP_NAME', 'Claim System');
        $detailEmail['sender_email'] = env('MAIL_FROM_ADDRESS', 'muhdhamzah121@gmail.com');

        $approver = Admin::where('id', $claim->approver_id)->first();
        $approver_name = $approver ? $approver->name : "-";

        $data_content = array(
            'duty_date'         => Carbon::parse($claim->duty_date)->format('d M, Y'),
            'staff_name'        => $claim->staff->name,
            'claim_refno'       => $claim->reference_no,
            'approver_name'     => $approver_name,
            'approve_remark'    => $claim->approve_remark,
            'claim_link'        => route('claims.edit', $claim)
        );

        try {
            Mail::to($receiverEmail)->send(new ClaimApproved($data_content, $detailEmail, $subject));
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            return back();
        }
    }

    public function sendEmailRejected($claim, $receiverEmail)
    {
        Log::info('email ' . $receiverEmail);
        $subject = "🚫 Claim Rejected: Action Required for " . $claim->reference_no;
        $detailEmail['app_name'] = env('APP_NAME', 'Claim System');
        $detailEmail['sender_email'] = env('MAIL_FROM_ADDRESS', 'muhdhamzah121@gmail.com');

        $approver = Admin::where('id', $claim->approver_id)->first();
        $approver_name = $approver ? $approver->name : "-";

        $data_content = array(
            'duty_date'        => Carbon::parse($claim->duty_date)->format('d M, Y'),
            'claim_refno'      => $claim->reference_no,
            'approver_name'    => $approver_name,
            'reject_reason'    => $claim->rejection_reason,
            'staff_name'       => $claim->staff->name,
            'claim_link'       => route('claims.edit', $claim)
        );

        try {
            Mail::to($receiverEmail)->send(new ClaimRejected($data_content, $detailEmail, $subject));
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            return back();
        }
    }
}