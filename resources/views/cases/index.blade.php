<x-app-layout>
    @section('title', 'Case Management')

    <div class="row">
        <div class="col-md-10 mb-2">
            <h1>Case Management</h1>
        </div>
        <div class="col-md-2">
            <button type="button" role="button" class="btn btn-success mt-2" data-bs-toggle="modal"
                data-bs-target="#addCaseModal">
                <i class="fa-solid fa-folder-plus mr-2"></i>
                Add Case
            </button>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-custom">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Role</th>
                    <th scope="col">Date Created</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($cases as $case)
                    <tr>
                        <td data-label="#">{{ $loop->iteration }}.</td>
                        <td data-label="Name">{{ $case->case_title }}</td>
                        <td data-label="Email">{{ $case->case_type }}</td>
                        <td data-label="Role">{{ $case->status }}</td>
                        <td data-label="DateCreated">{{ $case->created_at->format('F j, Y g:i A') }}</td>
                        <td data-label="Action">
                            <button class="btn btn-primary btn-sm editCaseBtn" data-id="{{ $case->id }}"
                                data-case_title="{{ $case->case_title }}" data-case_type="{{ $case->case_type }}"
                                data-guardian_name="{{ $case->guardian_name }}"
                                data-guardian_contact="{{ $case->guardian_contact }}" data-status="{{ $case->status }}"
                                data-notes="{{ $case->notes }}" data-bs-toggle="modal"
                                data-bs-target="#editCaseModal">
                                <i class="fa fa-edit"></i>
                            </button>

                            {{-- Reusable Delete Button --}}
                            @include('components.delete-button', [
                                'id' => $case->id,
                                'route' => route('cases.destroy', $case->id),
                                'itemName' => $case->case_title,
                            ])
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="text-center">No data found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>



    @include('cases.modals.addCase')

</x-app-layout>
