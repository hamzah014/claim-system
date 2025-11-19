@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')

<div class="min-h-screen p-6 bg-gray-100">
    <div class="mx-auto max-w-7xl">
        
        <h2 class="mb-6 text-2xl font-bold text-gray-800">Payroll Processing View</h2>

        <div class="p-6 bg-white rounded-lg shadow-md">
            <h3 class="flex items-center pb-2 mb-4 text-xl font-semibold text-gray-800 border-b">
                <i class="mr-2 text-green-600 fas fa-money-check-alt"></i> Claims Awaiting Payment Confirmation
            </h3>
            <p class="mb-4 text-sm text-gray-600">Update the status to **Paid** once payment has been completed and reconciled with the payroll system.</p>
            
            <livewire:payroll-payment-queue />
        </div>
    </div>
</div>

<form action="#" method="POST" enctype="multipart/form-data" id="form_claim">
    @csrf
    @method('POST')

    <input type="hidden" name="action" id="action" value="">

    
    <div class="modal fade" id="paidModal" tabindex="-1" role="dialog" aria-labelledby="paidModalLabel" aria-hidden="true">
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

@stop

@push('js')

    <script>
        
        $(document).on('click', '.open-form', function () {
            var action = $(this).data('action');
            
            $("#action").val("paid");
            
            var dataId = $(this).data('id');
            formAction = "{{ route('admin.claim.update.status', '__ID__') }}";
            formAction = formAction.replace('__ID__', dataId);
            $("#form_claim").attr('action', formAction);
            $('#paidModal').modal('show');
        });
    </script>
    
@endpush