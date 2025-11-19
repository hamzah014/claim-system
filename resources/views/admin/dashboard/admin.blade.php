@extends('adminlte::page')

@section('title', 'Admin Dashboard')

@section('content')

<div class="p-6 sm:p-10">
    <h2 class="mb-8 text-3xl font-extrabold text-gray-900 dark:text-white">
        Administrator Dashboard
    </h2>

    {{-- CARD ROW: Total Counts using Tailwind Grid --}}
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
        
        {{-- Total Staff Card --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border-l-4 border-indigo-600 dark:border-indigo-400 transform hover:scale-[1.02] transition duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium tracking-wider text-gray-500 uppercase dark:text-gray-400">
                        Total Staff
                    </p>
                    <p class="mt-1 text-4xl font-bold text-gray-900">
                        {{ $data['staff_count'] }}
                    </p>
                </div>
                <div class="p-3 text-indigo-600 bg-indigo-100 rounded-full dark:bg-indigo-900 dark:text-indigo-400">
                    <i class="fas fw fa-users"></i>
                </div>
            </div>
            <a href="{{ route('admin.staff.index') }}" class="block mt-4 text-xs text-indigo-500 dark:text-indigo-300 hover:text-indigo-700">View Staff List &rarr;</a>
        </div>

        {{-- Total Claims Card (Pending) --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border-l-4 border-yellow-600 dark:border-yellow-400 transform hover:scale-[1.02] transition duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium tracking-wider text-gray-500 uppercase dark:text-gray-400">
                        Pending Claims
                    </p>
                    <p class="mt-1 text-4xl font-bold text-gray-900">
                        {{ $data['claim_count'] }}
                    </p>
                </div>
                <div class="p-3 text-yellow-600 bg-yellow-100 rounded-full dark:bg-yellow-900 dark:text-yellow-400">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                </div>
            </div>
            <a href="{{ route('admin.claim.index') }}" class="block mt-4 text-xs text-yellow-500 dark:text-yellow-300 hover:text-yellow-700">Review Claims &rarr;</a>
        </div>

        {{-- Total Departments Card --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border-l-4 border-teal-600 dark:border-teal-400 transform hover:scale-[1.02] transition duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium tracking-wider text-gray-500 uppercase dark:text-gray-400">
                        Total Departments
                    </p>
                    <p class="mt-1 text-4xl font-bold text-gray-900 ">
                        {{ $data['department_count'] }}
                    </p>
                </div>
                <div class="p-3 text-teal-600 bg-teal-100 rounded-full dark:bg-teal-900 dark:text-teal-400">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 8v-2.5a1.5 1.5 0 013 0V21"/>
                    </svg>
                </div>
            </div>
            <a href="{{ route('admin.department.index') }}" class="block mt-4 text-xs text-teal-500 dark:text-teal-300 hover:text-teal-700">Manage Departments &rarr;</a>
        </div>

    </div>
    
    <div class="mt-8">
        <div class="p-6 bg-white shadow-lg dark:bg-gray-800 rounded-xl">
            <h3 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">
                Recent Admin Audit Trail
            </h3>
            
            <p class="mb-4 text-gray-600 dark:text-gray-400">
                View the most recent administrative and staff actions recorded in the system.
            </p>
            
            <div class="w-full overflow-x-auto">
                <livewire:audit-trail-table />
            </div>

        </div>
    </div>

</div>

@endsection

@push('js')
    {{-- Add any necessary JS for charts (e.g., Chart.js) here --}}
@endpush