@extends('adminlte::page')

@section('css')

@stop


@section('content_header')

    <div class="d-flex align-items-center justify-content-between">
        <h1 class="m-0 text-dark">Public Holiday Management</h1>
        <button class="btn btn-sm btn-primary open-form" data-action="create"><i class="mx-2 fa fr fa-plus"></i> New Holiday</button>
    </div>
@stop

@section('content')

    <div class="table p-2 mt-3 table-responsive table-custom">
        {{ $dataTable->table() }}
    </div>

    <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="formModalLabel"><text id="form_title"></text> Holiday</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" method="POST" enctype="multipart/form-data" id="form_submit">
                    @csrf
                    @method('POST')
                    
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="assign_date">Holiday Date</label>
                            <input type="date" name="assign_date" id="assign_date" class="form-control" required>
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
            var formTitle = "";
            resetForm();

            if (action == 'create'){
                formTitle = 'Create';
                formAction = '{{ route('admin.holiday.store') }}';
            }
            else if (action == 'edit'){
                var dataId = $(this).data('id');
                loadData(dataId);
                formTitle = 'Edit';
                formAction = "{{ route('admin.holiday.update', '__ID__') }}";
                formAction = formAction.replace('__ID__', dataId);
            }

            $('#form_title').html(formTitle);
            $("#form_submit").attr('action', formAction);
            $('#formModal').modal('show');
        });

        function loadData(id)
        {
            
            formData = new FormData($('#form_submit')[0]);
            formData.append('id', id);

            $.ajax({
                url: "{{ route('admin.holiday.data.get') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    console.log(response);

                    if (response.success) {
                        
                        returnData = response.data;
                        console.log(returnData);
                        $('#name').val(returnData.name);
                        $('#assign_date').val(returnData.assign_date);

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

            $('#name').val("");
            $('#assign_date').val("");

        }

    </script>

@endpush
