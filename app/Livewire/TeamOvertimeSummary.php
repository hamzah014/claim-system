<?php

namespace App\Livewire;

use App\Models\Claim;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TeamOvertimeSummary extends Component
{
    public $chartData = [];

    public function mount()
    {
        // This method would run the database queries to gather team overtime data.
        $this->loadChartData(); 
    }
    
    public function loadChartData()
    {
        // 1. Define Period and Labels (MUST be real dates for accurate representation)
        $numMonths = 6;
        $labels = [];
        $datasetsData = [];

        $currentMonth = Carbon::now()->startOfMonth();
        
        // Generate labels and populate mock data for the last 6 months
        for ($i = $numMonths - 1; $i >= 0; $i--) {
            $month = $currentMonth->copy()->subMonths($i);
            $labels[] = $month->format('M Y');
            
            // Generate plausible, varying mock OT hours for each month
            // Example: Base OT is 50 hours, varying by +/- 25 hours
            $mockOtHours = rand(45, 95); 
            $datasetsData[] = $mockOtHours;
        }

        // 2. Assign Final Data Structure (Identical to DB output format)
        $this->chartData = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Total Team OT Hours',
                    'data' => $datasetsData, // This array holds the 6 mock OT hour values
                    'borderColor' => '#9333ea', // secondary purple color
                    'backgroundColor' => 'rgba(147, 51, 234, 0.1)',
                    'fill' => true
                ],
            ],
        ];
    }

    public function render()
    {
        return view('livewire.team-overtime-summary');
    }
}