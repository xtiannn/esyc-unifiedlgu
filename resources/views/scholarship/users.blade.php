<x-app-layout>
    <style>
        .banner {
            width: 100%;
            height: 200px;
            /* Adjust height as necessary */
            background-size: cover;
            background-position: center;
        }
    </style>
    @section('title', 'Scholarship')

    <!-- Modal for Open Scholarship -->
    @if ($scholarshipStatus === 'open')
        <div class="modal fade" id="applyScholarship" tabindex="-1" aria-labelledby="applyScholarshipLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Apply for Scholarship</h1>
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
                                    <p class="form-control-plaintext">{{ auth()->user()->mobile ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label for="document_link" class="form-label fw-bold">Document Link:</label>
                                    <input type="url" name="document_link" id="document_link" class="form-control"
                                        required>
                                    <small class="text-muted" style="font-size: 12px">
                                        Only Google Drive links are accepted. Make sure the link is publicly accessible
                                        or
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
    @endif
    @if ($scholarshipStatus === 'closed')
        <!-- Scholarship Closed Modal -->
        <div class="modal fade" id="scholarshipClosed" tabindex="-1" aria-labelledby="scholarshipClosedLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Scholarship Application Closed</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="closeScholarshipModal"></button>
                    </div>
                    <div class="modal-body text-center">
                        <div class="mb-3">
                            <span style="font-size: 50px; color: #ff6b6b;">😞</span>
                        </div>
                        <h5 class="mb-3">We're sorry!</h5>
                        <p class="mb-2">The scholarship application period has ended, and we are no longer accepting
                            applications.</p>
                        <p>Stay tuned for updates on future opportunities!</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            id="showBannerModalBtn">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- New Requirements banner Modal -->
    <div class="modal fade" id="bannerModal" tabindex="-1" aria-labelledby="bannerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="closeModalBtn"></button>
                </div>
                <div class="modal-body text-center">
                    {{-- @if ($banner)
                    <img src="{{ asset('storage/' . $banner->image_path) }}" alt="Banner Image" class="img-fluid" />
                @else
                    <p>No banner available at the moment.</p>
                @endif --}}


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        id="closeModalBtnFooter">Close</button>
                </div>
            </div>
        </div>
    </div>





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
                <p class="fs-6 text-secondary animated fadeInUp delay-1s">
                    Keep an eye on your email for next steps and fund release instructions.
                </p>
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

                <p class="mt-4 fs-5 fw-bold text-dark">Ready to Apply?</p>
                <p class="text-muted fs-5 mb-4">Take the first step towards your scholarship today!</p>

                <div class="d-flex gap-3">
                    <!-- New View Requirements Button -->
                    <button type="button" class="btn btn-info btn-lg px-5 py-3 shadow-sm hover-lift"
                        data-bs-toggle="modal" data-bs-target="#viewRequirements">
                        View Requirements
                    </button>

                    <!-- Show the modal trigger for open applications -->
                    @if ($scholarshipStatus === 'open')
                        <button class="btn btn-primary btn-lg px-5 py-3 shadow-sm hover-lift" data-bs-toggle="modal"
                            data-bs-target="#applyScholarship">Apply Scholarship</button>
                    @endif
                    @if ($scholarshipStatus === 'closed')
                        <button class="btn btn-primary btn-lg px-5 py-3 shadow-sm hover-lift" data-bs-toggle="modal"
                            data-bs-target="#scholarshipClosed">Apply Scholarship</button>
                    @endif
                </div>
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
                                    value="{{ optional($hasApplied)->interview_date ? \Carbon\Carbon::parse($hasApplied->interview_date)->format('F d, Y') : 'TBD' }}"
                                    disabled>
                                <label>Interview Date</label>
                            </div>
                        </div>

                        <!-- Interview Time -->
                        <div class="col-12">
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control form-control-sm"
                                    value="{{ optional($hasApplied)->interview_time ? \Carbon\Carbon::parse($hasApplied->interview_time)->format('h:i A') : 'TBD' }}"
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

    <!-- Requirements Modal -->
    <div class="modal fade" id="viewRequirements" tabindex="-1" aria-labelledby="viewRequirementsLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 fw-bold" id="viewRequirementsLabel">Scholarship Requirements</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Loop through scholarship requirements -->
                        @if ($requirements && count($requirements) > 0)
                            @foreach ($requirements as $requirement)
                                <div class="col-12 mb-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control form-control-sm"
                                            value="{{ $requirement->description }}" disabled>
                                        <label>{{ $requirement->name }}</label>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12">
                                <p class="text-muted">No requirements found.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                        <div class="col-12">
                            <h5 class="fw-bold mb-3">Scholarship Information</h5>
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control form-control-sm"
                                    value="{{ optional(optional($hasApplied)->user)->first_name
                                        ? ucwords(
                                            strtolower(
                                                optional($hasApplied->user)->first_name .
                                                    ' ' .
                                                    optional($hasApplied->user)->middle_name .
                                                    ' ' .
                                                    optional($hasApplied->user)->last_name,
                                            ),
                                        )
                                        : 'N/A' }}"
                                    disabled>
                                <label>Scholarship Name</label>
                            </div>
                        </div>

                        <!-- Award Amount -->
                        <div class="col-12">
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control form-control-sm"
                                    value="{{ optional($hasApplied)->scholarship_amount ? '₱' . number_format(optional($hasApplied)->scholarship_amount, 2) : 'N/A' }}"
                                    disabled>
                                <label>Award Amount</label>
                            </div>
                        </div>

                        <!-- Scholarship Type -->
                        <div class="col-12">
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control form-control-sm"
                                    value="{{ optional($hasApplied)->scholarship_type ? ucfirst(optional($hasApplied)->scholarship_type) : 'N/A' }}"
                                    disabled>
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
                                    value="{{ $hasApplied && $hasApplied->approval_date ? \Carbon\Carbon::parse($hasApplied->approval_date)->format('F d, Y') : 'TBD' }}"
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bannerModal = document.getElementById('bannerModal');
            bannerModal.addEventListener('show.bs.modal', function() {
                fetchBanner();
            });

            function fetchBanner() {
                fetch('{{ route('banner.fetch') }}')
                    .then(response => response.json())
                    .then(data => {
                        const modalBody = bannerModal.querySelector('.modal-body');
                        if (data.image_path) {
                            modalBody.innerHTML = `
                                <img src="{{ asset('storage/') }}/${data.image_path}" class="img-fluid" />

                            `;
                        } else {
                            modalBody.innerHTML = `
                                <p class="text-muted">No banner available at the moment.</p>
                            `;
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching banner:', error);
                        bannerModal.querySelector('.modal-body').innerHTML = `
                            <p class="text-danger">Failed to load the banner. Please try again later.</p>
                        `;
                    });
            }
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Event listener for closing the scholarship closed modal and opening the banner modal
            const closeButton = document.getElementById('closeScholarshipModal');
            const showBannerButton = document.getElementById('showBannerModalBtn');

            if (closeButton) {
                closeButton.addEventListener('click', function() {
                    // Wait for the scholarship modal to close, then open the banner modal
                    $('#scholarshipClosed').on('hidden.bs.modal', function() {
                        $('#bannerModal').modal('show');
                    });
                });
            }

            if (showBannerButton) {
                showBannerButton.addEventListener('click', function() {
                    // Trigger the banner modal to show once the "Close" button is clicked
                    $('#bannerModal').modal('show');
                });
            }
        });
    </script>
</x-app-layout>
