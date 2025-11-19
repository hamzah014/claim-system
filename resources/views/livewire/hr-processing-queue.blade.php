<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Claim ID</th>
                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Staff / Department</th>
                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Amount</th>
                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Approved Date</th>
                <th class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">Action</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse ($claims as $claim)
                <tr>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">{{ $claim->reference_no }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                        {{ $claim->staff->name ?? 'N/A' }} 
                        <span class="text-xs text-gray-400">({{ $claim->staff->department->name ?? 'N/A' }})</span>
                    </td>
                    <td class="px-6 py-4 text-sm font-semibold text-gray-500 whitespace-nowrap">RM{{ number_format($claim->detail->overall ?? 0, 2) }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ \Carbon\Carbon::parse($claim->updated_at)->format('d M, Y') }}</td>
                    <td class="px-6 py-4 text-sm font-medium text-center whitespace-nowrap">
                        <a href="{{ route('admin.claim.view', $claim) }}" class="mr-2 font-medium text-blue-600 hover:text-blue-900">Verify</a>
                        <button wire:click="markAsProcessed({{ $claim->id }})" class="px-3 py-1 text-xs text-white transition duration-150 bg-pink-600 rounded hover:bg-pink-700">
                            Mark as Processed
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="py-6 text-center text-gray-500">All approved claims have been processed.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="pt-4">
        {{ $claims->links() }}
    </div>
</div>