@extends('adminlte::page')

@section('css')

@stop


@section('content_header')

    <div class="d-flex align-items-center justify-content-between">
        <h1 class="m-0 text-dark">Department Management</h1>
        <button class="btn btn-sm btn-primary open-form" data-action="create"><i class="mx-2 fa fr fa-plus"></i> New Department</button>
    </div>
@stop

@section('content')

    <div class="table p-2 mt-3 table-responsive table-custom">
        {{ $dataTable->table() }}
    </div>

    <div class="modal fade" id="departModal" tabindex="-1" role="dialog" aria-labelledby="departModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="departModalLabel"><text id="depart_title"></text> Department</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" method="POST" enctype="multipart/form-data" id="form_department">
                    @csrf
                    @method('POST')
                    
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="depart_name">Name</label>
                                    <input type="text" name="depart_name" id="depart_name" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="manager_name">Choose Manager</label>
                                    <select name="manager_id" name="manager_id" id="manager_id" class="form-control">
                                        <option value="">Please select</option>
                                        @foreach($adminApprover as $approver)
                                            <option value="{{ $approver->id }}">{{ $approver->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    
                </form>

            </div>
        </div>
    </div>

@stop

@push('js')
    {{ $dataTable->scripts() }}

    <script>

        $(document).on('click', '.open-form', function () {
            var action = $(this).data('action');
            var departTitle = "";
            resetForm();

            if (action == 'create'){
                departTitle = 'Create';
                formAction = '{{ route('admin.department.store') }}';
            }
            else if (action == 'edit'){
                var departId = $(this).data('depart');
                loadData(departId);
                departTitle = 'Edit';
                formAction = "{{ route('admin.department.update', '__ID__') }}";
                formAction = formAction.replace('__ID__', departId);
            }

            $('#depart_title').html(departTitle);
            $("#form_department").attr('action', formAction);
            $('#departModal').modal('show');
        });

        function loadData(id)
        {
            
            formData = new FormData($('#form_department')[0]);
            formData.append('id', id);

            $.ajax({
                url: "{{ route('admin.department.data.get') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    console.log(response);

                    if (response.success) {
                        
                        departData = response.data;
                        console.log(departData);
                        $('#depart_name').val(departData.name);
                        $('#manager_id').val(departData.manager_id).trigger('change');

                    }
                },
                error: function(error) {
                    
                    console.log('error', error);

                    var response = error.responseJSON;
                    console.log(response);

                    if (response && response.error) {
                        // Laravel validation errors
                        var messages = [];

                        for (var field in response.error) {
                            if (response.error.hasOwnProperty(field)) {
                                messages.push(response.error[field].join(', '));
                            }
                        }

                        alert('Error:\n' + messages.join('\n'));
                    } 
                    else if (response && response.message) {
                        // Other error message
                        alert('Error - ' + response.message);
                    } 
                    else {
                        alert('An unknown error occurred!');
                    }
                    
                    $('#' + type + 'Preview').html(`<div class="text-center text-danger">
                        <i class="fa fa-times-circle"></i> Failed to generate
                    </div>`);
                }
            });


        }

        function resetForm()
        {

            $('#depart_name').val("");
            $('#manager_id').val("");

        }

    </script>

@endpush
