<?php

namespace App\Console\Commands;

use App\Mail\DutyDeadlineReminder;
use App\Models\Claim;
use App\Models\SystemSetting;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ReminderDutyDeadline extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reminder-duty-deadline';

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

        if (!$setting || !$setting->date_salary || !$setting->submit_day_allow) {
            Log::warning("System setting missing for reminder email.");
            return;
        }

        $salaryDate = Carbon::parse(now()->format('Y-m') . '-' . $setting->date_salary);

        $cutoffDate = $salaryDate->copy()->subDays($setting->submit_day_allow);

        $reminderStart = $cutoffDate->copy()->subDays(7);
        $reminderEnd   = $cutoffDate;

        $claims = Claim::where('status', 'pending')
            ->whereBetween('duty_date', [$reminderStart->startOfDay(), $reminderEnd->endOfDay()])
            ->get();

        foreach ($claims as $claim) {

            $subject = "⚠️ Warning: Claim Eligibility Deadline Approaching";
            $detailEmail['app_name'] = env('APP_NAME', 'Claim System');
            $detailEmail['sender_email'] = env('MAIL_FROM_ADDRESS', 'muhdhamzah121@gmail.com');

            $data_content = array(
                'staff_name'         => $claim->staff->name,
                'allow_days'        => $setting->submit_day_allow,
                'duty_date'       => Carbon::parse($claim->duty_date)->format('d M, Y'),
                'expired_date'    => Carbon::parse($cutoffDate)->format('d M, Y'),
                'claim_link'        => route('claims.edit', $claim)
            );

            // send email to staff
            Mail::to($claim->staff->email)
                ->send(new DutyDeadlineReminder($data_content, $detailEmail, $subject));

            Log::info("Reminder email sent for claim ID: {$claim->id}");
        }
    }
}