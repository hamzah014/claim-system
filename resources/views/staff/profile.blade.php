@extends('adminlte::page')

@section('css')

@stop


@section('content_header')

    <div class="d-flex align-items-center justify-content-between">
        <h1 class="m-0 text-dark">My Profile</h1>
    </div>
@stop

@section('content')
    

    <div class="card">
        <div class="card-body">
            <form action="{{ route('profile.update', $user) }}" method="POST" enctype="multipart/form-data" id="form_claim">
                @csrf
                @method('POST')

                <h5>Profile Information</h5>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" id="email" class="form-control"
                                value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback d-block">{{ __($message) }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback d-block">{{ __($message) }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="department_id">Department</label>
                            <select name="department_id" name="department_id" id="department_id" class="form-control">
                                <option value="">Please select</option>
                                @foreach($departmentList as $id => $name)
                                    <option value="{{ $id }}" @if($user->department_id == $id) selected @endif>{{ $name }}</option>
                                @endforeach
                            </select>
                            @error('department_id')
                                <div class="invalid-feedback d-block">{{ __($message) }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="mt-2 d-flex justify-content-between align-items-center">
                    <div>
                        <button type="submit" class="btn btn-primary">{{ __('Update Profile') }}</button>
                    </div>
                </div>
            </form>
            
        </div>
    </div>
    <div class="mt-2 card">
        <div class="card-body">
            <form action="{{ route('profile.update.password', $user) }}" method="POST" id="form_password">
                @csrf
                @method('POST')

                <h5>Password Management</h5>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input type="password" name="password" id="password"
                                class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ __($message) }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password_confirmation">Confirm New Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control @error('password_confirmation') is-invalid @enderror" required>
                            @error('password_confirmation')
                                <div class="invalid-feedback d-block">{{ __($message) }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-2 d-flex justify-content-between align-items-center">
                    <button type="submit" class="btn btn-primary">{{ __('Update Password') }}</button>
                </div>
            </form>

            
        </div>
    </div>

@stop

@push('js')

@endpush
