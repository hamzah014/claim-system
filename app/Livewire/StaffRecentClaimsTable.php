<?php

namespace App\Livewire;

use App\Models\Claim;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class StaffRecentClaimsTable extends Component
{
    use WithPagination;

    // Filters
    public $statusFilter = 'all';

    public function render()
    {
        $staffId = Auth::guard('staff')->id();

        $claims = Claim::where('staff_id', $staffId)
            ->when($this->statusFilter !== 'all', function ($query) {
                return $query->where('status', $this->statusFilter);
            })
            ->orderBy('duty_date', 'desc')
            ->paginate(10);

        return view('livewire.staff-recent-claims-table', [
            'claims' => $claims,
        ]);
    }

    public function setStatusFilter($status)
    {
        $this->statusFilter = $status;
        $this->resetPage();
    }
}