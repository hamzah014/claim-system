@extends('adminlte::page')

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@stop


@section('content_header')

    <div class="d-flex align-items-center justify-content-between">
        <h1 class="m-0 text-dark">Staff Create</h1>
    </div>
@stop

@section('content')

    <div class="card">
        <div class="card-body">
            <form action="{{ $formUrl }}" method="POST">
                @csrf
                @method('POST')

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control"
                        value="{{ old('name', $staff->name) }}" required>
                        
                    @error('name')
                        <div class="invalid-feedback d-block">{{ __($message) }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" class="form-control"
                        value="{{ old('email', $staff->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback d-block">{{ __($message) }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="department_id">Assigned Department</label>
                    <select name="department_id" name="department_id" id="department_id" class="form-control">
                        <option value="">Please select</option>
                        @foreach($departmentList as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('department_id')
                        <div class="invalid-feedback d-block">{{ __($message) }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label>Involved Driving</label>

                    <div>
                        <label class="mr-3">
                            <input type="radio" name="req_driving" value="1"
                                {{ old('req_driving', @$claim->req_driving) == '1' ? 'checked' : '' }}>
                            Yes
                        </label>

                        <label>
                            <input type="radio" name="req_driving" value="0"
                                {{ old('req_driving', @$claim->req_driving) == '0' ? 'checked' : '' }}>
                            No
                        </label>
                    </div>

                    @error('req_driving')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="text" name="password" id="password" class="form-control" @if($type === 'create') required @endif >
                    @error('password')
                        <div class="invalid-feedback d-block">{{ __($message) }}</div>
                    @enderror
                </div>
                
                <a href="{{ route('admin.staff.index') }}" class="btn btn-secondary">{{ __('Back to Staff List') }}</a>
                <button type="submit" class="btn btn-primary">{{ __('Update Staff') }}</button>
            </form>
        </div>
    </div>
@stop

@push('js')

@endpush
