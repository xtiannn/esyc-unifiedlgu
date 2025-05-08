<x-app-layout>
    @section('title', 'Requirements Management')

    <div class="row mb-3">
        <div class="col-md-10">
            <h1>Requirements Management</h1>
        </div>
    </div>

    <style>
        .form-select-warning {
            border-color: #ffc107;
            /* Bootstrap warning color */
            background-color: #fff3cd;
            /* Light warning background */
            color: #856404;
            /* Text color for warning */
        }

        .form-select-warning:focus {
            border-color: #ffecb5;
            box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
            /* Focus state */
        }
    </style>

    <div class="alert alert-warning d-flex align-items-center" role="alert">
        <div class="row w-100 align-items-center">
            <div class="col-md-8">
                <h5 class="mb-0">
                    Status:
                    <span class="text-muted">
                        {{ $totalRequirements }} total requirements.
                    </span>
                </h5>
            </div>
        </div>
    </div>

    <div class="row mb-3 justify-content-end">
        <div class="col-md-4 d-flex justify-content-end align-items-center gap-4">
            <!-- New Button for Add Requirements Banner -->
            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#addRequirementsBannerModal">
                <i class="fas fa-flag"></i> Add Banner
            </button>

            <!-- Select Dropdown for Status -->
            <form action="{{ route('scholarship.toggleStatus') }}" method="POST" class="d-inline">
                @csrf
                @method('PUT')
                <select name="status" class="form-select form-select-sm form-select-warning"
                    onchange="this.form.submit()">
                    <option value="open" {{ $scholarshipStatus->status === 'open' ? 'selected' : '' }}>Open
                    </option>
                    <option value="closed" {{ $scholarshipStatus->status === 'closed' ? 'selected' : '' }}>Closed
                    </option>
                </select>
            </form>

            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addRequirementModal"
                {{ $scholarshipStatus->status === 'closed' ? 'disabled' : '' }}>
                <i class="fas fa-plus"></i> Add New Requirement
            </button>
        </div>
    </div>

    <!-- Add Banner Modal -->
    <div class="modal fade" id="addRequirementsBannerModal" tabindex="-1" aria-labelledby="addBannerLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bolder" id="addBannerLabel" style="font-size: 20px">
                        Upload Banner
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('banners.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="text-center">
                            <!-- Drag and Drop Area -->
                            <div class="drag-drop-area border border-dashed p-3 rounded"
                                style="background-color: #f9f9f9; cursor: pointer;"
                                onclick="document.getElementById('bannerImageInput').click()">
                                <p class="text-muted mb-2">
                                    Drag and drop an image here, or click to select a file.
                                </p>
                                <i class="fas fa-image fa-2x text-muted"></i>
                            </div>

                            <!-- File Input -->
                            <input type="file" name="banner_image" id="bannerImageInput" accept="image/*"
                                class="d-none" onchange="showPreview(event)" required>
                        </div>

                        <!-- Image Preview -->
                        <div id="imagePreview" class="mt-3 text-center d-none">
                            <img id="previewImg" src="#" alt="Preview" class="img-fluid rounded shadow-sm"
                                style="max-width: 100%; max-height: 300px;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-save"></i> Upload
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Show image preview when a file is selected
        function showPreview(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewImg = document.getElementById('previewImg');
                    const imagePreview = document.getElementById('imagePreview');

                    previewImg.src = e.target.result;
                    imagePreview.classList.remove('d-none');
                };
                reader.readAsDataURL(file);
            }
        }

        // Allow drag-and-drop behavior
        const dragDropArea = document.querySelector('.drag-drop-area');
        dragDropArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            dragDropArea.classList.add('border-primary');
        });

        dragDropArea.addEventListener('dragleave', function() {
            dragDropArea.classList.remove('border-primary');
        });

        dragDropArea.addEventListener('drop', function(e) {
            e.preventDefault();
            dragDropArea.classList.remove('border-primary');
            const fileInput = document.getElementById('bannerImageInput');
            fileInput.files = e.dataTransfer.files;

            // Trigger file preview
            showPreview({
                target: fileInput
            });
        });
    </script>

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
                                data-bs-target="#editRequirement{{ $requirement->id }}"
                                {{ $scholarshipStatus->status === 'closed' ? 'disabled' : '' }}>
                                <i class="fas fa-edit"></i>
                            </button>
                            @include('components.delete-button', [
                                'id' => $requirement->id,
                                'route' => route('requirements.destroy', $requirement->id),
                                'itemName' => $requirement->name,
                                'disabled' => $scholarshipStatus->status === 'closed',
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
                                <form action="{{ route('requirements.update', $requirement->id) }}" method="POST">
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
                                        <button type="button" class="btn btn-secondary btn-sm"
                                            data-bs-dismiss="modal">
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
            document.querySelectorAll('.modal').forEach(modal => {
                modal.addEventListener('hidden.bs.modal', function(event) {
                    if (event.target.id.startsWith('editRequirement') || event.target.id.startsWith(
                            'deleteRequirement')) {
                        location.reload();
                    }
                });
            });
        });
    </script>

    <style>
        .form-select-sm {
            width: 100px;
            /* Compact width for the dropdown */
            font-size: 0.875rem;
            padding: 0.25rem 0.5rem;
            border-radius: 0.2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
    </style>

</x-app-layout>
