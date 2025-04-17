{{-- resources\views\scholarship\requirements.blade.php --}}
<x-app-layout>
    @section('title', 'Requirements Management')

    <div class="row mb-3">
        <div class="col-md-10">
            <h1>Requirements Management</h1>
        </div>
    </div>

    <div class="alert alert-info d-flex align-items-center" role="alert">
        <div class="row w-100">
            <div class="col-md-10">
                <h5 class="mb-0">
                    Requirements Status:
                    <span class="text-muted">
                        {{ $totalRequirements }} total requirements.
                    </span>
                </h5>
            </div>
            <div class="col-md-2 text-end">
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addRequirementModal">
                    <i class="fas fa-plus"></i> Add New Requirement
                </button>
            </div>
        </div>
    </div>

    <!-- Add New Requirement Modal -->
    <div class="modal fade" id="addRequirementModal" tabindex="-1" aria-labelledby="addRequirementLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fw-bolder" id="addRequirementLabel" style="font-size: 25px">
                        Add New Requirement
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('requirements.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-floating mb-2">
                            <input type="text" class="form-control form-control-sm" name="requirement_name"
                                placeholder="Requirement Name" required>
                            <label>Requirement Name</label>
                        </div>
                        <div class="form-floating mb-2">
                            <textarea class="form-control form-control-sm" name="description" placeholder="Description" required></textarea>
                            <label>Description</label>
                        </div>
                    </div>
                    <div class="modal-footer mt-2">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-save"></i> Save Requirement
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Requirements Table -->
    <div class="table-responsive">
        <table class="table datatable table-bordered table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th class="text-center">#</th>
                    <th>Requirement Name</th>
                    <th>Description</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requirements as $requirement)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}.</td>
                        <td>{{ Str::title($requirement->name) }}</td>
                        <td>{{ Str::limit($requirement->description, 50) }}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#editRequirement{{ $requirement->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            @include('components.delete-button', [
                                'id' => $requirement->id,
                                'route' => route('requirements.destroy', $requirement->id),
                                'itemName' => $requirement->name,
                            ])
                        </td>
                    </tr>

                    <!-- Edit Requirement Modal -->
                    <div class="modal fade" id="editRequirement{{ $requirement->id }}" tabindex="-1"
                        aria-labelledby="editRequirementLabel{{ $requirement->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editRequirementLabel{{ $requirement->id }}">Edit
                                        Requirement</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form
                                    action="
                                {{ route('requirements.update', $requirement->id) }}
                                 "
                                    method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="form-floating mb-2">
                                            <input type="text" class="form-control form-control-sm"
                                                name="requirement_name" value="{{ $requirement->name }}" required>
                                            <label>Requirement Name</label>
                                        </div>
                                        <div class="form-floating mb-2">
                                            <textarea class="form-control form-control-sm" name="description" required>{{ $requirement->description }}</textarea>
                                            <label>Description</label>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Save Changes
                                        </button>
                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                                            <i class="fas fa-times"></i> Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Select all modals and listen for the "hidden.bs.modal" event
            document.querySelectorAll('.modal').forEach(modal => {
                modal.addEventListener('hidden.bs.modal', function(event) {
                    // Refresh the page when specific modals close
                    if (event.target.id.startsWith('editRequirement') || event.target.id.startsWith(
                            'deleteRequirement')) {
                        location.reload();
                    }
                });
            });
        });
    </script>

</x-app-layout>
