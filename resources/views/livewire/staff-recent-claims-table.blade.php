<div class="space-y-4">
    <div class="flex space-x-2 text-sm">
        <button wire:click="setStatusFilter('all')"
            class="px-3 py-1 rounded-full @if ($statusFilter === 'all') bg-pink-600 text-white @else bg-gray-200 text-gray-700 @endif">All
            Claims</button>
        <button wire:click="setStatusFilter('approved')"
            class="px-3 py-1 rounded-full @if ($statusFilter === 'approved') bg-yellow-500 text-white @else bg-gray-200 text-gray-700 @endif">Pending</button>
        <button wire:click="setStatusFilter('processed')"
            class="px-3 py-1 rounded-full @if ($statusFilter === 'processed') bg-green-500 text-white @else bg-gray-200 text-gray-700 @endif">Processed</button>
        <button wire:click="setStatusFilter('rejected')"
            class="px-3 py-1 rounded-full @if ($statusFilter === 'rejected') bg-red-500 text-white @else bg-gray-200 text-gray-700 @endif">Rejected</button>
        <button wire:click="setStatusFilter('paid')"
            class="px-3 py-1 rounded-full @if ($statusFilter === 'paid') bg-blue-500 text-white @else bg-gray-200 text-gray-700 @endif">Paid</button>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Duty Date
                    </th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Type</th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Status
                    </th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Submitted
                        On</th>
                    <th class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($claims as $claim)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($claim->duty_date)->format('d M, Y') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ ucwords($claim->type) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if ($claim->status === 'approved') bg-yellow-100 text-yellow-800
                                @elseif($claim->status === 'processed') bg-green-100 text-green-800
                                @elseif($claim->status === 'rejected') bg-red-100 text-red-800
                                @else bg-indigo-100 text-indigo-800 @endif">
                                {{ ucwords($claim->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($claim->created_at)->format('d M, Y') }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                            <a href="{{ route('claims.edit', $claim) }}" class="p-6 bg-blue-500 txt-purple-600 hover:text-purple-900">View Details</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-4 text-center text-gray-500">No claims found matching the filter.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pt-4">
        {{ $claims->links() }}
    </div>
</div>
