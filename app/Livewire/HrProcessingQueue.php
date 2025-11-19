<?php
namespace App\Livewire;

use App\Models\AuditTrail;
use App\Models\Claim;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class HrProcessingQueue extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';
    protected $listeners = ['claimProcessed' => '$refresh']; // Refresh after processing action

    public function render()
    {
        // Only show claims that have been 'Approved' by the manager and are waiting for HR
        $claims = Claim::where('status', 'approved') 
                      ->orderBy('created_at', 'asc')
                      ->paginate(10);

        return view('livewire.hr-processing-queue', ['claims' => $claims]);
    }

    /**
     * HR Admin marks the approved claim as Processed.
     * @param int $claimId
     */
    public function markAsProcessed($claimId)
    {
        $claim = Claim::findOrFail($claimId);

        $claim->proccessor_id = Auth::guard('admin')->id();
        $claim->processed_at = Carbon::now();
        $claim->status = 'processed'; 
        $claim->save();
        
        $logType = 'process_claim';
        $auditTrail = new AuditTrail();
        $auditTrail->user_id = Auth::guard('admin')->id();
        $auditTrail->transaction_id = $claim->id;
        $auditTrail->user_role = 'admin';
        $auditTrail->action = $logType;
        $auditTrail->save();

        session()->flash('success', 'Claim #' . $claimId . ' marked as Processed and sent to Payroll queue.');
        $this->dispatch('claimProcessed'); // Refresh the queue
    }
}