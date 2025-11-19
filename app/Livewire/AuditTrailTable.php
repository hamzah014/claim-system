<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AuditTrail; // Assuming you have an AuditTrail Model
use Livewire\WithPagination;

class AuditTrailTable extends Component
{
    use WithPagination;

    public $perPage = 10;

    public function render()
    {
        $trails = AuditTrail::where('user_role','!=','staff')->orderBy('created_at', 'desc')->paginate($this->perPage);

        return view('livewire.audit-trail-table', [
            'trails' => $trails,
        ]);
    }
}