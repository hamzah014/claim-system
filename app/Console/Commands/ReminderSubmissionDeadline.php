<?php

namespace App\Console\Commands;

use App\Mail\SubmissionDeadlineReminder;
use App\Models\SystemSetting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ReminderSubmissionDeadline extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reminder-submission-deadline';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $setting = SystemSetting::first();

        if (!$setting || !$setting->date_salary) {
            Log::warning("System setting missing for salary reminder.");
            return;
        }

        $salaryDate = Carbon::parse(now()->format('Y-m') . '-' . $setting->date_salary);
        $reminderDate = $salaryDate->copy()->subDays(4)->startOfDay();
        if (!now()->isSameDay($reminderDate)) {
            return;
        }

        $staffList = User::get();

        foreach ($staffList as $staff) 
        {
            $subject = "🔔 Important Reminder: Monthly Claim Submission Deadline Approaching";
            $detailEmail['app_name'] = env('APP_NAME', 'Claim System');
            $detailEmail['sender_email'] = env('MAIL_FROM_ADDRESS', 'muhdhamzah121@gmail.com');

            $data_content = array(
                'staff_name'    => $staff->name,
                'date_salary'   => $setting->date_salary,
                'dateline'      => Carbon::parse($salaryDate)->format('d M, Y'),
                'claim_link'    => route('claims.create')
            );

            // send email to staff
            Mail::to($staff->email)->send(new SubmissionDeadlineReminder($data_content, $detailEmail, $subject));
                
        }

        Log::info("Salary reminder sent to all staff.");
    }

}