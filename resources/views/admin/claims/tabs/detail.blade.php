<form action="{{ route('admin.claim.update.status', $claim) }}" method="POST" enctype="multipart/form-data"
    id="form_claim">
    @csrf
    @method('POST')

    <div class="card">
        <div class="card-body">

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="type">Claim Type</label>
                        <select name="type" id="type" class="form-control" disabled>
                            <option value="">-- Select Claim Type --</option>
                            <option value="ot" {{ old('type', $claim->type) == 'ot' ? 'selected' : '' }}>Overtime
                            </option>
                            <option value="meal" {{ old('type', $claim->type) == 'meal' ? 'selected' : '' }}>Meal
                                Allowance</option>
                            <option value="both" {{ old('type', $claim->type) == 'both' ? 'selected' : '' }}>Both
                            </option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback d-block">{{ __($message) }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="work_location">Work Location</label>
                        <select name="work_location" id="work_location" class="form-control" disabled>
                            <option value="">-- Select Work Location --</option>
                            <option value="office"
                                {{ old('work_location', $claim->work_location) == 'office' ? 'selected' : '' }}>
                                In-Office</option>
                            <option value="outside"
                                {{ old('work_location', $claim->work_location) == 'outside' ? 'selected' : '' }}>
                                Out-of-Office</option>
                        </select>
                        @error('work_location')
                            <div class="invalid-feedback d-block">{{ __($message) }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <input type="text" name="status" id="status" class="form-control"
                            value="{{ ucwords($claim->status) }}" disabled>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="duty_date">Date of Duty</label>
                        <input type="date" name="duty_date" id="duty_date" class="form-control"
                            value="{{ old('duty_date', $claim->duty_date) }}" disabled>
                        @error('duty_date')
                            <div class="invalid-feedback d-block">{{ __($message) }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="duty_start_time">Start Time</label>
                        <input type="time" name="duty_start_time" id="duty_start_time" class="form-control"
                            value="{{ old('duty_start_time', $claim->duty_start_time) }}" disabled>
                        @error('duty_start_time')
                            <div class="invalid-feedback d-block">{{ __($message) }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="duty_end_time">End Time</label>
                        <input type="time" name="duty_end_time" id="duty_end_time" class="form-control"
                            value="{{ old('duty_end_time', $claim->duty_end_time) }}" disabled>
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
                                value="{{ old('travel_start_time', $claim->travel_start_time) }}" disabled>
                            @error('travel_start_time')
                                <div class="invalid-feedback d-block">{{ __($message) }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="travel_end_time">Travel End Time</label>
                            <input type="time" name="travel_end_time" id="travel_end_time" class="form-control"
                                value="{{ old('travel_end_time', $claim->travel_end_time) }}" disabled>
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
                                value="{{ old('travel_origin', $claim->travel_origin) }}" disabled>
                            @error('travel_origin')
                                <div class="invalid-feedback d-block">{{ __($message) }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="travel_destination">Travel Destination</label>
                            <input type="text" name="travel_destination" id="travel_destination"
                                class="form-control"
                                value="{{ old('travel_destination', $claim->travel_destination) }}" disabled>
                            @error('travel_destination')
                                <div class="invalid-feedback d-block">{{ __($message) }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="travel_purpose">Purpose of Travel</label>
                            <textarea name="travel_purpose" id="travel_purpose" class="form-control" rows="3" disabled>{{ old('travel_purpose', $claim->travel_purpose) }}</textarea>
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
                    @if (isset($claim->attendFiles))
                        <div class="mt-2 d-flex align-items-center justify-content-stretch">
                            @foreach ($claim->attendFiles as $attendFile)
                                <div class="p-2 mx-2 badge badge-light">
                                    {{ $attendFile->file_name . '.' . $attendFile->file_ext }} &nbsp;
                                    <a class="btn btn-sm btn-primary"
                                        href="{{ route('file.download', ['uuid' => $attendFile->file_uuid]) }}"
                                        target="_blank"><i class="fas fa-download"></i></a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="supporting_file">Supporting Document</label>
                    @if (isset($claim->supportFiles))
                        <div class="mt-2 d-flex align-items-center justify-content-stretch">
                            @foreach ($claim->supportFiles as $supportFile)
                                <div class="p-2 mx-2 badge badge-light">
                                    {{ $supportFile->file_name . '.' . $supportFile->file_ext }} &nbsp;
                                    <a class="btn btn-sm btn-primary"
                                        href="{{ route('file.download', ['uuid' => $supportFile->file_uuid]) }}"
                                        target="_blank"><i class="fas fa-download"></i></a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>


            </div>

            <div id="total-section">
                <hr>
                <h5>Calculate Section</h5>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="total_ot">Total OT (RM)</label>
                            <div class="mb-3 input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">RM</span>
                                </div>
                                <input type="number" class="form-control" name="total_ot" id="total_ot"
                                    value="{{ $claim->detail->total_ot }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="total_allowance">Total Meal Allowance (RM)</label>
                            <div class="mb-3 input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">RM</span>
                                </div>
                                <input type="number" class="form-control" name="total_allowance"
                                    id="total_allowance" value="{{ $claim->detail->total_allowance }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="overall">Total Overall (RM)</label>
                            <div class="mb-3 input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">RM</span>
                                </div>
                                <input type="number" class="form-control" name="overall" id="overall"
                                    value="{{ $claim->detail->overall }}" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if (!in_array($claim->status, ['draft', 'pending', 'rejected']))
                <div id="reject-section">
                    <hr>
                    <h5>Remark Section</h5>
                    <div class="form-group">
                        <label for="approve_remark">Remark</label>
                        <textarea name="approve_remark" id="approve_remark" class="form-control" rows="3" disabled>{{ $claim->approve_remark }}</textarea>
                    </div>

                </div>
            @endif

            @if ($claim->status == 'paid')


                <div id="receipt-section">
                    <hr>
                    <h5>Receipt Section</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="paymentDate">Payment Date</label>
                            <input type="date" name="paymentDate" id="paymentDate" class="form-control"
                                value="{{ $claim->paymentDate() }}" disabled>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="attend_file">Payment Receipt</label>
                                @if (isset($claim->receiptFile))
                                    <div class="d-flex align-items-center justify-content-stretch">
                                        @foreach ($claim->receiptFile as $receiptFile)
                                            <div class="p-2 mx-2 badge badge-light">
                                                {{ $receiptFile->file_name . '.' . $receiptFile->file_ext }} &nbsp;
                                                <a class="btn btn-sm btn-primary"
                                                    href="{{ route('file.download', ['uuid' => $receiptFile->file_uuid]) }}"
                                                    target="_blank"><i class="fas fa-download"></i></a>
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
            @error('action')
                <div class="invalid-feedback d-block">{{ __($message) }}</div>
            @enderror

            <div class="mt-5 d-flex justify-content-between align-items-center">
                <div>
                    <a href="{{ route('admin.claim.index') }}"
                        class="btn btn-secondary">{{ __('Back to Claim List') }}</a>
                </div>

                {{-- draft, pending, approved, rejected, processed, paid --}}

                @if ($claim->status == 'pending')
                    @canany(['menu-approver', 'menu-admin'])
                        <div>
                            <button type="button" class="btn btn-danger submit-action"
                                data-action="rejected">{{ __('Rejected') }}</button>
                            <button type="button" class="btn btn-primary submit-action"
                                data-action="approved">{{ __('Approved') }}</button>
                        </div>
                    @endcanany
                @elseif ($claim->status == 'approved')
                    @canany(['menu-hrAdmin', 'menu-admin'])
                        <div>
                            <button type="button" class="btn btn-primary submit-action"
                                data-action="processed">{{ __('Processing') }}</button>
                        </div>
                    @endcanany
                @elseif ($claim->status == 'processed')
                    @canany(['menu-payroll', 'menu-admin'])
                        <div>
                            <button type="button" class="btn btn-primary submit-action"
                                data-action="paid">{{ __('Mark as Paid') }}</button>
                        </div>
                    @endcanany
                @endif
            </div>

        </div>
    </div>


    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title" id="rejectModalLabel">Reject Claim</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="reject_reason">Reject Reason:</label>
                        <textarea name="reject_reason" id="reject_reason" class="form-control" rows="3">{{ old('reject_reason') }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="approveModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="approveModalLabel">Approval Claim</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="approve_remark">Approval Remark:</label>
                        <textarea name="approve_remark" id="approve_remark" class="form-control" rows="3">{{ old('approve_remark') }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="paidModal" tabindex="-1" role="dialog" aria-labelledby="paidModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="paidModalLabel">Claim Payment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="payment_date">Payment Date:</label>
                                <input type="date" name="payment_date" id="payment_date" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="receipt">Payment Receipt:</label>
                                <input type="file" name="receipt" id="receipt" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>


</form>

@push('js-script')
    <script>
        $(document).ready(function() {

            $('.submit-action').click(function() {
                var action = $(this).data('action');

                if (action == 'rejected') {
                    $("#action").val("rejected");
                    $('#rejectModal').modal('show');

                } else if (action == 'approved') {
                    $("#action").val("approved");
                    $('#approveModal').modal('show');

                } else if (action == 'processed') {
                    if (confirm('Are you sure you want to process this claim?')) {
                        $("#action").val("processed");
                        $('#form_claim').submit();
                    }

                } else if (action == 'paid') {
                    $("#action").val("paid");
                    $('#paidModal').modal('show');
                }

            });

        });
    </script>

    <script>
        $(document).ready(function() {

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
