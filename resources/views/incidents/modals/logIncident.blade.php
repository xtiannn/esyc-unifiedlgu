{{-- resources\views\incidents\modals\logIncident.blade.php --}}


<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

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

    #map {
        height: 350px;
        border: 1px solid #ccc;
        border-radius: 10px;
    }
</style>

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

                        <!-- Right Column: Search + Map -->
                        <div class="col-md-6">
                            <div class="form-floating">

                                <div id="map" style="height: 350px; border: 1px solid #ccc; border-radius: 10px;">
                                </div>

                                <input type="hidden" id="lat" name="latitude">
                                <input type="hidden" id="lng" name="longitude">
                            </div>
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



<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>


<script>
    const pasongTamoBounds = [
        [14.675, 121.036], // South-West corner (Lat, Lng)
        [14.688, 121.047] // North-East corner (Lat, Lng)
    ];

    // Create a lat/lng bounds object
    const bounds = L.latLngBounds(pasongTamoBounds);

    // Initialize the map with the new boundaries
    const map = L.map('map', {
        center: [14.681022719649997, 121.04141588677145], // Initial center in Pasong Tamo
        zoom: 15, // Set a default zoom level
        maxBounds: bounds, // Restrict map view within these bounds
        maxBoundsViscosity: 1.0, // Prevent the map from moving out of bounds
        minZoom: 15, // Set the minimum zoom level (avoid zooming out too far)
        // maxZoom: 18 // Set the maximum zoom level (if needed, adjust as necessary)
        attributionControl: false
    });

    // Tile Layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Handle map click to place/move marker within Pasong Tamo bounds
    let marker;

    map.on('click', function(e) {
        const lat = e.latlng.lat;
        const lng = e.latlng.lng;

        // Check if clicked location is within Pasong Tamo bounds
        if (bounds.contains([lat, lng])) {
            if (marker) {
                marker.setLatLng([lat, lng]);
            } else {
                marker = L.marker([lat, lng]).addTo(map);
            }

            document.getElementById('lat').value = lat;
            document.getElementById('lng').value = lng;
        } else {
            alert("Please select a location within Pasong Tamo.");
        }
    });

    // Invalidate map size when modal shows (necessary for map resizing on modal open)
    const modal = document.getElementById('logIncidentModal');
    modal.addEventListener('shown.bs.modal', function() {
        setTimeout(() => {
            map.invalidateSize();
        }, 800);
    });

    // Add Geocoder control (search icon on map)
    L.Control.geocoder({
            defaultMarkGeocode: false
        })
        .on('markgeocode', function(e) {
            const center = e.geocode.center;

            // Check if the geocoded location is within Pasong Tamo bounds
            if (bounds.contains(center)) {
                map.setView(center, 15);

                if (marker) {
                    marker.setLatLng(center);
                } else {
                    marker = L.marker(center).addTo(map);
                }

                document.getElementById('lat').value = center.lat;
                document.getElementById('lng').value = center.lng;
            } else {
                alert("Location is outside the Pasong Tamo area.");
            }
        })
        .addTo(map);

    // Function to check if the location is near the boundaries of Pasong Tamo
    function isNearby(lat, lon) {
        const bufferDistance = 0.0005; // Small buffer zone in degrees (around 50 meters)
        const boundsExtended = L.latLngBounds(
            [pasongTamoBounds[0][0] - bufferDistance, pasongTamoBounds[0][1] - bufferDistance],
            [pasongTamoBounds[1][0] + bufferDistance, pasongTamoBounds[1][1] + bufferDistance]
        );
        return boundsExtended.contains([lat, lon]);
    }

    // Remove the search event listeners
    // No longer needed, as search is handled by geocoder on map
</script>
