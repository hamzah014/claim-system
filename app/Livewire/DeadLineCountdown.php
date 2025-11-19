<?php

namespace App\Livewire;

use App\Models\SystemSetting;
use Livewire\Component;
use Carbon\Carbon;

class DeadlineCountdown extends Component
{
    // The target day is the 9th of the current month
    
    // The countdown message (e.g., '5 Days, 12 Hours')
    public $countdownMessage = 'Calculating...';

    // The component will poll (update) every 60 seconds
    protected $listeners = ['echo:TimeUpdate' => 'updateCountdown'];

    public function mount()
    {
        $this->updateCountdown();
    }

    public function updateCountdown()
    {

        $targetDay = SystemSetting::first()->date_salary;

        // Find the next 9th of the month
        $now = Carbon::now();
        $targetDate = Carbon::createFromDate($now->year, $now->month, $targetDay);

        // If today is past the 9th, target the next month's 9th
        if ($now->greaterThan($targetDate)) {
            $targetDate->addMonth();
        }

        $diff = $now->diff($targetDate);
        
        // Format the difference into a readable message
        $this->countdownMessage = sprintf(
            '%d Days, %d Hours, %d Minutes',
            $diff->days,
            $diff->h,
            $diff->i
        );

        // If the deadline is very close, change the message
        if ($diff->days == 0 && $diff->h < 24) {
            $this->countdownMessage = 'LESS THAN 24 HOURS LEFT!';
        }
    }

    public function render()
    {
        return view('livewire.deadline-countdown');
    }
}