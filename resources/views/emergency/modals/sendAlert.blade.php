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

                    <div class="row g-1 mb-3">
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input type="text"
                                    class="form-control form-control-sm @error('title') is-invalid @enderror"
                                    id="title" name="title" value="{{ old('title') }}" placeholder="Alert Title"
                                    required>
                                <label for="title">Alert Title</label>
                            </div>
                        </div>
                    </div>

                    <div class="row g-1 mb-3">
                        <div class="col-md-12">
                            <div class="form-floating">
                                <textarea class="form-control form-control-sm @error('message') is-invalid @enderror" id="message" name="message"
                                    placeholder="Alert Message" style="height: 100px" required>{{ old('message') }}</textarea>
                                <label for="message">Alert Message</label>
                            </div>
                        </div>
                    </div>


                    <div class="row g-1 mb-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select form-select-sm @error('media_type') is-invalid @enderror"
                                    id="media_type" name="media_type" required>
                                    <option value="" disabled {{ old('media_type') ? '' : 'selected' }}>Select...
                                    </option>
                                    <option value="image" {{ old('media_type') === 'image' ? 'selected' : '' }}>Image
                                    </option>
                                    <option value="video" {{ old('media_type') === 'video' ? 'selected' : '' }}>Video
                                    </option>
                                </select>
                                <label for="media_type">Media Type</label>
                            </div>
                        </div>
                        <div class="col-md-6" id="media_upload_group">
                            <div class="form-floating">
                                <input type="file" style="border: 0.5px solid rgb(199, 199, 199);"
                                    class="form-control form-control-sm @error('media') is-invalid @enderror"
                                    id="media" name="media">
                                <label for="media">Upload Media</label>
                                <small class="text-muted" id="media_hint" style="font-size: 12px;"></small>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer mt-2">
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

        mediaUploadGroup.style.display = 'block';
    });
</script>
