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
        <table class="table datatable table-bordered table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th class="text-center" scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Type</th>
                    <th class="text-center" scope="col">Status</th>
                    <th scope="col">Date Created</th>
                    <th class="text-center" scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($cases as $case)
                    <tr>
                        <td class="text-center" data-label="#">{{ $loop->iteration }}.</td>
                        <td data-label="Name">{{ Str::title($case->case_title) }}</td>
                        <td data-label="Email">{{ Str::title($case->case_type) }}</td>
                        <td class="text-center" data-label="Role">
                            @php
                                $statusClasses = [
                                    'closed' => ['class' => 'badge bg-danger', 'label' => 'Closed'],
                                    'in_progress' => ['class' => 'badge bg-warning', 'label' => 'In-progress'],
                                    'resolved' => ['class' => 'badge bg-success', 'label' => 'Resolved'],
                                    'open' => ['class' => 'badge bg-primary', 'label' => 'Open'],
                                ];
                                $status = $statusClasses[$case->status] ?? [
                                    'class' => 'badge bg-secondary',
                                    'label' => Str::title(str_replace('_', ' ', $case->status)),
                                ];
                            @endphp
                            <span class="{{ $status['class'] }}">
                                {{ $status['label'] }}
                            </span>
                        </td>
                        <td data-label="DateCreated">{{ $case->created_at->format('F j, Y g:i A') }}</td>
                        <td class="text-center" data-label="Action">
                            <button class="btn btn-primary btn-sm editCaseBtn" data-id="{{ $case->id }}"
                                data-case_title="{{ $case->case_title }}" data-case_type="{{ $case->case_type }}"
                                data-guardian_name="{{ $case->guardian_name }}"
                                data-guardian_contact="{{ $case->guardian_contact }}"
                                data-status="{{ $case->status }}" data-notes="{{ $case->notes }}"
                                data-bs-toggle="modal" data-bs-target="#editCaseModal">
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
