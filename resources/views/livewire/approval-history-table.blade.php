<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Staff Member
                </th>
                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Duty Date</th>
                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Final Decision
                </th>
                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Date of
                    Decision</th>
                <th class="px-6 py-3"></th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse ($claims as $claim)
                <tr>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                        {{ $claim->staff->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                        {{ \Carbon\Carbon::parse($claim->duty_date)->format('d M, Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span
                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @php
                            $color = $this->getStatusColor($claim->status); @endphp
                            bg-{{ $color }}-100 text-{{ $color }}-800">
                            {{ ucwords($claim->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                        {{ \Carbon\Carbon::parse($claim->updated_at)->format('d M, Y') }}</td>
                    <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                        <a href="{{ route('admin.claim.view', $claim) }}" class="text-blue-600 hover:text-blue-900">View
                            Details</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="py-6 text-center text-gray-500">No approval history found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pt-4">
        {{ $claims->links() }}
    </div>
</div>
