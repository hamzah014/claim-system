@extends('adminlte::page')

@section('css')
@stop

@section('content_header')
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="m-0 text-dark">Claim - {{ $claim->reference_no }}</h1>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="p-2 card-header">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link active" href="#details" data-toggle="tab">Details</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#log" data-toggle="tab">Log</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane active" id="details">
                    @include('admin.claims.tabs.detail')
                </div>
                <div class="tab-pane" id="log">
                    @include('admin.claims.tabs.log')
                </div>
            </div>
        </div>
    </div>
@stop

@push('js')
<script>
    // Activate the first tab (optional)
    $(function () {
        $('.nav-pills a:first').tab('show');
    });
</script>
@stack('js-script')
@endpush
