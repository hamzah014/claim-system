<?php

namespace App\Livewire;

use App\Models\AuditTrail;
use App\Models\Claim;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ApproverActionQueue extends Component
{
    use WithPagination;

    // Optional properties for filtering/sorting
    protected $paginationTheme = 'tailwind';
    public $sortField = 'created_at';
    public $sortDirection = 'asc';
    
    // Listen for events to refresh the queue after an action
    protected $listeners = ['claimActionTaken' => '$refresh']; 

    public function render()
    {
        $manager = Auth::guard('admin')->user();

        $claims = Claim::where('status', 'pending')
            ->where('manager_id', $manager->id)
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(5);

        return view('livewire.approver-action-queue', [
            'claims' => $claims,
        ]);
    }

    /**
     * Approves a claim and triggers notifications/audit logs.
     * @param int $claimId
     */
    public function approveClaim($claimId)
    {
        
        $logType = 'approve_claim';

        $claim = Claim::findOrFail($claimId);
        $claim->approver_id = Auth::guard('admin')->id();
        $claim->approved_at = Carbon::now();
        $claim->status = 'approved';
        $claim->save();

        $auditTrail = new AuditTrail();
        $auditTrail->user_id = Auth::guard('admin')->id();
        $auditTrail->transaction_id = $claim->id;
        $auditTrail->user_role = 'admin';
        $auditTrail->action = $logType;
        $auditTrail->save();
        
        session()->flash('success', 'Claim #' . $claimId . ' approved successfully.');
        $this->dispatch('claimActionTaken');
    }
}