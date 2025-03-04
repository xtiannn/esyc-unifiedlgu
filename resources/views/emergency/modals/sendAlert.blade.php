<!-- Send Alert Modal -->
<div class="modal fade" id="sendAlertModal" tabindex="-1" aria-labelledby="sendAlertModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fw-bolder" id="sendAlertModalLabel" style="font-size: 25px">Send Emergency Alert
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('emergency.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Media Type Dropdown (First) -->
                    <div class="mb-3">
                        <label for="media_type" class="form-label">Media Type</label>
                        <select class="form-control" id="media_type" name="media_type" required>
                            <option selected disabled>Select Media Type</option>
                            <option value="image">Image</option>
                            <option value="video">Video</option>
                        </select>
                    </div>

                    <!-- File Upload (Dynamic) -->
                    <div class="mb-3" id="media_upload_group" style="display: none;">
                        <label for="media" class="form-label">Upload Media</label>
                        <input type="file" class="form-control" id="media" name="media">
                        <small class="text-muted" id="media_hint" style="font-size: 12px;"></small>

                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label">Alert Title</label>
                        <input type="text" class="form-control" id="title" name="title"
                            value="{{ old('title') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="message" class="form-label">Alert Message</label>
                        <textarea class="form-control" id="message" name="message" rows="3" required>{{ old('message') }}</textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fa fa-times-circle"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fa fa-bell"></i> Send Alert
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Dynamic File Upload -->
<script>
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

        mediaUploadGroup.style.display = 'block'; // Show file upload field
    });
</script>
