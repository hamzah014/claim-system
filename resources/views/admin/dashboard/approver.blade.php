@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')

    <div class="min-h-screen p-6 bg-gray-100">
        <div class="mx-auto max-w-7xl">

            <div class="grid grid-cols-1 gap-6 mb-6 lg:grid-cols-3">

                <div class="p-6 bg-white border-t-4 border-purple-600 rounded-lg shadow-md lg:col-span-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium tracking-wider text-gray-500 uppercase">Claims Requiring Action</p>
                            <div class="mt-1 text-4xl font-extrabold text-purple-600">
                                {{ $data['pending_approval_count'] ?? 0 }}
                            </div>
                        </div>
                        <i class="text-5xl text-purple-400 opacity-75 fas fa-bell"></i>
                    </div>
                    <p class="mt-3 text-xs text-gray-500">Claims awaiting your review.</p>
                </div>
            </div>

            <div class="p-6 mb-6 bg-white rounded-lg shadow-md">
                <h3 class="flex items-center pb-2 mb-4 text-xl font-semibold text-gray-800 border-b">
                    <i class="mr-2 text-yellow-500 fas fa-tasks"></i> Claims Awaiting Your Approval
                </h3>
                <livewire:approver-action-queue />
                <p class="mt-3 text-xs text-gray-500">Includes quick approve/reject capabilities.</p>
            </div>

            <div class="p-6 bg-white rounded-lg shadow-md">
                <h3 class="flex items-center pb-2 mb-4 text-xl font-semibold text-gray-800 border-b">
                    <i class="mr-2 text-blue-500 fas fa-history"></i> Your Approval History
                </h3>
                <livewire:approval-history-table />
                <p class="text-sm text-gray-600">A list of your recent approval or rejection decisions.</p>
            </div>
        </div>
    </div>


    <form action="#" method="POST" enctype="multipart/form-data" id="form_claim">
        @csrf
        @method('POST')
    
        <input type="hidden" name="action" id="action" value="">
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
                            <textarea name="reject_reason" id="reject_reason" class="form-control" rows="3"></textarea>
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
        $(document).on('click', '.open-form', function() {
            var action = $(this).data('action');
            var dataId = $(this).data('id');

            formAction = "{{ route('admin.claim.update.status', '__ID__') }}";
            formAction = formAction.replace('__ID__', dataId);
    
            $("#action").val("approved");

            $("#form_claim").attr('action', formAction);
            $('#rejectModal').modal('show');

        });
    </script>
@endpush
