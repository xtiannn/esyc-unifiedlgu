<x-app-layout>
    @section('title', 'Scholarship Management')

    <div class="row mb-3">
        <div class="col-md-10">
            <h1>Scholarship Applications</h1>
        </div>
    </div>

    <div class="alert alert-info d-flex align-items-center" role="alert">
        <div class="row w-100">
            <div class="col-md-10">
                <h5 class="mb-0">
                    Interview Slots: <span class="text-muted">{{ $availableSlots }}/{{ $totalSlots }} available.</span>
                </h5>
            </div>
            <div class="col-md-2 text-end">
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#updateSlotsModal">
                    <i class="fas fa-edit"></i> Update Slots
                </button>
            </div>
        </div>
    </div>

    <!-- Update Interview Slots Modal -->
    <div class="modal fade" id="updateSlotsModal" tabindex="-1" aria-labelledby="updateSlotsLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fw-bolder" id="updateSlotsLabel" style="font-size: 25px">
                        Update Interview Slots
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('update.slots') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="fw-bold mb-3">Current Slot Information</h5>
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control form-control-sm"
                                        value="{{ $availableSlots }}/{{ $totalSlots }} available" disabled>
                                    <label>Available Slots</label>
                                </div>

                                <h5 class="fw-bold mb-3 mt-3">Update Slots</h5>
                                <div class="form-floating mb-2">
                                    <input type="number" class="form-control form-control-sm" name="total_slots"
                                        value="{{ $totalSlots }}" min="1" required>
                                    <label>New Total Slots</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer mt-2">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-save"></i> Save Changes
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>




    <div class="table-responsive">
        <table class="table datatable table-bordered table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th class="text-center">#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th class="text-center">Contact</th>
                    <th class="text-center">Status</th>
                    <th>Application Date</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($scholarships as $scholarship)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}.</td>
                        <td>{{ Str::title($scholarship->user->name) }}</td>
                        <td>{{ $scholarship->user->email }}</td>
                        <td class="text-center">{{ $scholarship->user->contact_number ?? 'N/A' }}</td>
                        <td class="text-center">
                            @php
                                $statusColors = [
                                    'not_applied' => 'bg-secondary',
                                    'applied' => 'bg-info',
                                    'interview_scheduled' => 'bg-warning',
                                    'approved' => 'bg-success',
                                    'rejected' => 'bg-danger',
                                ];
                            @endphp
                            <span
                                class="badge {{ $statusColors[$scholarship->scholarship_status] ?? 'bg-secondary' }}">
                                {{ Str::title(ucfirst(str_replace('_', ' ', $scholarship->scholarship_status))) }}
                            </span>
                        </td>
                        <td>{{ $scholarship->created_at }}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#viewApplication{{ $scholarship->id }}">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- View Application Modal -->
                    <div class="modal fade" id="viewApplication{{ $scholarship->id }}" tabindex="-1"
                        aria-labelledby="viewApplicationLabel{{ $scholarship->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fw-bolder" id="viewApplicationLabel{{ $scholarship->id }}"
                                        style="font-size: 25px">
                                        Scholarship Application Details
                                    </h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <!-- Applicant Details -->
                                        <div class="col-md-6">
                                            <h5 class="fw-bold mb-3">Applicant Information</h5>
                                            <div class="form-floating mb-2">
                                                <input type="text" class="form-control form-control-sm"
                                                    value="{{ $scholarship->user->name }}" disabled>
                                                <label>Name</label>
                                            </div>
                                            <div class="form-floating mb-2">
                                                <input type="text" class="form-control form-control-sm"
                                                    value="{{ $scholarship->user->email }}" disabled>
                                                <label>Email</label>
                                            </div>
                                            <div class="form-floating mb-2">
                                                <input type="text" class="form-control form-control-sm"
                                                    value="{{ $scholarship->user->contact_number ?? 'N/A' }}" disabled>
                                                <label>Contact</label>
                                            </div>
                                            <div class="form-floating mb-2">
                                                <input type="text" class="form-control form-control-sm"
                                                    value="{{ ucfirst(str_replace('_', ' ', $scholarship->scholarship_status)) }}"
                                                    disabled>
                                                <label>Status</label>
                                            </div>
                                            <div class="form-floating mb-2">
                                                <input type="text" class="form-control form-control-sm"
                                                    value="{{ $scholarship->created_at }}" disabled>
                                                <label>Application Date</label>
                                            </div>
                                        </div>

                                        <!-- Uploaded Documents -->
                                        <div class="col-md-6">
                                            <h5 class="fw-bold mb-3">Uploaded Documents</h5>
                                            @if (!empty($scholarship->document_link))
                                                <ul class="list-group">
                                                    <li class="list-group-item">
                                                        <a href="{{ $scholarship->document_link }}" target="_blank">
                                                            <i class="fas fa-file-alt me-2"></i> View Submitted
                                                            Document
                                                        </a>
                                                    </li>
                                                </ul>
                                            @else
                                                <p class="text-muted">No documents uploaded.</p>
                                            @endif

                                            <!-- Interview Details (only if scheduled) -->
                                            @if ($scholarship->scholarship_status === 'interview_scheduled')
                                                <h5 class="fw-bold mb-3 mt-3">Interview Details</h5>
                                                <div class="form-floating mb-2">
                                                    <input type="text" class="form-control form-control-sm"
                                                        value="{{ \Carbon\Carbon::parse($scholarship->interview_date)->format('F d, Y') }}"
                                                        disabled>
                                                    <label>Interview Date</label>
                                                </div>
                                                <div class="form-floating mb-2">
                                                    <input type="text" class="form-control form-control-sm"
                                                        value="{{ \Carbon\Carbon::parse($scholarship->interview_time)->format('h:i A') }}"
                                                        disabled>
                                                    <label>Interview Time</label>
                                                </div>
                                                <div class="form-floating mb-2">
                                                    <input type="text" class="form-control form-control-sm"
                                                        value="{{ $scholarship->interview_location }}" disabled>
                                                    <label>Interview Location</label>
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer mt-2">
                                    <!-- Show schedule button only if interview is not yet scheduled -->
                                    @if ($scholarship->scholarship_status !== 'interview_scheduled')
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#scheduleInterview{{ $scholarship->id }}">
                                            <i class="fas fa-calendar-alt"></i> Schedule Interview
                                        </button>
                                    @endif

                                    <!-- Reject Button (Trigger Reject Modal) -->
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#rejectApplication{{ $scholarship->id }}">
                                        <i class="fas fa-times"></i> Reject
                                    </button>


                                    <!-- Approve Button -->
                                    <form action="{{ route('scholarship.approve', $scholarship->id) }}"
                                        method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="fas fa-check"></i> Approve
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Schedule Interview Modals (Placed Outside the Loop) -->
                @foreach ($scholarships as $scholarship)
                    <div class="modal fade" id="scheduleInterview{{ $scholarship->id }}" tabindex="-1"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Schedule Interview</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('scholarship.schedule', $scholarship->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="interview_date">Select Interview Date:</label>
                                            <input type="date" name="interview_date" class="form-control"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="interview_time">Select Interview Time:</label>
                                            <input type="time" name="interview_time" class="form-control"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="interview_location">Interview Location:</label>
                                            <input type="text" name="interview_location" class="form-control"
                                                placeholder="Enter location" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach

                @foreach ($scholarships as $scholarship)
                    <div class="modal fade" id="rejectApplication{{ $scholarship->id }}" tabindex="-1"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-danger">Reject Application</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('scholarship.reject', $scholarship->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <label class="fw-bold">Reason for Rejection:</label>
                                        <textarea name="rejection_reason" class="form-control" rows="3" required placeholder="Enter reason..."></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-danger">Reject</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
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
                    if (event.target.id.startsWith('scheduleInterview') || event.target.id
                        .startsWith('rejectApplication')) {
                        location.reload();
                    }
                });
            });
        });
    </script>


</x-app-layout>
