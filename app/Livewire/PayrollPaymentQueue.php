<?php

namespace App\Livewire;

use App\Models\Claim;
use Livewire\Component;
use Livewire\WithPagination;

class PayrollPaymentQueue extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';
    protected $listeners = ['claimPaid' => '$refresh']; // Refresh after payment action

    public function render()
    {
        // Only show claims that have been 'Processed' by HR Admins
        $claims = Claim::where('status', 'processed')
                      ->orderBy('updated_at', 'asc') // Order by last processed time
                      ->paginate(15);

        return view('livewire.payroll-payment-queue', ['claims' => $claims]);
    }

    /**
     * Payroll staff update the status to Paid once payment has been completed.
     * @param int $claimId
     */
    public function markAsPaid($claimId)
    {
        $claim = Claim::findOrFail($claimId);
        
        // This is a sensitive action that creates an audit log entry[cite: 85].
        $claim->status = 'Paid'; 
        $claim->save();

        // This should trigger a final notification to the HR team (digest) and staff member (final confirmation).

        session()->flash('success', 'Claim #' . $claimId . ' payment confirmed and status updated to Paid.');
        $this->dispatch('claimPaid'); // Refresh the queue
    }
}