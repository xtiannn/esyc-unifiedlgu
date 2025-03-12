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

                        <!-- Log Incident Modal -->
                        <div class="modal fade" id="logIncidentModal" tabindex="-1"
                            aria-labelledby="logIncidentModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fw-bolder" id="logIncidentModalLabel"
                                            style="font-size: 25px">
                                            Log Incident
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('incident.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf

                                            <div class="row">
                                                <!-- Left Column: All Input Fields -->
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <div class="form-floating">
                                                            <input type="text"
                                                                class="form-control form-control-sm @error('incident_type') is-invalid @enderror"
                                                                id="incident_type" name="incident_type"
                                                                value="{{ old('incident_type') }}"
                                                                placeholder="Incident Type" required>
                                                            <label for="incident_type">Incident Type</label>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <div class="form-floating">
                                                            <textarea class="form-control form-control-sm @error('description') is-invalid @enderror" id="description"
                                                                name="description" placeholder="Description" style="height: 150px" required>{{ old('description') }}</textarea>
                                                            <label for="description">Description</label>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <div class="form-floating">
                                                            <select
                                                                class="form-select form-select-sm @error('media_type') is-invalid @enderror"
                                                                id="media_type" name="media_type" required>
                                                                <option value="" disabled
                                                                    {{ old('media_type') ? '' : 'selected' }}>
                                                                    Select...</option>
                                                                <option value="image"
                                                                    {{ old('media_type') === 'image' ? 'selected' : '' }}>
                                                                    Image</option>
                                                                <option value="video"
                                                                    {{ old('media_type') === 'video' ? 'selected' : '' }}>
                                                                    Video</option>
                                                            </select>
                                                            <label for="media_type">Media Type</label>
                                                        </div>
                                                    </div>

                                                    <!-- Media Upload -->
                                                    <div class="mb-3" id="media_upload_group">
                                                        <div class="form-floating">
                                                            <input type="file" class="form-control form-control-sm"
                                                                id="media" name="media"
                                                                placeholder="Upload Media">
                                                            <label for="media">Upload Media</label>
                                                            <small class="text-muted" id="media_hint"
                                                                style="font-size: 12px;"></small>
                                                        </div>
                                                        <small id="media_hint" class="text-muted"></small>
                                                    </div>


                                                </div>

                                                <!-- Right Column: Embedded Google Map -->
                                                <div class="col-md-6">
                                                    <div class="mb-1">
                                                        <div class="form-floating">
                                                            <input type="text"
                                                                class="form-control form-control-sm @error('location') is-invalid @enderror"
                                                                id="location" name="location"
                                                                value="{{ old('location') }}"
                                                                placeholder="Enter Address or Coordinates" required
                                                                oninput="updateMap()">
                                                            <label for="location">Search Location....</label>
                                                        </div>
                                                    </div>
                                                    <a id="fullMapLink" href="https://www.google.com/maps?q=Philippines"
                                                        target="_blank">
                                                        <iframe id="incidentMap"
                                                            src="https://www.google.com/maps?q=Philippines&output=embed"
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
                                                    <i class="fa fa-exclamation-triangle"></i> Log Incident
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Update Incident Modal -->
                        <div class="modal fade" id="updateIncidentModal" tabindex="-1"
                            aria-labelledby="updateIncidentModalLabel" aria-hidden="true">
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

                                                    <!-- Media Upload -->
                                                    <div class="mb-3" id="media_upload_group">
                                                        <div class="form-floating">
                                                            <input type="file" class="form-control form-control-sm"
                                                                id="media" name="media"
                                                                placeholder="Upload Media">
                                                            <label for="media">Upload Media</label>
                                                            <small class="text-muted" id="media_hint"
                                                                style="font-size: 12px;"></small>
                                                        </div>
                                                        <small id="media_hint" class="text-muted"></small>
                                                    </div>
                                                </div>

                                                <!-- Right Column: Embedded Google Map -->
                                                <div class="col-md-6">
                                                    <div class="mb-1">
                                                        <div class="form-floating">
                                                            <input type="text"
                                                                class="form-control form-control-sm @error('location') is-invalid @enderror"
                                                                id="location" name="location"
                                                                value="{{ old('location', $log->location) }}"
                                                                placeholder="Enter Address or Coordinates" required
                                                                oninput="updateMap()">
                                                            <label for="location">Search Location....</label>
                                                        </div>
                                                    </div>
                                                    <a id="fullMapLink"
                                                        href="https://www.google.com/maps?q={{ urlencode($log->location) }}"
                                                        target="_blank">
                                                        <iframe id="incidentMap"
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


                        <!-- JavaScript to Update the Map -->
                        <script>
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
                        </script>
