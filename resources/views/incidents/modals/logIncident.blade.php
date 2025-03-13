<!-- Log Incident Modal -->
<div class="modal fade" id="logIncidentModal" tabindex="-1" aria-labelledby="logIncidentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fw-bolder" id="logIncidentModalLabel" style="font-size: 25px">
                    Log Incident
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('incident.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <!-- Left Column: All Input Fields -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-floating">
                                    <input type="text"
                                        class="form-control form-control-sm @error('incident_type') is-invalid @enderror"
                                        id="incident_type" name="incident_type" value="{{ old('incident_type') }}"
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
                                    <select class="form-select form-select-sm @error('media_type') is-invalid @enderror"
                                        id="media_type" name="media_type" required>
                                        <option value="" disabled {{ old('media_type') ? '' : 'selected' }}>
                                            Select...</option>
                                        <option value="image" {{ old('media_type') === 'image' ? 'selected' : '' }}>
                                            Image</option>
                                        <option value="video" {{ old('media_type') === 'video' ? 'selected' : '' }}>
                                            Video</option>
                                    </select>
                                    <label for="media_type">Media Type</label>
                                </div>
                            </div>

                            <!-- Media Upload -->
                            <div class="mb-3" id="media_upload_group">
                                <div class="form-floating">
                                    <input type="file" class="form-control form-control-sm" id="media"
                                        name="media" placeholder="Upload Media">
                                    <label for="media">Upload Media</label>
                                    <small class="text-muted" id="media_hint" style="font-size: 12px;"></small>
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
                                        id="location" name="location" value="{{ old('location') }}"
                                        placeholder="Enter Address or Coordinates" required oninput="updateMap()">
                                    <label for="location">Search Location....</label>
                                </div>
                            </div>
                            <a id="fullMapLink" href="https://www.google.com/maps?q=Philippines" target="_blank">
                                <iframe id="incidentMap" src="https://www.google.com/maps?q=Philippines&output=embed"
                                    width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy">
                                </iframe>
                            </a>
                        </div>
                    </div>

                    <div class="modal-footer mt-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
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
