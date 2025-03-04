<x-app-layout>
    <div class="row">
        <div class="col-md-10">
            <h1>Emergency Alerts</h1>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-success mt-2" data-bs-toggle="modal" data-bs-target="#sendAlertModal">
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
                @forelse ($emergencies as $emergency)
                    <tr>
                        <td data-label="#">{{ $loop->iteration }}.</td>
                        <td data-label="Media">
                            @if ($emergency->media_type === 'image')
                                <a href="{{ asset('storage/' . $emergency->media_path) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $emergency->media_path) }}" alt="Media"
                                        class="small-image">
                                </a>
                            @elseif ($emergency->media_type === 'video')
                                <video width="150" controls>
                                    <source src="{{ asset('storage/' . $emergency->media_path) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @else
                                No media
                            @endif
                        </td>
                        <td data-label="Title">{{ $emergency->title }}</td>
                        <td data-label="Message">{{ $emergency->message }}</td>
                        <td data-label="Created-by">{{ $emergency->creator->name ?? 'Unknown' }}</td>
                        <td data-label="Date-created">{{ $emergency->created_at->format('F j, Y g:i A') }}</td>
                    </tr>
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
