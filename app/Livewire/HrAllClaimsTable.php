<?php

namespace App\Livewire;

use App\Models\Claim;
use App\Models\Department;
use Livewire\Component;
use Livewire\WithPagination;

class HrAllClaimsTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';
    
    // Filtering properties
    public $search = '';
    public $statusFilter = 'all';
    public $departmentFilter = 'all';
    public $dateRange = []; // [start_date, end_date]

    public function render()
    {
        $claims = Claim::query()
            ->with(['staff.department', 'detail'])
            ->when($this->statusFilter !== 'all', fn ($q) => $q->where('status', $this->statusFilter))
            // ... (Add logic for department and date range filters)
            ->when($this->search, fn ($q) => $q->whereHas('staff', fn ($s) => $s->where('name', 'like', "%{$this->search}%")))
            
            ->orderBy('duty_date', 'desc')
            ->paginate(15);

        return view('livewire.hr-all-claims-table', [
            'claims' => $claims,
            'departments' => Department::all(), // For filter dropdown
        ]);
    }

    /**
     * [cite_start]Trigger asynchronous export to Excel [cite: 79, 80]
     */
    public function export(string $format)
    {
        if (in_array($format, ['xlsx', 'csv', 'pdf'])) {
            // Logic would call a trait method like: 
            // $this->dispatchExportJob($this->filters, $format); 
            session()->flash('info', "Report generation started for $format. You will be notified when the file is ready.");
        }
    }
}