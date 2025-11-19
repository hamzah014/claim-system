@extends('adminlte::page')

@section('css')
@stop


@section('content_header')

    <div class="d-flex align-items-center justify-content-between">
        <h1 class="m-0 text-dark">Staff Management</h1>
        <a href="{{ route('admin.staff.create') }}" class="mb-3 btn btn-primary">Add New Staff</a>
    </div>
@stop

@section('content')


    <div class="table p-2 mt-3 table-responsive table-custom">
        {{ $dataTable->table() }}
    </div>


@stop

@push('js')
    {{ $dataTable->scripts() }}
@endpush
