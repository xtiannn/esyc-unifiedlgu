<x-app-layout>

    <style>
        body {
            font-family: 'Arial', sans-serif;
        }

        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            padding: 1rem;
            border-radius: 8px;
        }

        .card:hover {
            transform: translateY(-5px) scale(1.03);
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.15);
        }

        .card-body i {
            transition: color 0.3s ease, transform 0.3s ease;
        }

        .card:hover .card-body i {
            transform: rotate(5deg) scale(1.1);
        }

        .border-opacity-50:hover {
            background-color: rgba(0, 123, 255, 0.1);
            transition: background-color 0.3s ease;
        }

        .dashboard-title {
            font-size: 1.3rem;
            font-weight: bold;
            margin-bottom: 1.5rem;
        }

        @media (max-width: 768px) {
            .row {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .col-md-3 {
                width: 90%;
                margin-bottom: 1rem;
            }
        }


        .badge {
            width: 100px;
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 0.8rem;
            font-weight: bold;
            text-align: center;
        }

        .badge-in-progress {
            background-color: orange;
            color: white;
        }

        .badge-resolved {
            background-color: green;
            color: white;
        }

        .badge-open {
            background-color: blue;
            color: white;
        }

        .badge-closed {
            background-color: red;
            color: white;
        }

        @media (max-width: 768px) {
            .row {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .col-md-3 {
                width: 90%;
                margin-bottom: 1rem;
            }
        }

        .modal-body-scroll {
            max-height: 300px;
            overflow-y: auto;
        }
    </style>

    <h1 class="dashboard-title">📊 Welcome, {{ Str::title(Auth::user()->name) }}</h1>

    <div class="row">
        <div class="col-md-3 col-sm-6 mb-4">
            <a href="{{ route('cases.index') }}">
                <div class="card text-center shadow-sm border-primary">
                    <div class="card-body">
                        <i class="fas fa-plus-circle fa-2x text-primary"></i>
                        <h5 class="mt-2">Submit New Case</h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6 mb-4">
            <a href="{{ route('emergency.index') }}">
                <div class="card text-center shadow-sm border-info">
                    <div class="card-body">
                        <i class="fas fa-exclamation-triangle fa-2x text-danger"></i>
                        <h5 class="mt-2">Report Emergency</h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card text-center shadow-sm border-success">
                <a href="{{ route('scholarship') }}">
                    <div class="card-body">
                        <i class="fas fa-graduation-cap fa-2x text-success"></i>
                        <h5 class="mt-2">
                            <h5 class="mt-2">
                                @php
                                    if (Auth::user()->scholarships->scholarship_status === 'not_applied') {
                                        echo 'Apply for Scholarship';
                                    } else {
                                        echo 'Scholarship ' . Auth::user()->scholarships->scholarship_status;
                                    }
                                @endphp
                            </h5>
                        </h5>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card text-center shadow-sm border-warning">
                <a href="{{ route('messages.index') }}">
                    <div class="card-body">
                        <i class="fas fa-comments fa-2x text-info"></i>
                        <h5 class="mt-2">Chat with Bot</h5>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12 col-sm-6">
            <h2 class="dashboard-title">Recently Submitted Cases</h2>
            <div class="table-responsive">
                <table class="table table-custom">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Type</th>
                            <th scope="col">Status</th>
                            <th scope="col">Date Submitted</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($cases as $case)
                            <tr>
                                <td data-label="#">{{ $loop->iteration }}.</td>
                                <td data-label="Title">{{ Str::title($case->case_title) }}</td>
                                <td data-label="Type">{{ Str::title($case->case_type) }}</td>
                                <td>
                                    @php
                                        $statusMap = [
                                            'in_progress' => ['label' => 'In-progress', 'class' => 'badge-in-progress'],
                                            'resolved' => ['label' => 'Resolved', 'class' => 'badge-resolved'],
                                            'open' => ['label' => 'Open', 'class' => 'badge-open'],
                                            'closed' => ['label' => 'Closed', 'class' => 'badge-closed'],
                                        ];
                                    @endphp
                                    <span class="badge {{ $statusMap[$case->status]['class'] ?? '' }}">
                                        {{ $statusMap[$case->status]['label'] ?? $case->status }}
                                    </span>
                                </td>
                                <td data-label="DateCreated">{{ $case->created_at->format('F j, Y g:i A') }}
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
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12 col-sm-6">
            <h2 class="dashboard-title">Emergency Alerts</h2>
            <div class="table-responsive">
                <table class="table table-custom">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Message</th>
                            <th scope="col">Issued Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($alerts as $alert)
                            <tr>
                                <td data-label="#">{{ $loop->iteration }}.</td>
                                <td data-label="Title">{{ Str::title($alert->title) }}</td>
                                <td data-label="Message">
                                    <a href="#" data-bs-toggle="modal"
                                        data-bs-target="#alertModal{{ $alert->id }}">
                                        {{ Str::limit(Str::title($alert->message), 50, '...') }}
                                    </a>
                                </td>
                                <td data-label="DateCreated">{{ $alert->created_at->format('F j, Y g:i A') }}</td>
                            </tr>

                            <div class="modal fade" id="alertModal{{ $alert->id }}" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" style="width: 40%">
                                    <!-- Centered & Small Modal -->
                                    <div class="modal-content shadow-lg border-0">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title fw-bold">{{ $alert->title }}</h5>
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body modal-body-scroll px-5">
                                            <p class="fs-5 text-dark text-justify">{{ $alert->message }}</p>
                                        </div>
                                        <div class="modal-footer d-flex justify-content-center">
                                            <small class="text-muted" style="font-size: 14px;">📅 Issued
                                                at:
                                                {{ $alert->created_at->format('F j, Y g:i A') }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @empty
                            <tr>
                                <td colspan="12" class="text-center">No data found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>







</x-app-layout>
