<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --success: #10b981;
            --success-dark: #0f766e;
            --primary-light: #dbeafe;
            --warning: #f59e0b;
            --danger: #ef4444;
            --secondary: #6b7280;
            --dark: #1f2937;
            --light: #f3f4f6;
            --white: #ffffff;
            --gray-100: #f9fafb;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--gray-100);
            color: var(--dark);
            margin: 0;
            padding: 0;
            line-height: 1.5;
        }

        a {
            text-decoration: none;
            color: var(--primary);
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 1.5rem;
        }

        .page-header {
            display: flex;
            flex-direction: column;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--gray-200);
            gap: 1rem;
        }

        @media (min-width: 768px) {
            .page-header {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
            }
        }

        .page-title {
            display: flex;
            align-items: center;
            font-size: 1.875rem;
            font-weight: 700;
            color: var(--primary);
            margin: 0;
        }

        .page-title i {
            margin-right: 0.5rem;
            opacity: 0.8;
        }

        .action-buttons {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            border: none;
            outline: none;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            transition: background-color 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn:focus {
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.3);
        }

        .btn i {
            margin-right: 0.5rem;
        }

        .btn-primary {
            background-color: var(--primary);
            color: var(--white);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: scale(1.05);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-success {
            background-color: var(--success);
            color: var(--white);
        }

        .btn-success:hover {
            background-color: var(--success-dark);
            transform: scale(1.05);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .grid {
            display: grid;
            gap: 1rem;
        }

        .grid-2,
        .grid-3,
        .grid-4,
        .grid-5 {
            grid-template-columns: 1fr;
        }

        @media (min-width: 640px) {

            .grid-2,
            .grid-4 {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 768px) {

            .grid-3,
            .grid-4,
            .grid-5 {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .grid-4 {
                grid-template-columns: repeat(4, 1fr);
            }

            .grid-5 {
                grid-template-columns: repeat(5, 1fr);
            }
        }

        .card {
            background-color: var(--white);
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .stats-card {
            padding: 1.25rem;
            display: flex;
            align-items: center;
        }

        .icon-wrapper {
            height: 3rem;
            width: 3rem;
            border-radius: 0.375rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            flex-shrink: 0;
        }

        .icon-wrapper i {
            font-size: 1.25rem;
        }

        .stats-content {
            flex-grow: 1;
        }

        .stats-label {
            font-size: 0.875rem;
            color: var(--secondary);
            margin: 0 0 0.25rem 0;
        }

        .stats-value {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
            color: var(--dark);
        }

        .section {
            margin-bottom: 2rem;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding: 0.75rem 1rem;
            background-color: var(--light);
            border-radius: 0.375rem;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--primary);
            margin: 0;
            display: flex;
            align-items: center;
        }

        .section-title i {
            margin-right: 0.5rem;
        }

        .section-link {
            color: var(--primary);
            display: flex;
            align-items: center;
        }

        .section-link:hover {
            color: var(--primary-dark);
        }

        .card-body {
            padding: 1.25rem;
        }

        .list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        .list-item {
            padding: 1rem 0;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .list-item:last-child {
            border-bottom: none;
        }

        .list-item-content {
            margin-bottom: 0.5rem;
        }

        .list-item-title {
            font-size: 1rem;
            font-weight: 600;
            margin: 0 0 0.25rem 0;
            color: var(--dark);
        }

        .list-item-text {
            font-size: 0.875rem;
            color: var(--secondary);
            margin: 0 0 0.5rem 0;
        }

        .list-item-meta {
            font-size: 0.75rem;
            color: var(--secondary);
            margin: 0;
        }

        .chart-container {
            height: 300px;
            position: relative;
        }

        .form-popup {
            display: none;
            margin-bottom: 1.5rem;
        }

        .form-popup.active {
            display: block;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: var(--dark);
        }

        .form-control {
            width: 100%;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            border: 1px solid var(--gray-300);
            border-radius: 0.375rem;
            transition: border-color 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .filter-bar {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
            flex-wrap: nowrap;
            background-color: var(--white);
            padding: 0.75rem;
            border-radius: 0.375rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .search-input {
            flex: 1;
            min-width: 200px;
        }

        .filter-bar select {
            width: 150px;
        }

        @media (max-width: 640px) {
            .filter-bar {
                flex-direction: column;
                flex-wrap: wrap;
            }

            .search-input,
            .filter-bar select {
                width: 100%;
            }
        }

        .loading {
            opacity: 0.5;
            pointer-events: none;
        }

        .error-message {
            color: var(--danger);
            font-size: 0.875rem;
            margin: 0.5rem 0;
        }

        .card-img {
            border-radius: 0.5rem;
            object-fit: cover;
        }
    </style>

    <div class="container">
        <!-- Header -->
        <header class="page-header" aria-labelledby="dashboard-title">
            <h1 class="page-title" id="dashboard-title">
                <i class="fas fa-tachometer-alt"></i> Admin Dashboard
            </h1>
            <div class="action-buttons">
                <a href="{{ route('emergency.store') }}" class="btn btn-primary" aria-label="Send Emergency Alert">
                    <i class="fas fa-bullhorn"></i> Send Emergency Alert
                </a>
                <button id="report-btn" class="btn btn-success" aria-label="Generate Report">
                    <i class="fas fa-file-pdf"></i> Generate Report
                </button>
            </div>
        </header>

        <!-- Report Form -->
        <div id="report-form" class="form-popup" role="dialog" aria-labelledby="report-form-title">
            <div class="card">
                <div class="card-body">
                    <h3 class="section-title" id="report-form-title">
                        <i class="fas fa-file-alt"></i> Generate Report
                    </h3>
                    <form action="{{ route('chairman.reports') }}" method="POST" aria-describedby="report-form-desc">
                        @csrf
                        <p id="report-form-desc" class="list-item-text">Select a date range to generate a detailed
                            report.</p>
                        @if ($errors->any())
                            <div class="error-message">
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif
                        <div class="grid grid-2">
                            <div class="form-group">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" id="start_date" name="start_date" class="form-control" required
                                    value="{{ old('start_date') }}" aria-required="true">
                            </div>
                            <div class="form-group">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" id="end_date" name="end_date" class="form-control" required
                                    value="{{ old('end_date') }}" aria-required="true">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Download Report</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Filter Bar -->
        {{-- <div class="filter-bar" role="search" aria-label="Dashboard Filters">
            <input type="text" id="search-input" class="form-control search-input"
                placeholder="Search announcements or logs..." aria-label="Search">
            <select id="date-filter" class="form-control" aria-label="Filter by Date Range">
                <option value="all">All Time</option>
                <option value="week">Last Week</option>
                <option value="month">Last Month</option>
                <option value="year">Last Year</option>
            </select>
            <select id="sort-filter" class="form-control" aria-label="Sort By">
                <option value="date-desc">Date (Newest)</option>
                <option value="date-asc">Date (Oldest)</option>
                <option value="title-asc">Title (A-Z)</option>
                <option value="title-desc">Title (Z-A)</option>
            </select>
        </div> --}}

        <!-- Residents Stats -->
        <section class="section" aria-labelledby="residents-stats-title">
            <div class="grid grid-4">
                @foreach ([['icon' => 'fa-users', 'label' => 'Total Residents', 'value' => $totalResidents ?? 0, 'color' => 'primary', 'bg' => '#dbeafe'], ['icon' => 'fa-male', 'label' => 'Male Residents', 'value' => $totalMale ?? 0, 'color' => '#3b82f6', 'bg' => '#dbeafe'], ['icon' => 'fa-female', 'label' => 'Female Residents', 'value' => $totalFemale ?? 0, 'color' => 'danger', 'bg' => '#fee2e2'], ['icon' => 'fa-briefcase', 'label' => 'Working Residents', 'value' => $workingResidents ?? 0, 'color' => 'warning', 'bg' => '#fef3c7']] as $stat)
                    <div class="card stats-card"
                        aria-labelledby="stat-{{ \Illuminate\Support\Str::slug($stat['label']) }}">
                        <div class="icon-wrapper"
                            style="background-color: {{ $stat['bg'] }}; color: {{ $stat['color'] == 'primary' ? '#2563eb' : $stat['color'] }};">
                            <i class="fas {{ $stat['icon'] }}"></i>
                        </div>
                        <div class="stats-content">
                            <h4 class="stats-label" id="stat-{{ \Illuminate\Support\Str::slug($stat['label']) }}">
                                {{ $stat['label'] }}</h4>
                            <p class="stats-value"
                                style="color: {{ $stat['color'] == 'primary' ? '#2563eb' : $stat['color'] }};">
                                {{ $stat['value'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>



        <div class="card">
            <div class="card-body">
                <img src="{{ asset('assets/images/banner.png') }}" alt="Banner Image" class="card-img"
                    style="width: 100%; height: auto;">
            </div>
        </div>



        <!-- Emergency Alerts -->
        <section class="section" aria-labelledby="emergency-alerts-title">
            <div class="section-header">
                <h2 class="section-title" id="emergency-alerts-title">
                    <i class="fas fa-exclamation-triangle"></i> Emergency Alerts
                </h2>
                <a href="{{ route('emergency.index') }}" class="section-link" aria-label="View All Emergency Alerts">
                    <i class="fas fa-list"></i>
                </a>
            </div>
            <div class="card">
                <div class="card-body">
                    @if ($recentEmergencies->isEmpty())
                        <p class="error-message">No recent emergency alerts available.</p>
                    @else
                        <ul class="list" id="emergency-list" role="list">
                            @foreach ($recentEmergencies as $emergency)
                                <li class="list-item" data-title="{{ $emergency->title ?? 'Untitled' }}"
                                    data-date="{{ $emergency->created_at ?? now() }}" role="listitem">
                                    <div class="list-item-content">
                                        <h3 class="list-item-title">{{ $emergency->title ?? 'Untitled' }}</h3>
                                        <p class="list-item-text">
                                            {{ $emergency->message ?? 'No message provided.' }}</p>
                                        <p class="list-item-meta">
                                            By {{ $emergency->creator->name ?? 'Unknown' }} on
                                            {{ $emergency->created_at ? $emergency->created_at->format('M d, Y H:i') : 'Unknown date' }}
                                            @if ($emergency->case)
                                                | Linked to Case: <a href="{{ route('cases.show', $emergency->case) }}"
                                                    style="color: var(--primary); text-decoration: none;"
                                                    aria-label="View Case {{ $emergency->case->case_title ?? 'Untitled Case' }}">
                                                    {{ $emergency->case->case_title ?? 'Untitled Case' }}
                                                </a>
                                            @endif
                                        </p>
                                    </div>
                                    <a href="{{ route('emergency.show', $emergency) }}" class="section-link"
                                        aria-label="View Emergency Alert">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </section>

        <!-- Incidents -->
        <section class="section" aria-labelledby="incidents-title">
            <div class="section-header">
                <h2 class="section-title" id="incidents-title">
                    <i class="fas fa-exclamation-circle"></i> Incident Logs
                </h2>
                <a href="{{ route('incident.index') }}" class="section-link" aria-label="View All Incident Logs">
                    <i class="fas fa-list"></i>
                </a>
            </div>
            <div class="grid grid-3">
                @foreach ([['icon' => 'fa-exclamation-circle', 'label' => 'Total Incidents', 'value' => $totalIncidents ?? 0, 'color' => '#6b7280', 'bg' => '#e5e7eb'], ['icon' => 'fa-hourglass-half', 'label' => 'Pending Incidents', 'value' => $pendingIncidents ?? 0, 'color' => '#f59e0b', 'bg' => '#fef3c7'], ['icon' => 'fa-check-circle', 'label' => 'Resolved Incidents', 'value' => $resolvedIncidents ?? 0, 'color' => '#10b981', 'bg' => '#d1fae5']] as $incident)
                    <div class="card stats-card"
                        aria-labelledby="incident-{{ \Illuminate\Support\Str::slug($incident['label']) }}">
                        <div class="icon-wrapper"
                            style="background-color: {{ $incident['bg'] }}; color: {{ $incident['color'] }};">
                            <i class="fas {{ $incident['icon'] }}"></i>
                        </div>
                        <div class="stats-content">
                            <h4 class="stats-label"
                                id="incident-{{ \Illuminate\Support\Str::slug($incident['label']) }}">
                                {{ $incident['label'] }}</h4>
                            <p class="stats-value" style="color: {{ $incident['color'] }};">{{ $incident['value'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Cases -->
        <section class="section" aria-labelledby="cases-title">
            <div class="section-header">
                <h2 class="section-title" id="cases-title">
                    <i class="fas fa-file-alt"></i> Cases Overview
                </h2>
                <a href="{{ route('cases.index') }}" class="section-link" aria-label="View All Cases">
                    <i class="fas fa-list"></i>
                </a>
            </div>
            <div class="grid grid-4">
                @foreach ([['icon' => 'fa-file-alt', 'label' => 'Total Cases', 'value' => $totalCases ?? 0, 'color' => '#6b7280', 'bg' => '#e5e7eb'], ['icon' => 'fa-exclamation-triangle', 'label' => 'Open Cases', 'value' => $totalOpenCases ?? 0, 'color' => '#ef4444', 'bg' => '#fee2e2'], ['icon' => 'fa-spinner', 'label' => 'In Progress', 'value' => $totalInProgress ?? 0, 'color' => '#3b82f6', 'bg' => '#dbeafe'], ['icon' => 'fa-check-circle', 'label' => 'Resolved Cases', 'value' => $totalResolved ?? 0, 'color' => '#10b981', 'bg' => '#d1fae5']] as $case)
                    <div class="card stats-card"
                        aria-labelledby="case-{{ \Illuminate\Support\Str::slug($case['label']) }}">
                        <div class="icon-wrapper"
                            style="background-color: {{ $case['bg'] }}; color: {{ $case['color'] }};">
                            <i class="fas {{ $case['icon'] }}"></i>
                        </div>
                        <div class="stats-content">
                            <h4 class="stats-label" id="case-{{ \Illuminate\Support\Str::slug($case['label']) }}">
                                {{ $case['label'] }}</h4>
                            <p class="stats-value" style="color: {{ $case['color'] }};">{{ $case['value'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Scholarships -->
        <section class="section" aria-labelledby="scholarships-title">
            <div class="section-header">
                <h2 class="section-title" id="scholarships-title">
                    <i class="fas fa-graduation-cap"></i> Scholarships
                </h2>
                <a href="{{ route('scholarship.admin') }}" class="section-link" aria-label="View All Scholarships">
                    <i class="fas fa-list"></i>
                </a>
            </div>
            <div class="grid grid-5">
                @foreach ([['icon' => 'fa-graduation-cap', 'label' => 'Total Applications', 'value' => $totalScholarshipApplications ?? 0, 'color' => '#6b7280', 'bg' => '#e5e7eb'], ['icon' => 'fa-hourglass-half', 'label' => 'Pending', 'value' => $totalPendingScholarships ?? 0, 'color' => '#f59e0b', 'bg' => '#fef3c7'], ['icon' => 'fa-calendar-check', 'label' => 'Interview Scheduled', 'value' => $totalInterviewScheduled ?? 0, 'color' => '#3b82f6', 'bg' => '#dbeafe'], ['icon' => 'fa-check-circle', 'label' => 'Approved', 'value' => $totalApprovedScholarships ?? 0, 'color' => '#10b981', 'bg' => '#d1fae5'], ['icon' => 'fa-times-circle', 'label' => 'Rejected', 'value' => $totalRejectedScholarships ?? 0, 'color' => '#ef4444', 'bg' => '#fee2e2']] as $scholarship)
                    <div class="card stats-card"
                        aria-labelledby="scholarship-{{ \Illuminate\Support\Str::slug($scholarship['label']) }}">
                        <div class="icon-wrapper"
                            style="background-color: {{ $scholarship['bg'] }}; color: {{ $scholarship['color'] }};">
                            <i class="fas {{ $scholarship['icon'] }}"></i>
                        </div>
                        <div class="stats-content">
                            <h4 class="stats-label"
                                id="scholarship-{{ \Illuminate\Support\Str::slug($scholarship['label']) }}">
                                {{ $scholarship['label'] }}</h4>
                            <p class="stats-value" style="color: {{ $scholarship['color'] }};">
                                {{ $scholarship['value'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Announcements -->
        <section class="section" aria-labelledby="announcements-title">
            <div class="section-header">
                <h2 class="section-title" id="announcements-title">
                    <i class="fas fa-bullhorn"></i> Announcements
                </h2>
                <a href="{{ route('announcements.index') }}" class="section-link"
                    aria-label="View All Announcements">
                    <i class="fas fa-list"></i>
                </a>
            </div>
            <div class="card">
                <div class="card-body">
                    @if ($recentAnnouncements->isEmpty())
                        <p class="error-message">No recent announcements available.</p>
                    @else
                        <ul class="list" id="announcement-list" role="list">
                            @foreach ($recentAnnouncements as $announcement)
                                <li class="list-item" data-title="{{ $announcement->title ?? 'Untitled' }}"
                                    data-date="{{ $announcement->created_at ?? now() }}" role="listitem">
                                    <div class="list-item-content">
                                        <h3 class="list-item-title">{{ $announcement->title ?? 'Untitled' }}</h3>
                                        <p class="list-item-text">
                                            {{ $announcement->message ?? 'No message provided.' }}</p>
                                        <p class="list-item-meta">
                                            {{ $announcement->created_at ? $announcement->created_at->format('M d, Y H:i') : 'Unknown date' }}
                                        </p>
                                    </div>
                                    <a href="{{ route('announcements.edit', $announcement) }}" class="section-link"
                                        aria-label="Edit Announcement">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </section>

        <!-- Charts -->
        <section class="section" aria-labelledby="charts-title">
            <div class="grid" style="grid-template-columns: 1fr 1fr;">
                <div class="card">
                    <div class="card-body">
                        <h3 class="section-title">
                            <i class="fas fa-venus-mars"></i> Residents by Gender
                        </h3>
                        <div class="chart-container">
                            @if ($totalMale + $totalFemale == 0)
                                <p class="error-message text-center">No resident data available.</p>
                            @else
                                <canvas id="residentsChart" aria-label="Residents by Gender Chart"></canvas>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h3 class="section-title">
                            <i class="fas fa-file-alt"></i> Cases by Type
                        </h3>
                        <div class="chart-container">
                            @if ($caseTypes->isEmpty())
                                <p class="error-message text-center">No case data available.</p>
                            @else
                                <canvas id="casesChart" aria-label="Cases by Type Chart"></canvas>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Recent Audit Logs -->
        <section class="section" aria-labelledby="audit-logs-title">
            <div class="section-header">
                <h2 class="section-title" id="audit-logs-title">
                    <i class="fas fa-list-alt"></i> Recent Audit Logs
                </h2>
                <a href="{{ route('auditLog.index') }}" class="section-link" aria-label="View All Audit Logs">
                    <i class="fas fa-list"></i>
                </a>
            </div>
            <div class="card">
                <div class="card-body">
                    @if ($recentAuditLogs->isEmpty())
                        <p class="error-message">No recent audit logs available.</p>
                    @else
                        <ul class="list" id="audit-log-list" role="list">
                            @foreach ($recentAuditLogs as $log)
                                <li class="list-item" data-title="{{ $log->action ?? 'Unknown Action' }}"
                                    data-date="{{ $log->created_at ?? now() }}" role="listitem">
                                    <div class="list-item-content">
                                        <h3 class="list-item-title">{{ $log->action ?? 'Unknown Action' }} on
                                            {{ $log->model ?? 'Unknown Model' }}</h3>
                                        <p class="list-item-text">
                                            {{ $log->description ?? 'No description provided.' }}</p>
                                        <p class="list-item-meta">
                                            By {{ $log->user->name ?? 'Unknown User' }} on
                                            {{ $log->created_at ? $log->created_at->format('M d, Y H:i') : 'Unknown date' }}
                                        </p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle report form
            const reportBtn = document.getElementById('report-btn');
            const reportForm = document.getElementById('report-form');
            if (reportBtn && reportForm) {
                reportBtn.addEventListener('click', function() {
                    const isActive = reportForm.classList.toggle('active');
                    reportBtn.setAttribute('aria-expanded', isActive);
                    reportForm.setAttribute('aria-hidden', !isActive);
                });
            }

            // Residents Chart
            @if ($totalMale + $totalFemale > 0)
                try {
                    const residentsCtx = document.getElementById('residentsChart');
                    if (residentsCtx) {
                        new Chart(residentsCtx.getContext('2d'), {
                            type: 'doughnut',
                            data: {
                                labels: ['Male', 'Female'],
                                datasets: [{
                                    data: [{{ $totalMale ?? 0 }}, {{ $totalFemale ?? 0 }}],
                                    backgroundColor: ['#2563eb', '#ef4444'],
                                    borderWidth: 0
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                cutout: '65%',
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                        labels: {
                                            padding: 20,
                                            usePointStyle: true,
                                            pointStyle: 'circle',
                                            font: {
                                                size: 14,
                                                family: 'Inter'
                                            }
                                        }
                                    },
                                    tooltip: {
                                        backgroundColor: 'rgba(31, 41, 55, 0.9)',
                                        padding: 12,
                                        callbacks: {
                                            label: function(context) {
                                                let label = context.label || '';
                                                let value = context.raw || 0;
                                                let total = context.dataset.data.reduce((a, b) => a + b,
                                                    0);
                                                let percentage = total ? ((value / total) * 100)
                                                    .toFixed(1) : 0;
                                                return `${label}: ${value} (${percentage}%)`;
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    }
                } catch (error) {
                    console.error('Error initializing Residents Chart:', error);
                }
            @endif

            // Cases Chart
            @if (!$caseTypes->isEmpty())
                try {
                    const casesCtx = document.getElementById('casesChart');
                    if (casesCtx) {
                        new Chart(casesCtx.getContext('2d'), {
                            type: 'bar',
                            data: {
                                labels: [
                                    @foreach ($caseTypes as $type)
                                        "{{ $type->case_type ?? 'Unknown' }}",
                                    @endforeach
                                ],
                                datasets: [{
                                    label: 'Cases by Type',
                                    data: [
                                        @foreach ($caseTypes as $type)
                                            {{ $type->count ?? 0 }},
                                        @endforeach
                                    ],
                                    backgroundColor: ['#2563eb', '#ef4444', '#f59e0b', '#10b981'],
                                    borderWidth: 0,
                                    borderRadius: 4
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        grid: {
                                            color: 'rgba(0, 0, 0, 0.05)'
                                        },
                                        title: {
                                            display: true,
                                            text: 'Number of Cases',
                                            font: {
                                                size: 14,
                                                family: 'Inter',
                                                weight: '600'
                                            }
                                        }
                                    },
                                    x: {
                                        grid: {
                                            display: false
                                        },
                                        title: {
                                            display: true,
                                            text: 'Case Type',
                                            font: {
                                                size: 14,
                                                family: 'Inter',
                                                weight: '600'
                                            }
                                        }
                                    }
                                },
                                plugins: {
                                    legend: {
                                        display: false
                                    },
                                    tooltip: {
                                        backgroundColor: 'rgba(31, 41, 55, 0.9)',
                                        padding: 12,
                                        callbacks: {
                                            label: function(context) {
                                                return `${context.label}: ${context.raw} cases`;
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    }
                } catch (error) {
                    console.error('Error initializing Cases Chart:', error);
                }
            @endif

            // Interactivity: Search, Filter, and Sort
            const searchInput = document.getElementById('search-input');
            const dateFilter = document.getElementById('date-filter');
            const sortFilter = document.getElementById('sort-filter');
            const lists = {
                emergencies: document.getElementById('emergency-list'),
                announcements: document.getElementById('announcement-list'),
                auditLogs: document.getElementById('audit-log-list')
            };

            function filterAndSortItems(list, searchTerm, dateRange, sortBy) {
                if (!list) return;
                const items = Array.from(list.children);
                if (!items.length) return;

                items.forEach(item => {
                    const title = item.dataset.title?.toLowerCase() || '';
                    const date = new Date(item.dataset.date || Date.now());
                    const now = new Date();

                    // Search filter
                    const matchesSearch = searchTerm ? title.includes(searchTerm.toLowerCase()) : true;

                    // Date filter
                    let matchesDate = true;
                    if (dateRange === 'week') {
                        matchesDate = date >= new Date(now.setDate(now.getDate() - 7));
                    } else if (dateRange === 'month') {
                        matchesDate = date >= new Date(now.setMonth(now.getMonth() - 1));
                    } else if (dateRange === 'year') {
                        matchesDate = date >= new Date(now.setFullYear(now.getFullYear() - 1));
                    }

                    item.style.display = matchesSearch && matchesDate ? '' : 'none';
                    item.setAttribute('aria-hidden', !(matchesSearch && matchesDate));
                });

                // Sort items
                const sortedItems = items.sort((a, b) => {
                    const aDate = new Date(a.dataset.date || Date.now());
                    const bDate = new Date(b.dataset.date || Date.now());
                    const aTitle = a.dataset.title || '';
                    const bTitle = b.dataset.title || '';

                    if (sortBy === 'date-asc') return aDate - bDate;
                    if (sortBy === 'date-desc') return bDate - aDate;
                    if (sortBy === 'title-asc') return aTitle.localeCompare(bTitle);
                    if (sortBy === 'title-desc') return bTitle.localeCompare(aTitle);
                    return 0;
                });

                sortedItems.forEach(item => list.appendChild(item));
            }

            function applyFilters() {
                const searchTerm = searchInput?.value || '';
                const dateRange = dateFilter?.value || 'all';
                const sortBy = sortFilter?.value || 'date-desc';

                Object.entries(lists).forEach(([name, list]) => {
                    if (list) {
                        list.classList.add('loading');
                        list.setAttribute('aria-busy', 'true');
                        setTimeout(() => {
                            filterAndSortItems(list, searchTerm, dateRange, sortBy);
                            list.classList.remove('loading');
                            list.setAttribute('aria-busy', 'false');
                        }, 200);
                    }
                });
            }

            if (searchInput && dateFilter && sortFilter) {
                searchInput.addEventListener('input', applyFilters);
                dateFilter.addEventListener('change', applyFilters);
                sortFilter.addEventListener('change', applyFilters);
                applyFilters();
            }
        });
    </script>
</x-app-layout>
