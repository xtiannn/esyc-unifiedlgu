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
    <div class="row mb-3">
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
        <table class="table datatable table-bordered table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th class="text-center" scope="col">#</th>
                    <th scope="col">Type</th>
                    <th scope="col">Description</th>
                    <th scope="col">Location</th>
                    <th class="text-center" scope="col">Media</th>
                    <th scope="col">Reported By</th>
                    <th class="text-center" scope="col">Status</th>
                    <th scope="col">Date</th>
                    <th class="text-center" scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($incidents as $log)
                    <tr>
                        <td class="text-center" data-label="#">{{ $loop->iteration }}.</td>
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
                        <td class="text-center" data-label="Media">
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
                        <td data-label="Reported By">{{ Str::title($log->reportedBy->name ?? 'Unknown') }}</td>
                        <td class="text-center" data-label="Status">
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-warning text-dark',
                                    'resolved' => 'bg-success',
                                    'closed' => 'bg-secondary',
                                ];
                            @endphp
                            <span class="badge {{ $statusClasses[$log->status] ?? 'bg-danger' }}">
                                {{ ucfirst($log->status) }}
                            </span>
                        </td>

                        <td data-label="Date">{{ $log->created_at->format('F j, Y g:i A') }}</td>
                        <td class="text-center" data-label="Action">

                            <button class="btn btn-primary btn-sm editCaseBtn" data-id="{{ $log->id }}"
                                data-bs-toggle="modal" data-bs-target="#updateIncidentModal{{ $log->id }}">
                                <i class="fa fa-edit"></i>
                            </button>


                            {{-- Reusable Delete Button --}}
                            @include('components.delete-button', [
                                'id' => $log->id,
                                'route' => route('incident.destroy', $log->id),
                                'itemName' => $log->description,
                            ])
                        </td>

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
                                        <p><strong>Type:</strong> {{ $log->incident_type }}</p>
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
                                                <img src="{{ asset('storage/' . $log->media_path) }}"
                                                    class="img-fluid">
                                            @elseif ($log->media_type === 'video')
                                                <video width="100%" controls>
                                                    <source src="{{ asset('storage/' . $log->media_path) }}"
                                                        type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            @else
                                                <a href="{{ asset('storage/' . $log->media_path) }}"
                                                    target="_blank">View
                                                    File</a>
                                            @endif
                                        @else
                                            <p>No media available</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Update Incident Modal -->
                        <div class="modal fade" id="updateIncidentModal{{ $log->id }}" tabindex="-1"
                            aria-labelledby="updateIncidentModalLabel{{ $log->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fw-bolder" id="updateIncidentModalLabel"
                                            style="font-size: 25px">
                                            Update Incident
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('incident.update', ['incident' => $log->id]) }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')

                                            <div class="row">
                                                <!-- Left Column: All Input Fields -->
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <div class="form-floating">
                                                            <input type="text"
                                                                class="form-control form-control-sm @error('incident_type') is-invalid @enderror"
                                                                id="incident_type" name="incident_type"
                                                                value="{{ old('incident_type', $log->incident_type) }}"
                                                                placeholder="Incident Type" required>
                                                            <label for="incident_type">Incident Type</label>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <div class="form-floating">
                                                            <textarea class="form-control form-control-sm @error('description') is-invalid @enderror" id="description"
                                                                name="description" placeholder="Description" style="height: 150px" required>{{ old('description', $log->description) }}</textarea>
                                                            <label for="description">Description</label>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <div class="form-floating">
                                                            <select
                                                                class="form-select form-select-sm @error('media_type') is-invalid @enderror"
                                                                id="media_type" name="media_type" required>
                                                                <option value="" disabled>Select...</option>
                                                                <option value="image"
                                                                    {{ old('media_type', $log->media_type) === 'image' ? 'selected' : '' }}>
                                                                    Image</option>
                                                                <option value="video"
                                                                    {{ old('media_type', $log->media_type) === 'video' ? 'selected' : '' }}>
                                                                    Video</option>
                                                            </select>
                                                            <label for="media_type">Media Type</label>
                                                        </div>
                                                    </div>

                                                    <!-- Row for Media Upload & Status -->
                                                    <div class="row">
                                                        <!-- Media Upload -->
                                                        <div class="col-md-6">
                                                            <div class="mb-3" id="media_upload_group">
                                                                <div class="form-floating">
                                                                    <input type="file"
                                                                        class="form-control form-control-sm"
                                                                        id="media" name="media"
                                                                        placeholder="Upload Media">
                                                                    <label for="media">Upload Media</label>
                                                                    <small class="text-muted" id="media_hint"
                                                                        style="font-size: 12px;"></small>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Status Select -->
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <div class="form-floating">
                                                                    <select
                                                                        class="form-select form-select-sm @error('status') is-invalid @enderror"
                                                                        id="status" name="status" required>
                                                                        <option value="Pending"
                                                                            {{ old('status', $log->status) === 'pending' ? 'selected' : '' }}>
                                                                            Pending</option>
                                                                        <option value="Resolved"
                                                                            {{ old('status', $log->status) === 'resolved' ? 'selected' : '' }}>
                                                                            Resolved</option>
                                                                        <option value="Closed"
                                                                            {{ old('status', $log->status) === 'closed' ? 'selected' : '' }}>
                                                                            Closed</option>
                                                                    </select>
                                                                    <label for="status">Status</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Right Column: Embedded Google Map -->
                                                <div class="col-md-6">
                                                    <div class="mb-1">
                                                        <div class="form-floating">
                                                            <input type="text"
                                                                class="form-control form-control-sm @error('location') is-invalid @enderror"
                                                                id="uplocation" name="location"
                                                                value="{{ old('location', $log->location) }}"
                                                                placeholder="Enter Address or Coordinates" required
                                                                oninput="editMap()">
                                                            <label for="uplocation">Search Location...</label>
                                                        </div>
                                                    </div>
                                                    <a id="fullMapLink"
                                                        href="https://www.google.com/maps?q={{ urlencode($log->location) }}"
                                                        target="_blank">
                                                        <iframe id="upincidentMap"
                                                            src="https://www.google.com/maps?q={{ urlencode($log->location) }}&output=embed"
                                                            width="100%" height="300" style="border:0;"
                                                            allowfullscreen="" loading="lazy">
                                                        </iframe>
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="modal-footer mt-2">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">
                                                    <i class="fa fa-times-circle"></i> Cancel
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fa fa-save"></i> Update Incident
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">No incident logs found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @include('incidents.modals.logIncident')


    <!-- JavaScript to Update the Map -->
    {{-- <script>
        function updateMap() {
            let location = document.getElementById("location").value;
            let mapIframe = document.getElementById("incidentMap");

            if (location) {
                // Convert the user input into a Google Maps search URL
                let query = encodeURIComponent(location);
                let newSrc = `https://www.google.com/maps?q=${query}&output=embed`;

                // Update the iframe src to show the new location
                mapIframe.src = newSrc;
            }
        }

        function editMap() {
            let uplocation = document.getElementById("uplocation").value;
            let upmapIframe = document.getElementById("upincidentMap");

            if (uplocation) {
                // Convert the user input into a Google Maps search URL
                let upquery = encodeURIComponent(uplocation);
                let upnewSrc = `https://www.google.com/maps?q=${upquery}&output=embed`;

                // Update the iframe src to show the new location
                upmapIframe.src = upnewSrc;
            }
        }

        document.getElementById('media_type').addEventListener('change', function() {
            let mediaInput = document.getElementById('media');
            let mediaHint = document.getElementById('media_hint');
            let mediaUploadGroup = document.getElementById('media_upload_group');

            if (this.value === 'image') {
                mediaInput.accept = 'image/png, image/jpeg, image/jpg, image/gif';
                mediaHint.textContent = "Allowed file types: PNG, JPG, JPEG, GIF.";
            } else if (this.value === 'video') {
                mediaInput.accept = 'video/mp4, video/avi, video/mkv, video/mov';
                mediaHint.textContent = "Allowed file types: MP4, AVI, MKV, MOV.";
            }

            mediaUploadGroup.style.display = 'block';
        });
    </script> --}}





</x-app-layout>
