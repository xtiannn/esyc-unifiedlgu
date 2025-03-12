<x-app-layout>
    @section('title', 'Dashboard')

    <style>
        /* Hover Effects for Cards */
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px) scale(1.03);
            /* Slight lift and zoom */
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.15);
            /* Elevated shadow */
        }

        /* Hover Effect for Icons */
        .card-body i {
            transition: color 0.3s ease, transform 0.3s ease;
        }

        .card:hover .card-body i {
            transform: rotate(5deg) scale(1.1);
            /* Slight rotation and scaling */
        }

        /* Hover Effects for Section Headers */
        .border-opacity-50:hover {
            background-color: rgba(0, 123, 255, 0.1);
            /* Light blue background */
            transition: background-color 0.3s ease;
        }
    </style>

    <h1 class="mb-4">📊 Admin Dashboard</h1>

    <!-- Dashboard Cards -->
    <div class="row">
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card text-center shadow-sm border-primary">
                <div class="card-body">
                    <i class="fas fa-users fa-2x text-primary"></i>
                    <h5 class="mt-2">Total Residents</h5>
                    <h3 class="card-title text-primary">{{ $totalResidents }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card text-center shadow-sm border-info">
                <div class="card-body">
                    <i class="fas fa-male fa-2x text-info"></i>
                    <h5 class="mt-2">Male Residents</h5>
                    <h3 class="card-title text-info">{{ $totalMale }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card text-center shadow-sm border-danger">
                <div class="card-body">
                    <i class="fas fa-female fa-2x text-danger"></i>
                    <h5 class="mt-2">Female Residents</h5>
                    <h3 class="card-title text-danger">{{ $totalFemale }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card text-center shadow-sm border-warning">
                <div class="card-body">
                    <i class="fas fa-user fa-2x text-warning"></i>
                    <h5 class="mt-2">Single Residents</h5>
                    <h3 class="card-title text-warning">{{ $totalSingle }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Cases Section -->

    <div class="row">
        <div class="col-md-12">
            <div
                class="d-flex align-items-center justify-content-between border border-primary border-opacity-50 rounded p-2">
                <h3 class="mt-2 mb-2 text-primary">🚨 Cases Overview</h3>
                <a href="{{ route('cases.index') }}" class="text-primary">
                    <i class="fas fa-ellipsis-v fa-lg" style="cursor: pointer;"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card text-center shadow-sm border-dark">
                <div class="card-body">
                    <i class="fas fa-file-alt fa-2x text-dark"></i>
                    <h5 class="mt-2">Total Cases</h5>
                    <h3 class="card-title text-dark">{{ $totalCases }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card text-center shadow-sm border-danger">
                <div class="card-body">
                    <i class="fas fa-exclamation-triangle fa-2x text-danger"></i>
                    <h5 class="mt-2">Open Cases</h5>
                    <h3 class="card-title text-danger">{{ $totalOpenCases }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card text-center shadow-sm border-info">
                <div class="card-body">
                    <i class="fas fa-spinner fa-2x text-info"></i>
                    <h5 class="mt-2">In Progress</h5>
                    <h3 class="card-title text-info">{{ $totalInProgress }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card text-center shadow-sm border-success">
                <div class="card-body">
                    <i class="fas fa-check-circle fa-2x text-success"></i>
                    <h5 class="mt-2">Resolved Cases</h5>
                    <h3 class="card-title text-success">{{ $totalResolved }}</h3>
                </div>
            </div>
        </div>
    </div>


    <!-- 📚 Scholarship Overview -->
    <div class="row">
        <div class="col-md-12">
            <div
                class="d-flex align-items-center justify-content-between border border-primary border-opacity-50 rounded p-2">
                <h3 class="mt-2 mb-2 text-primary">🎓 Scholarship Overview</h3>
                <a href="{{ route('scholarship.admin') }}" class="text-primary">
                    <i class="fas fa-ellipsis-v fa-lg" style="cursor: pointer;"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card text-center shadow-sm border-secondary">
                <div class="card-body">
                    <i class="fas fa-graduation-cap fa-2x text-secondary"></i>
                    <h5 class="mt-2">Total Scholarship Applications</h5>
                    <h3 class="card-title text-secondary">{{ $totalScholarshipApplications }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card text-center shadow-sm border-warning">
                <div class="card-body">
                    <i class="fas fa-hourglass-half fa-2x text-warning"></i>
                    <h5 class="mt-2">Pending Applications</h5>
                    <h3 class="card-title text-warning">{{ $totalPendingScholarships }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card text-center shadow-sm border-success">
                <div class="card-body">
                    <i class="fas fa-check-circle fa-2x text-success"></i>
                    <h5 class="mt-2">Approved Applications</h5>
                    <h3 class="card-title text-success">{{ $totalApprovedScholarships }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card text-center shadow-sm border-danger">
                <div class="card-body">
                    <i class="fas fa-times-circle fa-2x text-danger"></i>
                    <h5 class="mt-2">Rejected Applications</h5>
                    <h3 class="card-title text-danger">{{ $totalRejectedScholarships }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Gender & Scholarship Section -->
    <div class="row mt-4 d-flex align-items-center justify-content-between">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-venus-mars text-primary"></i> Residents by Gender</h5>
                    <canvas id="residentsChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-user-graduate text-success"></i> Scholarship Application
                        Status</h5>
                    <canvas id="scholarshipChart"></canvas>
                </div>
            </div>
        </div>
    </div>


    <!-- FontAwesome Icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Residents Chart
            var residentsCtx = document.getElementById("residentsChart").getContext("2d");

            new Chart(residentsCtx, {
                type: "doughnut",
                data: {
                    labels: ["Male", "Female"],
                    datasets: [{
                        data: [{{ $totalMale }}, {{ $totalFemale }}], // Dynamic Data
                        backgroundColor: ["#007bff", "#dc3545"], // Blue & Red
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: "bottom"
                        }
                    }
                }
            });

            // Scholarship Chart (Including Pending)
            var scholarshipCtx = document.getElementById("scholarshipChart").getContext("2d");

            new Chart(scholarshipCtx, {
                type: "pie",
                data: {
                    labels: ["Approved", "Rejected", "Pending"],
                    datasets: [{
                        data: [{{ $totalApprovedScholarships }}, {{ $totalRejectedScholarships }},
                            {{ $totalPendingScholarships }}
                        ], // Dynamic Data
                        backgroundColor: ["#28a745", "#dc3545", "#ffc107"], // Green, Red & Yellow
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: "bottom"
                        }
                    }
                }
            });
        });
    </script>


</x-app-layout>
