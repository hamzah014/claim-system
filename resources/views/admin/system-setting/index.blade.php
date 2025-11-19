@extends('adminlte::page')

@section('css')

@stop


@section('content_header')

    <div class="d-flex align-items-center justify-content-between">
        <h1 class="m-0 text-dark">System Setting Management</h1>
    </div>
@stop

@section('content')
    

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.setting.update', $setting) }}" method="POST" enctype="multipart/form-data" id="form_claim">
                @csrf
                @method('POST')
                
                <h5>Scheduling & Submission</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="submit_day_allow" class="form-label">Submit Day Allow (Days)</label>
                            <input type="number" name="submit_day_allow" id="submit_day_allow" class="form-control" value="{{ $setting->submit_day_allow }}" placeholder="e.g., 5">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date_salary" class="form-label">Payroll Date (Day of Month)</label>
                            <input type="number" name="date_salary" id="date_salary" class="form-control" value="{{ $setting->date_salary }}" placeholder="e.g., 25">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="working_start" class="form-label">Standard Working Start Time</label>
                            <input type="time" name="working_start" id="working_start" class="form-control" value="{{ $setting->working_start }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="working_end" class="form-label">Standard Working End Time</label>
                            <input type="time" name="working_end" id="working_end" class="form-control" value="{{ $setting->working_end }}">
                        </div>
                    </div>
                </div>
                
                <hr>
                
                <h5>Financial Allowances</h5>
                <div class="form-group">
                    <label for="meal_allowance" class="form-label">Daily Meal Allowance</label>
                    <input type="number" step="0.01" name="meal_allowance" id="meal_allowance" class="form-control" value="{{ $setting->meal_allowance }}" placeholder="e.g., 15.00">
                </div>

                <hr>

                <h5>Overtime(OT) Rates</h5>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="ot_rate" class="form-label">Standard OT Rate Multiplier</label>
                            <input type="number" step="0.01" name="ot_rate" id="ot_rate" class="form-control" value="{{ $setting->ot_rate }}" placeholder="e.g., 1.5">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="ot_weekend_rate" class="form-label">OT Weekend Rate Multiplier</label>
                            <input type="number" step="0.01" name="ot_weekend_rate" id="ot_weekend_rate" class="form-control" value="{{ $setting->ot_weekend_rate }}" placeholder="e.g., 2.0">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="ot_holiday_rate" class="form-label">OT Holiday Rate Multiplier</label>
                            <input type="number" step="0.01" name="ot_holiday_rate" id="ot_holiday_rate" class="form-control" value="{{ $setting->ot_holiday_rate }}" placeholder="e.g., 3.0">
                        </div>
                    </div>
                </div>

                <hr>

                <h5>OT Meal Rules</h5>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="first_ot_meal_hrs" class="form-label">First OT Meal Hours Required</label>
                            <input type="number" name="first_ot_meal_hrs" id="first_ot_meal_hrs" class="form-control" value="{{ $setting->first_ot_meal_hrs }}" placeholder="e.g., 2">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="first_ot_meal_time" class="form-label">First OT Meal Cutoff Time</label>
                            <input type="time" name="first_ot_meal_time" id="first_ot_meal_time" class="form-control" value="{{ $setting->first_ot_meal_time }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="extra_ot_meal_hrs" class="form-label">Extra OT Meal Hours Increment</label>
                            <input type="number" name="extra_ot_meal_hrs" id="extra_ot_meal_hrs" class="form-control" value="{{ $setting->extra_ot_meal_hrs }}" placeholder="e.g., 4">
                        </div>
                    </div>
                </div>
                
                <div class="mt-5 d-flex justify-content-between align-items-center">
                    <div>
                        <button type="submit" class="btn btn-primary">{{ __('Update Setting') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@stop

@push('js')

@endpush
