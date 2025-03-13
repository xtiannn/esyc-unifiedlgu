<x-app-layout>
    @section('title', 'Audit Logs')

    <div class="row">
        <div class="col-md-10">
            <h1>Audit Logs</h1>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table datatable table-bordered table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th class="text-center" scope="col">#</th>
                    <th scope="col">User</th>
                    <th scope="col">Action</th>
                    <th scope="col">Model</th>
                    <th scope="col">Description</th>
                    <th scope="col">Timestamp</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $count = 0;
                @endphp
                @forelse ($auditLogs as $log)
                    <tr>
                        <td class="text-center">{{ ++$count }}.</td>
                        <td>{{ Str::title($log->user->name ?? 'Unknown') }}</td>
                        <td>{{ $log->action }}</td>
                        <td>{{ $log->model }}</td>
                        <td>{{ $log->description }}</td>
                        <td>{{ $log->created_at->format('F j, Y g:i A') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="text-center">No data found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>


    {{ $auditLogs->links() }}

</x-app-layout>
