@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')

<div class="min-h-screen p-6 bg-gray-100">
    <div class="mx-auto max-w-7xl">

        <h2 class="mb-4 text-2xl font-bold text-gray-800">Organization-Wide Claim Oversight</h2>

        <div class="grid grid-cols-1 gap-6 mb-6 sm:grid-cols-2 lg:grid-cols-4">
            
            <div class="p-6 bg-white border-l-4 border-yellow-500 rounded-lg shadow-md">
                <p class="text-sm font-medium tracking-wider text-gray-500 uppercase">Pending Approval</p>
                <div class="text-2xl font-bold text-gray-900">{{ $data['total_pending'] ?? 0 }}</div>
            </div>
            
            <div class="p-6 bg-white border-l-4 border-pink-600 rounded-lg shadow-md">
                <p class="text-sm font-medium tracking-wider text-gray-500 uppercase">Awaiting HR Processing</p>
                <div class="text-2xl font-bold text-gray-900">{{ $data['total_approved'] ?? 0 }}</div>
            </div>

            <div class="p-6 bg-white border-l-4 border-green-500 rounded-lg shadow-md">
                <p class="text-sm font-medium tracking-wider text-gray-500 uppercase">Processed (Awaiting Payment)</p>
                <div class="text-2xl font-bold text-gray-900">{{ $data['total_processed'] ?? 0 }}</div>
            </div>
            
            <div class="p-6 bg-white border-l-4 border-gray-500 rounded-lg shadow-md">
                <p class="text-sm font-medium tracking-wider text-gray-500 uppercase">Rejected Claims</p>
                <div class="text-2xl font-bold text-gray-900">{{ $data['total_rejected'] ?? 0 }}</div>
            </div>
        </div>

        <div class="p-6 mb-6 bg-white rounded-lg shadow-md">
            <h3 class="flex items-center pb-2 mb-4 text-xl font-semibold text-gray-800 border-b">
                <i class="mr-2 text-pink-600 fas fa-inbox"></i> Approved Claims Awaiting HR Processing
            </h3>
            <p class="mb-4 text-sm text-gray-600">Review approved claims, verify calculations, and mark as Processed.</p>
            <livewire:hr-processing-queue />
        </div>
    </div>
</div>

@stop