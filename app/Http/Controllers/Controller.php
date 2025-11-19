<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

abstract class Controller
{
    

    protected function calculateTimeDifference(string $start_time, string $end_time): float
    {
        // Convert to Carbon/DateTime objects for accurate calculation
        $start = Carbon::parse($start_time);
        $end = Carbon::parse($end_time);

        // If duty ends before it starts (e.g., spanning midnight), this needs more complex logic.
        if ($end->lessThan($start)) {
            // Simple fix: assume it ends the next day if the difference is negative.
            $end->addDay();
        }
        
        return $start->diffInMinutes($end) / 60;
    }

    /**
     * Calculates overtime before the standard start time (8:00 AM).
     * @param string $dutyStart e.g., '07:00:00'
     * @param string $standardStart e.g., '08:00:00'
     * @return float Overtime hours before standard start.
     */
    protected function calculateOTBefore(string $dutyStart, string $standardStart): float
    {
        $duty = Carbon::parse($dutyStart);
        $standard = Carbon::parse($standardStart);

        if ($duty->lessThan($standard)) {
            return $duty->diffInMinutes($standard) / 60;
        }
        return 0.0;
    }

    /**
     * Calculates overtime after the standard end time (5:00 PM).
     * @param string $dutyEnd e.g., '20:00:00'
     * @param string $standardEnd e.g., '17:00:00'
     * @return float Overtime hours after standard end.
     */
    protected function calculateOTAfter(string $dutyEnd, string $standardEnd): float
    {
        $duty = Carbon::parse($dutyEnd);
        $standard = Carbon::parse($standardEnd);

        if ($duty->greaterThan($standard)) {
            return $standard->diffInMinutes($duty) / 60;
        }
        return 0.0;
    }

    /**
     * Calculates total travel time.
     * @param string $travelStart
     * @param string $travelEnd
     * @return float Total travel time in hours.
     */
    protected function calculateTravelTime(string $travelStart, string $travelEnd): float
    {
        // The requirement implies the duty provides the overall travel window (start/end)
        // For simplicity, we calculate a single block of travel time.
        return $this->calculateTimeDifference($travelStart, $travelEnd);
    }

}