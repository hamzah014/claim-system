
    <div class="log-table-wrapper">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Date Time</th>
                    <th>Action</th>
                    <th>User</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
                @foreach($claim->auditTrails as $log)
                    <tr>
                        <td>{{ $log->createdAt() }}</td>
                        <td>{{ __('adminlte::adminlte.' . $log->action) }}</td>
                        <td>{{ $log->user?->name ?? '-' }}</td>
                        <td>{{ ucwords($log->user_role) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>