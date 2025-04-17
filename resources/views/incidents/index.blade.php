<x-app-layout>
    @section('title', 'Incident Logs')

    <style>
        /* Custom styles for table alignment */
        .table th,
        .table td {
            vertical-align: middle;
        }

        .table .description-column {
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .table .media-column img,
        .table .media-column video {
            max-width: 50px;
            height: auto;
        }

        .table .action-column {
            width: 120px;
        }

        .table .location-column {
            min-width: 120px;
        }

        .badge {
            font-size: 0.9rem;
            padding: 0.5em 1em;
        }

        /* New styles for location button */
        .btn-location {
            font-size: 0.85rem;
            padding: 0.25rem 0.75rem;
            line-height: 1.5;
        }

        .location-muted {
            color: #6c757d;
            font-style: italic;
        }

        @media (max-width: 768px) {
            .table .description-column {
                max-width: 100px;
            }

            .btn-location {
                font-size: 0.8rem;
                padding: 0.2rem 0.5rem;
            }
        }
    </style>



    <div class="container-fluid py-4">
        <div class="row mb-3 align-items-center">
            <div class="col-md-10">
                <h1 class="mb-0">Incident Reports</h1>
            </div>
            <div class="col-md-2 text-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#logIncidentModal">
                    <i class="fa fa-exclamation-triangle me-2"></i> Log Incident
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center">#</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th class="text-center">Media</th>
                        <th>Reported By</th>
                        <th class="text-center">Contact</th>
                        <th class="text-center">Status</th>
                        <th>Date</th>
                        <th class="text-center action-column">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($incidents as $log)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ Str::title($log->incident_type) }}</td>
                            <td class="description-column">
                                @if (Str::length($log->description) > 50)
                                    <a href="#" data-bs-toggle="modal"
                                        data-bs-target="#descModal{{ $log->id }}">
                                        {{ Str::limit(Str::title($log->description), 50, '...') }}
                                    </a>
                                @else
                                    {{ Str::title($log->description) }}
                                @endif
                            </td>
                            <td class="text-center media-column">
                                @if ($log->media_path)
                                    @if ($log->media_type === 'image')
                                        <a href="{{ asset('storage/' . $log->media_path) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $log->media_path) }}" alt="Media">
                                        </a>
                                    @elseif ($log->media_type === 'video')
                                        <video controls>
                                            <source src="{{ asset('storage/' . $log->media_path) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    @else
                                        <a href="{{ asset('storage/' . $log->media_path) }}" target="_blank"
                                            class="text-primary">
                                            View File
                                        </a>
                                    @endif
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ Str::title($log->reportedBy->name ?? 'Unknown') }}</td>
                            <td class="text-center">{{ $log->contact_number }}</td>
                            <td class="text-center m-0">
                                <!-- Dropdown for status change -->
                                <div class="mt-2">
                                    <select class="form-select form-select-sm status-dropdown"
                                        data-id="{{ $log->id }}">
                                        <option value="pending" {{ $log->status == 'pending' ? 'selected' : '' }}>
                                            Pending
                                        </option>
                                        <option value="resolved" {{ $log->status == 'resolved' ? 'selected' : '' }}>
                                            Resolved
                                        </option>
                                        <option value="closed" {{ $log->status == 'closed' ? 'selected' : '' }}>
                                            Closed
                                        </option>
                                    </select>
                                </div>
                            </td>
                            <td>{{ $log->created_at->format('M d, Y h:i A') }}</td>
                            <td class="text-center">
                                <div class="btn-group gap-1" role="group">
                                    @if ($log->latitude && $log->longitude)
                                        <a href="https://www.google.com/maps?q={{ $log->latitude }},{{ $log->longitude }}"
                                            target="_blank" class="btn btn-outline-primary btn-sm btn-location"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Open in Google Maps"
                                            aria-label="View incident location on Google Maps">
                                            <i class="fa fa-map-marker-alt me-1"></i>
                                        </a>
                                    @else
                                        <span class="location-muted">No location</span>
                                    @endif
                                    <button class="btn btn-info btn-sm"
                                        onclick="viewIncidentDetails({{ $log->id }})">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                    @include('components.delete-button', [
                                        'id' => $log->id,
                                        'route' => route('incident.destroy', $log->id),
                                        'itemName' => $log->description,
                                    ])
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">No incident logs found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Description Modals -->
    @foreach ($incidents as $log)
        <div class="modal fade" id="descModal{{ $log->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">{{ Str::title($log->incident_type) }}</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>{{ $log->description }}</p>
                        <div class="text-end">
                            <small class="text-muted">Reported:
                                {{ $log->created_at->format('M d, Y h:i A') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @include('incidents.modals.logIncident')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle the status dropdown change event
            document.querySelectorAll('.status-dropdown').forEach(function(select) {
                select.addEventListener('change', function() {
                    let incidentId = this.dataset.id;
                    let newStatus = this.value;

                    // Send AJAX request to update the status
                    updateIncidentStatus(incidentId, newStatus);
                });
            });
        });

        async function updateIncidentStatus(incidentId, newStatus) {
            try {
                const response = await fetch(`/incident/update-status/${incidentId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: JSON.stringify({
                        status: newStatus
                    })
                });

                const data = await response.json();

                if (response.ok) {
                    // Flash success message and reload the page
                    displayFlashMessage('success', 'Status updated successfully!');
                    location.reload(); // Reload the page to reflect changes
                } else {
                    // Flash error message
                    displayFlashMessage('error', 'Failed to update status.');
                }
            } catch (error) {
                console.error('Error updating status:', error);
                displayFlashMessage('error', 'Error updating status.');
            }
        }

        // Flash message display function
        function displayFlashMessage(type, message) {
            const flashMessage = document.createElement('div');
            flashMessage.setAttribute('role', 'alert');
            flashMessage.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
            document.body.appendChild(flashMessage);

            // Auto-dismiss after 5 seconds
            setTimeout(() => {
                flashMessage.classList.remove('show');
            }, 5000);
        }
    </script>

    <!-- Initialize Bootstrap tooltips -->
    <script>
        async function viewIncidentDetails(incidentId) {
            try {
                const res = await fetch(`/incident/${incidentId}/data`);
                const incident = await res.json();

                const lat = incident.latitude;
                const lng = incident.longitude;

                const locationContainer = document.getElementById('modalNotifLocation');
                locationContainer.innerHTML = '';

                if (lat && lng) {
                    const locationLink = document.createElement('a');
                    locationLink.href = `https://www.google.com/maps?q=${lat},${lng}`;
                    locationLink.target = '_blank';
                    locationLink.textContent = 'View on Map';
                    locationLink.style.color = '#007bff';
                    locationLink.style.textDecoration = 'underline';
                    locationContainer.appendChild(locationLink);
                } else {
                    locationContainer.innerText = 'Coordinates Not Available';
                }

                document.getElementById('modalNotifTitle').innerText = incident.incident_type ?
                    toTitleCase(incident.incident_type) :
                    'Incident Reported';

                document.getElementById('modalNotifMessage').innerText = incident.description ?
                    toTitleCase(incident.description) :
                    'No Description Available.';

                document.getElementById('modalNotifTimestamp').innerText = incident.created_at ?
                    new Date(incident.created_at).toLocaleString() :
                    'N/A';

                document.getElementById('modalNotifType').innerText = incident.incident_type ?
                    toTitleCase(incident.incident_type) :
                    'General';

                document.getElementById('modalNotifStatus').innerText = incident.status ?
                    toTitleCase(incident.status) :
                    'Pending';

                const reporterName = incident.reported_by ?
                    toTitleCase([
                        incident.reported_by.first_name ?? '',
                        incident.reported_by.middle_name ?? '',
                        incident.reported_by.last_name ?? ''
                    ].join(' ').trim()) :
                    'N/A';

                document.getElementById('modalNotifReporter').innerText = reporterName;

                document.getElementById('modalNotifLatitude').innerText = incident.latitude ?? 'Pending';
                document.getElementById('modalNotifLongitude').innerText = incident.longitude ?? 'Pending';
                document.getElementById('modalNotifLink').href = `/incidents/${incident.id}`;

                $('#notifModal').modal('show');

            } catch (err) {
                console.error('Error fetching incident data:', err);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>

</x-app-layout>
