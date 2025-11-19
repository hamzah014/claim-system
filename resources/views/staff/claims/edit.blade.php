@extends('adminlte::page')

@section('css')
@stop


@section('content_header')

    <div class="d-flex align-items-center justify-content-between">
        <h1 class="m-0 text-dark">Claim Submission</h1>
    </div>
@stop

@section('content')

    <div class="card">
        <div class="card-body">
            <form action="{{ $formUrl }}" method="POST" enctype="multipart/form-data" id="form_claim">
                @csrf
                @method('POST')

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="type">Claim Type</label>
                            <select name="type" id="type" class="form-control">
                                <option value="">-- Select Claim Type --</option>
                                <option value="ot" {{ old('type', $claim->type) == 'ot' ? 'selected' : '' }}>Overtime</option>
                                <option value="meal" {{ old('type', $claim->type) == 'meal' ? 'selected' : '' }}>Meal Allowance</option>
                                <option value="both" {{ old('type', $claim->type) == 'both' ? 'selected' : '' }}>Both</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback d-block">{{ __($message) }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="work_location">Work Location</label>
                            <select name="work_location" id="work_location" class="form-control" required>
                                <option value="">-- Select Work Location --</option>
                                <option value="office" {{ old('work_location', $claim->work_location) == 'office' ? 'selected' : '' }}>In-Office</option>
                                <option value="outside" {{ old('work_location', $claim->work_location) == 'outside' ? 'selected' : '' }}>Out-of-Office</option>
                            </select>   
                            @error('work_location')
                                <div class="invalid-feedback d-block">{{ __($message) }}</div>
                            @enderror
                        </div>
                    </div>
                    @if($claim->status)
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <input type="text" name="status" id="status" class="form-control"
                                value="{{ ucwords($claim->status) }}" disabled>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="duty_date">Date of Duty</label>
                            <input type="date" name="duty_date" id="duty_date" class="form-control"
                                value="{{ old('duty_date', $claim->duty_date) }}" required>
                            @error('duty_date')
                                <div class="invalid-feedback d-block">{{ __($message) }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="duty_start_time">Start Time</label>
                            <input type="time" name="duty_start_time" id="duty_start_time" class="form-control"
                                value="{{ old('duty_start_time', $claim->duty_start_time) }}">
                            @error('duty_start_time')
                                <div class="invalid-feedback d-block">{{ __($message) }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="duty_end_time">End Time</label>
                            <input type="time" name="duty_end_time" id="duty_end_time" class="form-control"
                                value="{{ old('duty_end_time', $claim->duty_end_time) }}">
                            @error('duty_end_time')
                                <div class="invalid-feedback d-block">{{ __($message) }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div id="outside-section">
                    <hr>
                    <h5>Out-of-Office Section</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="travel_start_time">Travel Start Time</label>
                                <input type="time" name="travel_start_time" id="travel_start_time" class="form-control"
                                    value="{{ old('travel_start_time', $claim->travel_start_time) }}">
                                @error('travel_start_time')
                                    <div class="invalid-feedback d-block">{{ __($message) }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="travel_end_time">Travel End Time</label>
                                <input type="time" name="travel_end_time" id="travel_end_time" class="form-control"
                                    value="{{ old('travel_end_time', $claim->travel_end_time) }}">
                                @error('travel_end_time')
                                    <div class="invalid-feedback d-block">{{ __($message) }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="travel_origin">Travel Origin</label>
                                <input type="text" name="travel_origin" id="travel_origin" class="form-control"
                                    value="{{ old('travel_origin', $claim->travel_origin) }}">
                                @error('travel_origin')
                                    <div class="invalid-feedback d-block">{{ __($message) }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="travel_destination">Travel Destination</label>
                                <input type="text" name="travel_destination" id="travel_destination" class="form-control"
                                    value="{{ old('travel_destination', $claim->travel_destination) }}">
                                @error('travel_destination')
                                    <div class="invalid-feedback d-block">{{ __($message) }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="travel_purpose">Purpose of Travel</label>
                                <textarea name="travel_purpose" id="travel_purpose" class="form-control" rows="3">{{ old('travel_purpose', $claim->travel_purpose) }}</textarea>
                                @error('travel_purpose')
                                    <div class="invalid-feedback d-block">{{ __($message) }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div id="document-section">
                    <hr>
                    <h5>Document Section</h5>
                    <div class="form-group">
                        <label for="attend_file">Attendance Record</label>
                        <input type="file" name="attend_file" id="attend_file" class="form-control">
                        @error('attend_file')
                            <div class="invalid-feedback d-block">{{ __($message) }}</div>
                        @enderror
                        @if (isset($claim->attendFiles))
                            <div class="mt-2 d-flex align-items-center justify-content-stretch">
                            @foreach ($claim->attendFiles as $attendFile)
                                <div class="p-2 mx-2 badge badge-light">
                                    {{ $attendFile->file_name . '.' . $attendFile->file_ext }} &nbsp;
                                    <a class="btn btn-sm btn-primary" href="{{ route('file.download', ['uuid' => $attendFile->file_uuid]) }}" target="_blank"><i class="fas fa-download"></i></a>
                                    @if(in_array($claim->status, ['draft']))
                                    <a class="btn btn-sm btn-danger" href="{{ route('file.delete', ['uuid' => $attendFile->file_uuid]) }}"><i class="fas fa-trash"></i></a>
                                    @endif
                                </div>
                            @endforeach
                            </div>
                        @endif
                    </div>
                    
                    <div class="form-group">
                        <label for="supporting_file">Supporting Document</label>
                        <input type="file" name="supporting_file" id="supporting_file" class="form-control">
                        @error('supporting_file')
                            <div class="invalid-feedback d-block">{{ __($message) }}</div>
                        @enderror
                        @if (isset($claim->supportFiles))
                            <div class="mt-2 d-flex align-items-center justify-content-stretch">
                            @foreach ($claim->supportFiles as $supportFile)
                                <div class="p-2 mx-2 badge badge-light">
                                    {{ $supportFile->file_name . '.' . $supportFile->file_ext }} &nbsp;
                                    <a class="btn btn-sm btn-primary" href="{{ route('file.download', ['uuid' => $supportFile->file_uuid]) }}" target="_blank"><i class="fas fa-download"></i></a>
                                    @if(in_array($claim->status, ['draft']))
                                    <a class="btn btn-sm btn-danger" href="{{ route('file.delete', ['uuid' => $supportFile->file_uuid]) }}"><i class="fas fa-trash"></i></a>
                                    @endif
                                </div>
                            @endforeach
                            </div>
                        @endif
                    </div>
                    
                    
                </div>

                @if ($claim->status == 'paid')
                
                
                <div id="receipt-section">
                    <hr>
                    <h5>Receipt Section</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="paymentDate">Payment Date</label>
                            <input type="date" name="paymentDate" id="paymentDate" class="form-control" value="{{ $claim->paymentDate() }}" disabled>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="attend_file">Payment Receipt</label>
                                @if (isset($claim->receiptFile))
                                    <div class="d-flex align-items-center justify-content-stretch">
                                    @foreach ($claim->receiptFile as $receiptFile)
                                        <div class="p-2 mx-2 badge badge-light">
                                            {{ $receiptFile->file_name . '.' . $receiptFile->file_ext }} &nbsp;
                                            <a class="btn btn-sm btn-primary" href="{{ route('file.download', ['uuid' => $receiptFile->file_uuid]) }}" target="_blank"><i class="fas fa-download"></i></a>
                                        </div>
                                    @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                </div>

                @elseif ($claim->status == 'rejected')
                
                <div id="reject-section">
                    <hr>
                    <h5>Rejection Section</h5>
                    <div class="form-group">
                        <label for="rejectReason">Rejection Reason</label>
                            <textarea name="rejectReason" id="rejectReason" class="form-control" rows="3" disabled>{{ $claim->rejection_reason }}</textarea>
                    </div>
                    
                </div>
                    
                @endif

                <input type="hidden" name="action" id="action" value="">
                
                <div class="mt-5 d-flex justify-content-between align-items-center">
                    <div>                            
                        <a href="{{ route('claims.index') }}" class="btn btn-secondary">{{ __('Back to Claim List') }}</a>
                    </div>
                    <div @if( $claim->status && !in_array($claim->status, ['draft'])) hidden @endif>
                        @if($claim->status == 'draft')
                        <a href="{{ route('claims.delete', $claim->id) }}" class="btn btn-danger">{{ __('Withdraw') }}</a>
                        @endif
                        <button type="button" id="submitDraft" class="btn btn-info">{{ __('Save as Draft') }}</button>
                        <button type="button" id="submitUpdate" class="btn btn-primary">{{ __('Submit Claim') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@push('js')

<script>

    $(document).ready(function() {

        $("#submitUpdate").click(function(e) {
            e.preventDefault();
            $("#action").val("submit");
            $("#form_claim").submit();
        });

        $("#submitDraft").click(function(e) {
            e.preventDefault();
            $("#action").val("draft");
            $("#form_claim").submit();
        });

        function toggleSections() {
            var claimType = $('#type').val();
            var workLocation = $('#work_location').val();

            // Show/hide Out-of-Office section
            if (workLocation === 'outside') {
                $('#outside-section').show();
            } else {
                $('#outside-section').hide();
            }
        }

        // Initial toggle on page load
        toggleSections();

        // Toggle sections on change
        $('#type, #work_location').change(function() {
            toggleSections();
        });
    });

    
</script>


@endpush
