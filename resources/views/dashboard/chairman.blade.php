<x-app-layout>
    @section('title', 'Chairman Dashboard')

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Custom CSS for Elegance -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            transition: transform 0.2s;
        }

        .btn-primary:hover {
            transform: scale(1.05);
        }

        .list-group-item {
            transition: background-color 0.2s;
        }

        .list-group-item:hover {
            background-color: #f1f3f5;
        }

        h1,
        h3,
        h5 {
            font-weight: 600;
            color: #1a3c6d;
        }
    </style>

    <div class="container py-5">
        <!-- Header -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-5">
            <h1 class="display-5 mb-4 mb-md-0"><i class="fas fa-tachometer-alt me-2"></i> Chairman Dashboard</h1>
            <div class="d-flex gap-3">
                <a href="{{ route('emergency.store') }}" class="btn btn-primary">
                    <i class="fas fa-bullhorn me-2"></i> Send Emergency Alert
                </a>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#reportModal">
                    <i class="fas fa-file-pdf me-2"></i> Generate Report
                </button>
            </div>
        </div>

        <!-- Report Modal -->
        <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reportModalLabel">Generate Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('chairman.reports') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" id="start_date" name="start_date" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" id="end_date" name="end_date" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="report_type" class="form-label">Report Type</label>
                                <select id="report_type" name="report_type" class="form-select">
                                    <option value="all">All Data</option>
                                    <option value="residents">Residents</option>
                                    <option value="cases">Cases</option>
                                    <option value="scholarships">Scholarships</option>
                                    <option value="emergencies">Emergencies</option>
                                    <option value="incidents">Incidents</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Download Report</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Key Metrics -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 mb-5">
            <div class="col">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-users fa-2x text-primary me-3"></i>
                        <div>
                            <h5 class="card-title mb-1">Total Residents</h5>
                            <p class="card-text display-6 fw-bold text-primary">{{ $totalResidents }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle fa-2x text-danger me-3"></i>
                        <div>
                            <h5 class="card-title mb-1">Open Cases</h5>
                            <p class="card-text display-6 fw-bold text-danger">{{ $openCases }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-graduation-cap fa-2x text-success me-3"></i>
                        <div>
                            <h5 class="card-title mb-1">Approved Scholarships</h5>
                            <p class="card-text display-6 fw-bold text-success">{{ $approvedScholarships }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-exclamation-circle fa-2x text-warning me-3"></i>
                        <div>
                            <h5 class="card-title mb-1">Pending Incidents</h5>
                            <p class="card-text display-6 fw-bold text-warning">{{ $pendingIncidents }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Emergency Alerts -->
        <div class="mb-5">
            <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded mb-3">
                <h3 class="mb-0"><i class="fas fa-bullhorn me-2"></i> Recent Emergency Alerts</h3>
                <a href="{{ route('emergency.index') }}" class="text-primary"><i class="fas fa-list fa-lg"></i></a>
            </div>
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    @if ($recentEmergencies->isEmpty())
                        <p class="text-muted">No recent emergency alerts.</p>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach ($recentEmergencies as $emergency)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1 fw-bold">{{ $emergency->title }}</h6>
                                        <p class="mb-1 text-muted">{{ $emergency->message }}</p>
                                        <small class="text-muted">
                                            By {{ $emergency->creator->name ?? 'Unknown' }} on
                                            {{ $emergency->created_at->format('M d, Y H:i') }}
                                            @if ($emergency->case)
                                                | Linked to Case: <a
                                                    href="{{ route('cases.show', $emergency->case) }}"
                                                    class="text-primary text-decoration-underline">{{ $emergency->case->case_title }}</a>
                                            @endif
                                        </small>
                                    </div>
                                    <a href="{{ route('emergency.show', $emergency) }}" class="text-primary"><i
                                            class="fas fa-eye"></i></a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>

        <!-- Announcements -->
        <div class="mb-5">
            <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded mb-3">
                <h3 class="mb-0"><i class="fas fa-bullhorn me-2"></i> Recent Announcements</h3>
                <a href="{{ route('announcements.index') }}" class="text-primary"><i
                        class="fas fa-list fa-lg"></i></a>
            </div>
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    @if ($recentAnnouncements->isEmpty())
                        <p class="text-muted">No recent announcements.</p>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach ($recentAnnouncements as $announcement)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1 fw-bold">{{ $announcement->title }}</h6>
                                        <p class="mb-1 text-muted">{{ $announcement->message }}</p>
                                        <small
                                            class="text-muted">{{ $announcement->created_at->format('M d, Y H:i') }}</small>
                                    </div>
                                    <a href="{{ route('announcements.edit', $announcement) }}"
                                        class="text-primary"><i class="fas fa-edit"></i></a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="row row-cols-1 row-cols-lg-2 g-4 mb-5">
            <div class="col">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-venus-mars me-2"></i> Residents by Gender</h5>
                        <canvas id="residentsChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-file-alt me-2"></i> Cases by Type</h5>
                        <canvas id="casesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS and Chart.js Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Residents Chart
                const residentsCtx = document.getElementById("residentsChart").getContext("2d");
                new Chart(residentsCtx, {
                    type: "doughnut",
                    data: {
                        labels: ["Male", "Female"],
                        datasets: [{
                            data: [{{ $totalMale }}, {{ $totalFemale }}],
                            backgroundColor: ["#007bff", "#dc3545"],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: "bottom"
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let label = context.label || '';
                                        let value = context.raw || 0;
                                        let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        let percentage = ((value / total) * 100).toFixed(1);
                                        return `${label}: ${value} (${percentage}%)`;
                                    }
                                }
                            }
                        }
                    }
                });

                // Cases Chart
                const casesCtx = document.getElementById("casesChart").getContext("2d");
                new Chart(casesCtx, {
                    type: "bar",
                    data: {
                        labels: [
                            @foreach ($caseTypes as $type)
                                "{{ $type->case_type }}",
                            @endforeach
                        ],
                        datasets: [{
                            label: "Cases by Type",
                            data: [
                                @foreach ($caseTypes as $type)
                                    {{ $type->count }},
                                @endforeach
                            ],
                            backgroundColor: ["#007bff", "#dc3545", "#ffc107", "#28a745"],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return `${context.label}: ${context.raw} cases`;
                                    }
                                }
                            }
                        }
                    }
                });
            });
        </script>
    </div>
</x-app-layout>
