<?php
namespace App\Livewire;

use App\Models\Claim;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ApprovalHistoryTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';
    
    // Sort by the date of the last action (i.e., when they approved/rejected it)
    public $sortField = 'updated_at'; 
    public $sortDirection = 'desc';

    public function render()
    {
        $managerId = Auth::guard('admin')->id();

        $claims = Claim::query()
            // 1. Filter by the current manager
            ->where('approver_id', $managerId)
            // 2. Filter by final decision status
            ->whereIn('status', ['approved', 'rejected', 'processed', 'paid']) 
            // We include Processed/Paid as these were Approved by the manager first
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.approval-history-table', [
            'claims' => $claims,
        ]);
    }

    // Helper to determine the badge color for the status
    public function getStatusColor($status)
    {
        return match ($status) {
            'approved' => 'indigo',
            'rejected' => 'red',
            'processed' => 'yellow',
            'paid' => 'green',
            default => 'gray',
        };
    }
}