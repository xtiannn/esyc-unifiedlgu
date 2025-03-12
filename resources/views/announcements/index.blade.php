<x-app-layout>
    @section('title', 'Announcements')

    <div class="row mb-3">
        <div class="col-md-10">
            <h1>📢 Announcements</h1>
        </div>
        <div class="col-md-2 text-end">
            <button type="button" class="btn btn-success mt-2" data-bs-toggle="modal"
                data-bs-target="#addAnnouncementModal">
                <i class="fa fa-plus mr-2"></i> Announcement
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-custom">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Message</th>
                    <th>Role</th>
                    <th>Published At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($announcements as $announcement)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $announcement->title }}</td>
                        <td>{{ Str::limit($announcement->message, 50) }}</td>
                        <td>{{ ucfirst($announcement->role) }}</td>
                        <td>{{ $announcement->created_at->format('M d, Y h:i A') }}</td>
                        <td>
                            <!-- Edit Button with Data Attributes -->
                            <button class="btn btn-primary btn-sm edit-btn" data-id="{{ $announcement->id }}"
                                data-title="{{ $announcement->title }}" data-message="{{ $announcement->message }}"
                                data-route="{{ route('announcements.update', $announcement->id) }}"
                                data-bs-toggle="modal" data-bs-target="#editAnnouncementModal">
                                <i class="fa fa-edit"></i>
                            </button>

                            @include('components.delete-button', [
                                'id' => $announcement->id,
                                'route' => route('announcements.destroy', $announcement->id),
                                'itemName' => $announcement->title,
                            ])
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Add Announcement Modal -->
    <div class="modal fade" id="addAnnouncementModal" tabindex="-1" aria-labelledby="addAnnouncementModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fw-bolder" id="addAnnouncementModalLabel" style="font-size: 25px">Add
                        Announcement
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('announcements.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control form-control-sm" id="announcement_title"
                                    name="title" placeholder="Announcement Title" required>
                                <label for="announcement_title">Title</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-floating">
                                <textarea class="form-control form-control-sm" id="announcement_message" name="message"
                                    placeholder="Enter announcement details..." style="height: 120px" required></textarea>
                                <label for="announcement_message">Message</label>
                            </div>
                        </div>

                        <div class="modal-footer mt-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fa fa-times-circle"></i> Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Save Announcement
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Announcement Modal -->
    <div class="modal fade" id="editAnnouncementModal" tabindex="-1" aria-labelledby="editAnnouncementModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fw-bolder" id="editAnnouncementModalLabel" style="font-size: 25px">Edit
                        Announcement</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editAnnouncementForm" method="POST">
                        @csrf
                        @method('PUT')

                        <input type="hidden" id="announcement_id" name="id">

                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control form-control-sm" id="edit_announcement_title"
                                    name="title" placeholder="Announcement Title" required>
                                <label for="edit_announcement_title">Title</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-floating">
                                <textarea class="form-control form-control-sm" id="edit_announcement_message" name="message"
                                    placeholder="Enter announcement details..." style="height: 120px" required></textarea>
                                <label for="edit_announcement_message">Message</label>
                            </div>
                        </div>

                        <div class="modal-footer mt-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fa fa-times-circle"></i> Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Select all edit buttons
            const editButtons = document.querySelectorAll(".edit-btn");

            editButtons.forEach(button => {
                button.addEventListener("click", function() {
                    // Get announcement data from button
                    const announcementId = this.getAttribute("data-id");
                    const title = this.getAttribute("data-title");
                    const message = this.getAttribute("data-message");
                    const route = this.getAttribute("data-route");

                    // Populate modal fields
                    document.getElementById("announcement_id").value = announcementId;
                    document.getElementById("edit_announcement_title").value = title;
                    document.getElementById("edit_announcement_message").value = message;

                    // Set form action dynamically
                    document.getElementById("editAnnouncementForm").setAttribute("action", route);
                });
            });
        });
    </script>



</x-app-layout>
