<x-app-layout>
    <div class="row">
        <div class="col-md-10">
            <h1>Scholarships</h1>
        </div>
    </div>
    <div class="alert alert-info d-flex align-items-center" role="alert">
        <div>
            <h5 class="mb-0">Interview Slots: <span class="text-muted">4/10 available.</span></h5>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-custom">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Contact</th>
                    <th scope="col">Status</th>
                    <th scope="col">Application Date</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($scholarships as $scholarship)
                    <tr>
                        <td>{{ $scholarship->user->id }}</td>
                        <td>{{ $scholarship->user->name }}</td>
                        <td>{{ $scholarship->user->email }}</td>
                        <td>{{ $scholarship->user->email }}</td>
                        <td>{{ $scholarship->application_status }}</td>
                        <td>{{ $scholarship->application_date }}</td>
                        <td>
                            <div>
                                <button class="btn btn-primary">View</button>
                            </div>
                        </td>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
