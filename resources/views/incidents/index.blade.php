<x-app-layout>
    <div class="row">
        <div class="col-md-10">
            <h1>Emergency Alerts</h1>
        </div>
        <div class="col-md-2 text-end">
            <button type="button" class="btn btn-warning mt-2" data-bs-toggle="modal" data-bs-target="#logIncidentModal">
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
                        <td data-label="Type">{{ $log->type }}</td>
                        <td data-label="Description">{{ $log->description }}</td>
                        <td data-label="Location">{{ $log->location }}</td>
                        <td data-label="Media">
                            @if ($log->media_path)
                                @if ($log->media_type === 'image')
                                    <a href="{{ asset('storage/' . $log->media_path) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $log->media_path) }}" alt="Media"
                                            class="small-image">
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
                        <td data-label="Reported By">{{ $log->reported_by->name ?? 'Unknown' }}</td>
                        <td data-label="Status">
                            <span class="badge {{ $log->status === 'Resolved' ? 'bg-success' : 'bg-danger' }}">
                                {{ ucfirst($log->status) }}
                            </span>
                        </td>
                        <td data-label="Date">{{ $log->created_at->format('F j, Y g:i A') }}</td>
                        <td data-label="Action">
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#viewIncidentModal-{{ $log->id }}">
                                <i class="fa fa-eye"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- View Incident Modal -->
                    <div class="modal fade" id="viewIncidentModal-{{ $log->id }}" tabindex="-1"
                        aria-labelledby="viewIncidentLabel-{{ $log->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fw-bolder" id="viewIncidentLabel-{{ $log->id }}"
                                        style="font-size: 20px">
                                        Incident Details
                                    </h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Type:</strong> {{ $log->type }}</p>
                                    <p><strong>Description:</strong> {{ $log->description }}</p>
                                    <p><strong>Location:</strong> {{ $log->location }}</p>
                                    <p><strong>Reported By:</strong> {{ $log->reported_by->name ?? 'Unknown' }}</p>
                                    <p><strong>Status:</strong> <span
                                            class="badge {{ $log->status === 'Resolved' ? 'bg-success' : 'bg-danger' }}">{{ ucfirst($log->status) }}</span>
                                    </p>
                                    <p><strong>Date:</strong> {{ $log->created_at->format('F j, Y g:i A') }}</p>

                                    @if ($log->media_path)
                                        <p><strong>Media:</strong></p>
                                        @if ($log->media_type === 'image')
                                            <img src="{{ asset('storage/' . $log->media_path) }}" class="img-fluid">
                                        @elseif ($log->media_type === 'video')
                                            <video width="100%" controls>
                                                <source src="{{ asset('storage/' . $log->media_path) }}"
                                                    type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        @else
                                            <a href="{{ asset('storage/' . $log->media_path) }}" target="_blank">View
                                                File</a>
                                        @endif
                                    @else
                                        <p>No media available</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">No incident logs found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>


    @include('incidents.modals.logIncident');



</x-app-layout>
