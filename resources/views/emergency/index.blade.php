<x-app-layout>
    @section('title', 'Emergency Alerts')

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
        <div class="col-md-10 mb-4">
            <h1>Emergency Alerts</h1>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger mt-2" data-bs-toggle="modal" data-bs-target="#sendAlertModal">
                <i class="fa fa-bell mr-2"></i> Send Alert
            </button>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-custom">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Media</th>
                    <th scope="col">Title</th>
                    <th scope="col">Message</th>
                    <th scope="col">Created By</th>
                    <th scope="col">Date Created</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($emergencies as $alert)
                    <tr>
                        <td data-label="#">{{ $loop->iteration }}.</td>
                        <td data-label="Media" class="media-cell">
                            @if ($alert->media_type === 'Image')
                                <a href="{{ asset('storage/' . $alert->media_path) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $alert->media_path) }}" alt="Media"
                                        class="small-image">
                                </a>
                            @elseif ($alert->media_type === 'Video')
                                <video class="media-content" controls>
                                    <source src="{{ asset('storage/' . $alert->media_path) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @else
                                No media
                            @endif
                        </td>

                        <td data-label="Title">{{ $alert->title }}</td>
                        <td data-label="Message">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#alertModal{{ $alert->id }}">
                                {{ Str::limit(Str::title($alert->message), 50, '...') }}
                            </a>
                        </td>
                        <td data-label="Created-by">{{ $alert->creator->name ?? 'Unknown' }}</td>
                        <td data-label="Date-created">{{ $alert->created_at->format('F j, Y g:i A') }}</td>
                    </tr>

                    <div class="modal fade" id="alertModal{{ $alert->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Centered & Large Modal -->
                            <div class="modal-content shadow-lg border-0">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title fw-bold">{{ $alert->title }}</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="fs-5 text-dark">{{ $alert->message }}</p>
                                    <div class="text-end mt-3">
                                        <small class="text-muted">📅 Issued at:
                                            {{ $alert->created_at->format('F j, Y g:i A') }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No data found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @include('emergency.modals.sendAlert')
</x-app-layout>
