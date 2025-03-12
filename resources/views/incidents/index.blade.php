<x-app-layout>
    @section('title', 'Incident Logs')

    <style>
        .media-cell {
            width: 100px;
            text-align: center;
        }

        .media-content {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
    <div class="row">
        <div class="col-md-10 mt-2">
            <h1>Incident Reports</h1>
        </div>
        <div class="col-md-2 text-end">
            <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#logIncidentModal">
                <i class="fa fa-exclamation-triangle me-2"></i> Log Incident
            </button>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-custom">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Type</th>
                    <th scope="col">Description</th>
                    <th scope="col">Location</th>
                    <th scope="col">Media</th>
                    <th scope="col">Reported By</th>
                    <th scope="col">Status</th>
                    <th scope="col">Date</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($incidents as $log)
                    <tr>
                        <td data-label="#">{{ $loop->iteration }}.</td>
                        <td data-label="Type">{{ $log->incident_type }}</td>
                        <td data-label="Description">
                            @if (Str::length($log->description) > 50)
                                <a href="#" data-bs-toggle="modal" data-bs-target="#descModal{{ $log->id }}">
                                    {{ Str::limit(Str::title($log->description), 50, '...') }}
                                </a>
                            @else
                                {{ Str::title($log->description) }}
                            @endif
                        </td>

                        <div class="modal fade" id="descModal{{ $log->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-sm"> <!-- Centered & Large Modal -->
                                <div class="modal-content shadow-lg border-0">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title fw-bold">{{ $log->incident_type }}</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="fs-5 text-dark">{{ $log->description }}</p>
                                        <div class="text-end mt-3">
                                            <small class="text-muted">📅 Issued at:
                                                {{ $log->created_at->format('F j, Y g:i A') }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <td data-label="Location">{{ $log->location }}</td>
                        <td data-label="Media">
                            @if ($log->media_path)
                                @if ($log->media_type === 'image')
                                    <a href="{{ asset('storage/' . $log->media_path) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $log->media_path) }}" alt="Media"
                                            class="small-image" style="width: 30px; height: auto;">
                                    </a>
                                @elseif ($log->media_type === 'video')
                                    <video width="150" controls>
                                        <source src="{{ asset('storage/' . $log->media_path) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                @else
                                    <a href="{{ asset('storage/' . $log->media_path) }}" target="_blank">View File</a>
                                @endif
                            @else
                                No media
                            @endif
                        </td>
                        <td data-label="Reported By">{{ $log->reportedBy->name ?? 'Unknown' }}</td>
                        <td data-label="Status">
                            <span class="badge {{ $log->status === 'Resolved' ? 'bg-success' : 'bg-danger' }}">
                                {{ ucfirst($log->status) }}
                            </span>
                        </td>
                        <td data-label="Date">{{ $log->created_at->format('F j, Y g:i A') }}</td>
                        <td data-label="Action">

                            <button class="btn btn-primary btn-sm editCaseBtn" data-id="{{ $log->id }}"
                                data-bs-toggle="modal" data-bs-target="#updateIncidentModal">
                                <i class="fa fa-edit"></i>
                            </button>

                            {{-- Reusable Delete Button --}}
                            @include('components.delete-button', [
                                'id' => $log->id,
                                'route' => route('incident.destroy', $log->id),
                                'itemName' => $log->description,
                            ])
                        </td>

                        @include('incidents.modals.logIncident')


                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">No incident logs found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>








</x-app-layout>
