<div class="bg-white rounded-lg dark:bg-gray-800">

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead>
                <tr class="bg-gray-50 dark:bg-gray-700">
                    <th class="w-1/5 px-6 py-3 text-xs font-bold tracking-wider text-left text-gray-600 uppercase dark:text-gray-300">
                        <div class="flex items-center">
                            Date/Time
                        </div>
                    </th>
                    <th class="w-1/5 px-6 py-3 text-xs font-bold tracking-wider text-left text-gray-600 uppercase dark:text-gray-300">
                        User / Role
                    </th>
                    <th class="w-2/5 px-6 py-3 text-xs font-bold tracking-wider text-left text-gray-600 uppercase dark:text-gray-300">
                        Action
                    </th>
                    <th class="w-1/5 px-6 py-3 text-xs font-bold tracking-wider text-left text-gray-600 uppercase dark:text-gray-300">
                        Ref No.
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100 dark:bg-gray-800 dark:divide-gray-700">
                @foreach ($trails as $trail)
                <tr class="text-sm transition duration-100 hover:bg-gray-50 dark:hover:bg-gray-200 hover:text-white">
                    
                    <td class="px-6 py-3 text-gray-800 whitespace-nowrap">
                        <div class="font-medium">
                            {{ $trail->created_at->format('M d, Y') }}
                        </div>
                        <div class="text-xs text-gray-500">
                            {{ $trail->created_at->format('H:i:s') }}
                        </div>
                    </td>
                    
                    <td class="px-6 py-3 whitespace-nowrap">
                        <div class="font-medium text-gray-900">
                            {{ $trail->user->name }}
                        </div>
                        <span class="mt-1 px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @if($trail->user_role === 'admin') bg-teal-100 text-teal-800 dark:bg-teal-900 dark:text-teal-300
                            @else bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300
                            @endif">
                            {{ ucfirst($trail->user_role) }}
                        </span>
                    </td>
                    
                    <td class="max-w-sm px-6 py-3 text-gray-700 break-words">
                        {{ __('adminlte::adminlte.' . $trail->action) }}
                    </td>

                    <td class="px-6 py-3 text-gray-500 whitespace-nowrap">
                        {{ $trail->transaction?->reference_no ?? 'N/A' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-gray-200 dark:border-gray-700">
        {{ $trails->links() }}
    </div>
</div>