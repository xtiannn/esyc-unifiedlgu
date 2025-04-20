<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chairman Report</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        @page {
            margin: 0.8cm;
            header: html_pageHeader;
            footer: html_pageFooter;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: #1a1a1a;
            line-height: 1.3;
            font-size: 9.5pt;
        }

        .cover-page {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 50vh;
            text-align: center;
            background: linear-gradient(180deg, #f3f4f6 0%, #ffffff 100%);
            border: 1px solid #d1d5db;
            border-radius: 5px;
            margin: 0.3rem;
            padding: 1rem;
        }

        .section-title {
            color: #1e3a8a;
            font-size: 1rem;
            font-weight: 700;
            border-bottom: 1px solid #1e3a8a;
            padding-bottom: 0.2rem;
            margin: 0.5rem 0 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .stats-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin: 0.3rem 0;
            border: 1px solid #d1d5db;
            border-radius: 5px;
            overflow: hidden;
            background-color: #ffffff;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            page-break-inside: avoid;
        }

        .stats-table th,
        .stats-table td {
            padding: 0.4rem;
            text-align: left;
            border-bottom: 1px solid #d1d5db;
            font-size: 0.8rem;
        }

        .stats-table th {
            background: linear-gradient(180deg, #dbeafe 0%, #bfdbfe 100%);
            color: #1e3a8a;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .stats-table tr:last-child td {
            border-bottom: none;
        }

        .stats-table tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .data-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin: 0.3rem 0;
            border: 1px solid #d1d5db;
            border-radius: 5px;
            overflow: hidden;
            background-color: #ffffff;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            page-break-inside: avoid;
        }

        .data-table th,
        .data-table td {
            padding: 0.4rem;
            text-align: left;
            border-bottom: 1px solid #d1d5db;
            font-size: 0.8rem;
            word-break: break-word;
        }

        .data-table th {
            background: linear-gradient(180deg, #dbeafe 0%, #bfdbfe 100%);
            color: #1e3a8a;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .data-table tr:last-child td {
            border-bottom: none;
        }

        .data-table tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.2rem 0;
            border-bottom: 1px solid #d1d5db;
            background-color: #ffffff;
        }

        .footer {
            font-size: 0.65rem;
            color: #4b5563;
            text-align: center;
            padding: 0.2rem 0;
            border-top: 1px solid #d1d5db;
            background-color: #ffffff;
        }

        .text-primary {
            color: #1e3a8a;
        }

        .text-secondary {
            color: #4b5563;
        }

        .section-container {
            margin-bottom: 0.5rem;
        }
    </style>
</head>

<body>
    <!-- Page Header -->
    <htmlpageheader name="pageHeader">
        <div class="header">
            <div>
                @if (file_exists(public_path('images/lgu-logo.png')))
                    <img src="{{ public_path('images/lgu-logo.png') }}" alt="LGU Logo" style="height: 24px;">
                @endif
            </div>
            <div class="text-right">
                <p class="text-2xs font-semibold text-primary">Unified LGU Report</p>
                <p class="text-3xs text-secondary">Generated: {{ now()->format('F j, Y') }}</p>
            </div>
        </div>
    </htmlpageheader>

    <!-- Page Footer -->
    <htmlpagefooter name="pageFooter">
        <div class="footer">
            <p>Period: {{ \Carbon\Carbon::parse($startDate)->format('F j, Y') }} to
                {{ \Carbon\Carbon::parse($endDate)->format('F j, Y') }}</p>
        </div>
    </htmlpagefooter>

    <!-- Cover Page -->
    <div class="cover-page page-break">
        @if (file_exists(public_path('images/lgu-logo.png')))
            <img src="{{ public_path('images/lgu-logo.png') }}" alt="LGU Logo" class="mb-2 h-12">
        @endif
        <h1 class="text-lg font-bold text-primary">Unified LGU Report</h1>
        <p class="text-xs mt-0.5 text-secondary">Period: {{ \Carbon\Carbon::parse($startDate)->format('F j, Y') }} to
            {{ \Carbon\Carbon::parse($endDate)->format('F j, Y') }}</p>
        <p class="text-2xs mt-0.5 text-secondary">Prepared by: {{ auth()->user()->name ?? 'Administrator' }}</p>
        <p class="text-2xs mt-0.5 text-secondary">Generated on: {{ now()->format('F j, Y') }}</p>
    </div>

    <!-- Residents Section -->
    <div class="section-container" id="residents">
        <h2 class="section-title">Residents</h2>
        <table class="stats-table">
            <thead>
                <tr>
                    <th>Metric</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Total Residents</td>
                    <td class="font-bold">{{ $totalResidents }}</td>
                </tr>
                <tr>
                    <td>Male</td>
                    <td class="font-bold">{{ $totalMale }}</td>
                </tr>
                <tr>
                    <td>Female</td>
                    <td class="font-bold">{{ $totalFemale }}</td>
                </tr>
                <tr>
                    <td>Working Residents</td>
                    <td class="font-bold">{{ $workingResidents }}</td>
                </tr>
            </tbody>
        </table>
        @if ($residentsChartData['data'][0] > 0 || $residentsChartData['data'][1] > 0)
            <h3 class="text-2xs font-semibold text-primary mt-1 mb-0.5">Residents by Gender</h3>
            <table class="stats-table">
                <thead>
                    <tr>
                        <th>Gender</th>
                        <th>Count</th>
                        <th>Percentage</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total = array_sum($residentsChartData['data']);
                        $percentages = array_map(
                            fn($value) => $total ? round(($value / $total) * 100, 1) : 0,
                            $residentsChartData['data'],
                        );
                    @endphp
                    @foreach ($residentsChartData['labels'] as $index => $label)
                        <tr>
                            <td>{{ $label }}</td>
                            <td class="font-bold">{{ $residentsChartData['data'][$index] }}</td>
                            <td>{{ $percentages[$index] }}%</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- Cases Section -->
    <div class="section-container" id="cases">
        <h2 class="section-title">Cases</h2>
        <table class="stats-table">
            <thead>
                <tr>
                    <th>Metric</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Total Cases</td>
                    <td class="font-bold">{{ $totalCases }}</td>
                </tr>
                <tr>
                    <td>Open</td>
                    <td class="font-bold">{{ $openCases }}</td>
                </tr>
                <tr>
                    <td>In Progress</td>
                    <td class="font-bold">{{ $inProgressCases }}</td>
                </tr>
                <tr>
                    <td>Resolved</td>
                    <td class="font-bold">{{ $resolvedCases }}</td>
                </tr>
            </tbody>
        </table>
        @if (!empty($casesChartData['data']))
            <h3 class="text-2xs font-semibold text-primary mt-1 mb-0.5">Cases by Type</h3>
            <table class="stats-table">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Count</th>
                        <th>Percentage</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalCases = array_sum($casesChartData['data']);
                        $casePercentages = array_map(
                            fn($value) => $totalCases ? round(($value / $totalCases) * 100, 1) : 0,
                            $casesChartData['data'],
                        );
                    @endphp
                    @foreach ($casesChartData['labels'] as $index => $label)
                        <tr>
                            <td>{{ $label }}</td>
                            <td class="font-bold">{{ $casesChartData['data'][$index] }}</td>
                            <td>{{ $casePercentages[$index] }}%</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- Emergencies Section -->
    <div class="section-container" id="emergencies">
        <h2 class="section-title">Emergencies</h2>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Creator</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($emergencies as $emergency)
                    <tr>
                        <td>{{ $emergency->emergency_type ?? 'N/A' }}</td>
                        <td>{{ Str::limit($emergency->description ?? 'No description', 50) }}</td>
                        <td>{{ $emergency->creator->name ?? 'Unknown' }}</td>
                        <td>{{ $emergency->created_at ? \Carbon\Carbon::parse($emergency->created_at)->format('Y-m-d') : 'N/A' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-secondary">No emergencies found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Incidents and Scholarships Section -->
    <div class="section-container" id="incidents-scholarships">
        <h2 class="section-title">Incidents & Scholarships</h2>
        <div class="flex space-x-1">
            <div class="flex-1">
                <h3 class="text-2xs font-semibold text-primary mb-0.5">Incidents</h3>
                <table class="stats-table">
                    <thead>
                        <tr>
                            <th>Metric</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Total</td>
                            <td class="font-bold">{{ $totalIncidents }}</td>
                        </tr>
                        <tr>
                            <td>Pending</td>
                            <td class="font-bold">{{ $pendingIncidents }}</td>
                        </tr>
                        <tr>
                            <td>Resolved</td>
                            <td class="font-bold">{{ $resolvedIncidents }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="flex-1">
                <h3 class="text-2xs font-semibold text-primary mb-0.5">Scholarships</h3>
                <table class="stats-table">
                    <thead>
                        <tr>
                            <th>Metric</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Total Applications</td>
                            <td class="font-bold">{{ $totalScholarships }}</td>
                        </tr>
                        <tr>
                            <td>Pending</td>
                            <td class="font-bold">{{ $pendingScholarships }}</td>
                        </tr>
                        <tr>
                            <td>Interview Scheduled</td>
                            <td class="font-bold">{{ $interviewScheduledScholarships }}</td>
                        </tr>
                        <tr>
                            <td>Approved</td>
                            <td class="font-bold">{{ $approvedScholarships }}</td>
                        </tr>
                        <tr>
                            <td>Rejected</td>
                            <td class="font-bold">{{ $rejectedScholarships }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Announcements Section -->
    <div class="section-container" id="announcements">
        <h2 class="section-title">Announcements</h2>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($announcements as $announcement)
                    <tr>
                        <td>{{ $announcement->title ?? 'Untitled' }}</td>
                        <td>{{ Str::limit($announcement->content ?? 'No content', 50) }}</td>
                        <td>{{ $announcement->created_at ? \Carbon\Carbon::parse($announcement->created_at)->format('Y-m-d') : 'N/A' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-secondary">No announcements found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>

</html>
