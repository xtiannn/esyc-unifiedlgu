<x-app-layout>
    @section('title', 'Scholarship')

    <div class="d-flex flex-column justify-content-center align-items-center min-vh-100 text-center">
        @if ($hasApplied && $hasApplied->scholarship_status === 'applied')
            <div
                class="d-flex flex-column justify-content-center align-items-center min-vh-100 text-center animated fadeIn">
                <div class="rounded-circle bg-success bg-opacity-10 d-flex justify-content-center align-items-center shadow position-relative"
                    style="width: 200px; height: 200px;">
                    <div class="position-absolute rounded-circle bg-success bg-opacity-25 animated pulse infinite d-flex justify-content-center align-items-center"
                        style="width: 100%; height: 100%;">
                        <svg width="50%" height="50%" viewBox="0 0 24 24" fill="none" stroke="green"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 6L9 17l-5-5" />
                        </svg>
                    </div>
                </div>
                <p class="mt-4 fs-5 fw-bold text-success animated fadeInUp delay-1s">
                    Application Received!
                </p>
                <p class="text-muted fs-5 animated fadeInUp delay-1s">
                    Your application is under review.
                </p>
            </div>
        @elseif ($hasApplied && $hasApplied->scholarship_status === 'interview_scheduled')
            <div class="d-flex flex-column justify-content-center align-items-center animated fadeIn">
                <div class="rounded-circle bg-warning bg-opacity-10 d-flex justify-content-center align-items-center shadow overflow-hidden"
                    style="width: 200px; height: 200px;">
                    <div class="rounded-circle bg-warning bg-opacity-25 animated pulse infinite d-flex justify-content-center align-items-center"
                        style="width: 100%; height: 100%;">
                        <svg width="50%" height="50%" viewBox="0 0 24 24" fill="none" stroke="white"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="16" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                    </div>
                </div>

                <p class="mt-4 fs-5 fw-bold text-primary animated fadeInUp delay-1s">
                    Interview Scheduled!
                </p>
                <p class="text-muted fs-5 animated fadeInUp delay-1s">
                    Your interview is scheduled. Click below for details.
                </p>
                <button class="btn btn-primary mt-3 animated fadeInUp delay-1s" data-bs-toggle="modal"
                    data-bs-target="#interviewDetails">
                    View Interview Details
                </button>
            </div>
        @elseif ($hasApplied && $hasApplied->scholarship_status === 'approved')
            <div class="d-flex flex-column justify-content-center align-items-center animated fadeIn">
                <div class="rounded-circle bg-success bg-opacity-10 d-flex justify-content-center align-items-center shadow overflow-hidden"
                    style="width: 200px; height: 200px;">
                    <div class="rounded-circle bg-success bg-opacity-25 animated pulse infinite d-flex justify-content-center align-items-center"
                        style="width: 100%; height: 100%;">
                        <svg width="50%" height="50%" viewBox="0 0 24 24" fill="none" stroke="green"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 6L9 17l-5-5"></path>
                        </svg>
                    </div>
                </div>
                <p class="mt-4 fs-5 fw-bold text-success animated fadeInUp delay-1s">
                    Scholarship Approved!
                </p>
                <p class="text-muted fs-5 animated fadeInUp delay-1s">
                    Congratulations! You have been awarded the scholarship.
                </p>
                <button class="btn btn-success btn-lg px-5 py-3 shadow-sm hover-lift mt-3" data-bs-toggle="modal"
                    data-bs-target="#scholarshipDetails">
                    View Scholarship Details
                </button>
            </div>
        @elseif ($hasApplied && $hasApplied->scholarship_status === 'rejected')
            <div class="d-flex flex-column justify-content-center align-items-center animated fadeIn">
                <div class="rounded-circle bg-danger bg-opacity-10 d-flex justify-content-center align-items-center shadow overflow-hidden"
                    style="width: 200px; height: 200px;">
                    <div class="rounded-circle bg-danger bg-opacity-25 animated pulse infinite d-flex justify-content-center align-items-center"
                        style="width: 100%; height: 100%;">
                        <svg width="50%" height="50%" viewBox="0 0 24 24" fill="none" stroke="white"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 6L6 18"></path>
                            <path d="M6 6l12 12"></path>
                        </svg>
                    </div>
                </div>

                <p class="mt-4 fs-5 fw-bold text-danger animated fadeInUp delay-1s">
                    Application Rejected!
                </p>
                <p class="text-muted fs-5 animated fadeInUp delay-1s">
                    Unfortunately, your application was not approved. You may reapply.
                </p>

                <!-- Show the rejection reason -->
                @if ($hasApplied->rejection_reason)
                    <p class="text-danger fw-bold animated fadeInUp delay-1s">
                        Reason: {{ $hasApplied->rejection_reason }}
                    </p>
                @endif

                <button class="btn btn-primary btn-lg px-5 py-3 shadow-sm hover-lift mt-3" data-bs-toggle="modal"
                    data-bs-target="#applyScholarship">
                    Reapply Now
                </button>
            </div>
        @else
            <div class="animated fadeIn d-flex flex-column align-items-center text-center">
                <div class="rounded-circle bg-primary bg-opacity-10 d-flex justify-content-center align-items-center shadow"
                    style="width: 200px; height: 200px;">
                    <div class="rounded-circle bg-primary bg-opacity-25 animated pulse infinite d-flex justify-content-center align-items-center"
                        style="width: 100%; height: 100%;">
                        <svg width="50%" height="50%" viewBox="0 0 24 24" fill="none" stroke="white"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M8 2H16L20 6V20C20 21.1 19.1 22 18 22H6C4.9 22 4 21.1 4 20V4C4 2.9 4.9 2 6 2Z">
                            </path>
                            <polyline points="14 10 10 14 8 12"></polyline>
                        </svg>
                    </div>
                </div>

                <p class="mt-4 fs-5 fw-bold text-dark">
                    Ready to Apply?
                </p>
                <p class="text-muted fs-5 mb-4">Take the first step towards your scholarship today!</p>

                <button class="btn btn-primary btn-lg px-5 py-3 shadow-sm hover-lift" data-bs-toggle="modal"
                    data-bs-target="#applyScholarship">
                    Apply Now
                </button>
            </div>
        @endif
    </div>



    <!-- Interview Details Modal -->
    <div class="modal fade" id="interviewDetails" tabindex="-1" aria-labelledby="interviewDetailsLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 fw-bold"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Interview Date -->
                        <div class="col-12">
                            <h5 class="fw-bold mb-3">Interview Details</h5>
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control form-control-sm"
                                    value="{{ \Carbon\Carbon::parse($hasApplied->interview_date)->format('F d, Y') ?? 'TBD' }}"
                                    disabled>
                                <label>Interview Date</label>
                            </div>
                        </div>

                        <!-- Interview Time -->
                        <div class="col-12">
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control form-control-sm"
                                    value="{{ \Carbon\Carbon::parse($hasApplied->interview_time)->format('h:i A') ?? 'TBD' }}"
                                    disabled>
                                <label>Interview Time</label>
                            </div>
                        </div>

                        <!-- Interview Location -->
                        <div class="col-12">
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control form-control-sm"
                                    value="{{ $hasApplied->interview_location ?? 'TBD' }}" disabled>
                                <label>Interview Location</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>




    <div class="modal fade" id="applyScholarship" tabindex="-1" aria-labelledby="applyScholarship"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 class="mb-3">Apply for Scholarship</h5>
                    <form method="POST" action="{{ route('scholarship.apply') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Name:</label>
                                <p class="form-control-plaintext">{{ auth()->user()->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Email:</label>
                                <p class="form-control-plaintext">{{ auth()->user()->email }}</p>
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Contact Number:</label>
                                <p class="form-control-plaintext">{{ auth()->user()->contact_number ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                <label for="document_link" class="form-label fw-bold">Document Link:</label>
                                <input type="url" name="document_link" id="document_link" class="form-control"
                                    required>
                                <small class="text-muted">
                                    * Only Google Drive links are accepted. Make sure the link is publicly accessible or
                                    set to "Anyone with the link can view."
                                </small>
                            </div>
                        </div>

                        <div class="modal-footer mt-3">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit Application</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>



    <!-- Scholarship Details Modal -->
    <div class="modal fade" id="scholarshipDetails" tabindex="-1" aria-labelledby="scholarshipDetailsLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 fw-bold"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Scholarship Name -->
                        <div class="col-12">
                            <h5 class="fw-bold mb-3">Scholarship Information</h5>
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control form-control-sm"
                                    value="{{ $hasApplied->scholarship_name ?? 'N/A' }}" disabled>
                                <label>Scholarship Name</label>
                            </div>
                        </div>

                        <!-- Award Amount -->
                        <div class="col-12">
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control form-control-sm"
                                    value="{{ $hasApplied->scholarship_amount ? '₱' . number_format($hasApplied->scholarship_amount, 2) : 'N/A' }}"
                                    disabled>
                                <label>Award Amount</label>
                            </div>
                        </div>

                        <!-- Scholarship Type -->
                        <div class="col-12">
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control form-control-sm"
                                    value="{{ ucfirst($hasApplied->scholarship_type) ?? 'N/A' }}" disabled>
                                <label>Scholarship Type</label>
                            </div>
                        </div>

                        <!-- Disbursement Method -->
                        <div class="col-12">
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control form-control-sm"
                                    value="{{ $hasApplied->disbursement_method ?? 'N/A' }}" disabled>
                                <label>Disbursement Method</label>
                            </div>
                        </div>

                        <!-- Approval Date -->
                        <div class="col-12">
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control form-control-sm"
                                    value="{{ \Carbon\Carbon::parse($hasApplied->approval_date)->format('F d, Y') ?? 'TBD' }}"
                                    disabled>
                                <label>Approval Date</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>
