<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Staff Member</th>
                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Duty Date</th>
                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Type</th>
                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Amount</th>
                <th class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse ($claims as $claim)
                <tr>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">{{ $claim->staff->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ \Carbon\Carbon::parse($claim->duty_date)->format('M d, Y') }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $claim->type }}</td>
                    <td class="px-6 py-4 text-sm font-semibold text-gray-500 whitespace-nowrap">RM{{ number_format($claim->detail->overall ?? 0, 2) }}</td>
                    <td class="px-6 py-4 space-x-2 text-sm font-medium text-center whitespace-nowrap">
                        <a href="{{ route('admin.claim.view', $claim) }}" class="font-medium text-blue-600 hover:text-blue-900">View Details</a>
                        
                        <button wire:click="approveClaim({{ $claim->id }})" class="px-3 py-1 text-xs text-white transition duration-150 bg-green-500 rounded hover:bg-green-600">
                            Approve
                        </button>
                        
                        <button class="px-3 py-1 text-xs text-white transition duration-150 bg-red-500 rounded hover:bg-red-600 open-form" data-action="reject" data-id="{{ $claim->id }}">
                            Reject
                        </button>
                            
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="py-6 text-center text-gray-500">🎉 No claims currently require your approval.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="pt-4">
        {{ $claims->links() }}
    </div>
</div>