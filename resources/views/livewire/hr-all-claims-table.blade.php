<div class="space-y-4">
    <div class="flex flex-wrap items-center justify-between space-y-4 md:space-y-0">
        <input wire:model.live.debounce.300ms="search" type="search" placeholder="Search staff member..." class="w-full p-2 text-sm border border-gray-300 rounded-md shadow-sm md:w-64">
        
        <select wire:model.live="statusFilter" class="p-2 text-sm border border-gray-300 rounded-md shadow-sm">
            <option value="all">All Statuses</option>
            <option value="Draft">Draft</option>
            <option value="Pending Approval">Pending Approval</option>
            <option value="Approved">Approved</option>
            <option value="Processed">Processed</option>
            <option value="Rejected">Rejected</option>
            <option value="Paid">Paid</option>
        </select>

        <select wire:model.live="departmentFilter" class="p-2 text-sm border border-gray-300 rounded-md shadow-sm">
            <option value="all">All Departments</option>
            @foreach($departments as $dept)
                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
            @endforeach
        </select>
        
        <div class="flex space-x-2">
            <button wire:click="export('xlsx')" class="px-3 py-2 text-sm text-white transition duration-150 bg-green-600 rounded-md hover:bg-green-700">Export Excel</button>
            <button wire:click="export('csv')" class="px-3 py-2 text-sm text-white transition duration-150 bg-gray-600 rounded-md hover:bg-gray-700">Export CSV</button>
            <button wire:click="export('pdf')" class="px-3 py-2 text-sm text-white transition duration-150 bg-red-600 rounded-md hover:bg-red-700">Export PDF</button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <p class="py-4 text-sm text-gray-500">Data table showing all claims with details and calculated costs...</p>
    </div>

    <div class="pt-4">
        {{ $claims->links() }}
    </div>
</div>