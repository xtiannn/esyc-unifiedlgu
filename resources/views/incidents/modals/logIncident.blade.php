<!-- Log Incident Modal -->
<div class="modal fade" id="logIncidentModal" tabindex="-1" aria-labelledby="logIncidentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
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

                    <!-- Incident Type -->
                    <div class="mb-3">
                        <label for="incident_type" class="form-label">Incident Type (e.g., Fire, Flood)</label>
                        <input type="text" class="form-control" id="incident_type" name="incident_type" required>
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>

                    <!-- Location (Google Maps) -->
                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" class="form-control" id="location" name="location"
                            placeholder="Enter location or click the map" required>
                        <div id="map" style="height: 300px; margin-top: 10px;"></div>
                    </div>

                    <!-- Media Type Dropdown -->
                    <div class="mb-3">
                        <label for="media_type" class="form-label">Media Type</label>
                        <select class="form-control" id="media_type" name="media_type" required>
                            <option selected disabled>Select Media Type</option>
                            <option value="image">Image</option>
                            <option value="video">Video</option>
                        </select>
                    </div>

                    <!-- Media Upload -->
                    <div class="mb-3" id="media_upload_group" style="display: none;">
                        <label for="media" class="form-label">Upload Media</label>
                        <input type="file" class="form-control" id="media" name="media">
                        <small id="media_hint" class="text-muted"></small>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Submit Incident</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function initMap() {
        if (!document.getElementById('map')) {
            console.error("Map container not found!");
            return;
        }

        let defaultLocation = {
            lat: 14.5995,
            lng: 120.9842
        }; // Default: Manila
        let map = new google.maps.Map(document.getElementById('map'), {
            center: defaultLocation,
            zoom: 12
        });

        let marker = new google.maps.Marker({
            position: defaultLocation,
            map: map,
            draggable: true
        });

        // Update input field on marker drag
        marker.addListener('dragend', function(event) {
            document.getElementById('location').value = event.latLng.lat() + ', ' + event.latLng.lng();
        });

        // Update marker & input on map click
        map.addListener('click', function(event) {
            marker.setPosition(event.latLng);
            document.getElementById('location').value = event.latLng.lat() + ', ' + event.latLng.lng();
        });
    }
</script>

<!-- Google Maps API (Ensure API Key is correct) -->
<script async defer src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap"></script>
