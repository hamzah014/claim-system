<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Claim ID</th>
                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Staff / Duty Date</th>
                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Total Payment</th>
                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Processed By HR</th>
                <th class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">Payment Action</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse ($claims as $claim)
                <tr>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">{{ $claim->reference_no }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                        {{ $claim->staff->name ?? 'N/A' }} 
                        <span class="text-xs text-gray-400">({{ \Carbon\Carbon::parse($claim->duty_date)->format('Y-m-d') }})</span>
                    </td>
                    <td class="px-6 py-4 text-sm font-bold text-gray-500 text-green-700 whitespace-nowrap">RM{{ number_format($claim->detail->overall ?? 0, 2) }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ \Carbon\Carbon::parse($claim->updated_at)->format('d M, Y') }}</td>
                    <td class="px-6 py-4 text-sm font-medium text-center whitespace-nowrap">
                        <button class="px-3 py-1 text-xs text-white transition duration-150 bg-green-600 rounded hover:bg-green-700 open-form" data-action="paid" data-id="{{ $claim->id }}">
                            Confirm Payment & Mark Paid
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="py-6 text-center text-gray-500">No claims currently awaiting payment confirmation.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="pt-4">
        {{ $claims->links() }}
    </div>
</div>