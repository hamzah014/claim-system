@extends('adminlte::page')

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@stop


@section('auth_header', 'Dashboard')

@section('content')
<div class="min-h-screen p-6 bg-gray-100">
    <div class="mx-auto max-w-7xl">
        
        <div class="mb-6">
            <a href="{{ route('claims.create') }}" class="flex items-center justify-center w-full px-6 py-3 font-bold transition duration-300 ease-in-out bg-purple-600 rounded-lg shadow-lg text-dark hover:bg-purple-700 md:w-auto">
                <i class="mr-2 fas fa-plus-circle"></i> Quick Submit New Claim
            </a>
        </div>

        <div class="grid grid-cols-1 gap-6 mb-6 lg:grid-cols-3">
            
            <div class="p-6 bg-white border-t-4 border-red-500 rounded-lg shadow-md lg:col-span-1">
                <h3 class="flex items-center mb-4 text-xl font-semibold text-gray-800">
                    <i class="mr-2 text-red-500 fas fa-clock"></i> Monthly Submission Deadline
                </h3>
                <p class="mb-2 text-sm text-gray-600">
                    Claims submitted by the {{ $data['date_salary'] }}th are processed in the current payroll cycle.
                </p>
                <div class="p-3 text-center rounded-md bg-gray-50">
                    <p class="text-xs text-gray-500 uppercase">Submit By {{ $data['date_salary'] }}th of Month</p>
                    <h2 class="text-3xl font-extrabold text-red-600" id="deadline-countdown">
                        <livewire:deadline-countdown />
                    </h2>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 lg:col-span-2 sm:grid-cols-2">
                <div class="p-6 bg-white border-l-4 border-yellow-500 rounded-lg shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium tracking-wider text-gray-500 uppercase">Pending Approvals</p>
                            <div class="text-2xl font-bold text-gray-900">{{ $data['claim_pending'] }}</div>
                        </div>
                        <i class="text-3xl text-yellow-500 opacity-75 fas fa-hourglass-half"></i>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Claims awaiting to review.</p>
                </div>

                <div class="p-6 bg-white border-l-4 border-green-500 rounded-lg shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium tracking-wider text-gray-500 uppercase">OT Hours (Current Month)</p>
                            <div class="text-2xl font-bold text-gray-900">{{ $data['totalHours'] }} hrs</div>
                        </div>
                        <i class="text-3xl text-green-500 opacity-75 fas fa-business-time"></i>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Total overtime hours this month.(Approved -> Paid)</p>
                </div>
            </div>
        </div>

        <div class="p-6 bg-white rounded-lg shadow-md">
            <h3 class="flex items-center pb-2 mb-4 text-xl font-semibold text-gray-800 border-b">
                <i class="mr-2 text-pink-600 fas fa-list-alt"></i> Recent Claim Submissions
            </h3>
            <livewire:staff-recent-claims-table />
        </div>
    </div>
</div>
@stop

@section('footer')
    
@stop
