<x-app-layout>
    @section('title', 'Notifications')

    <h1 class="text-2xl font-bold mb-4">All Notifications</h1>

    @php
        $unreadCount = $notifications->where('is_read', false)->count();
    @endphp

    <div class="flex items-center justify-between mb-3">
        <span class="font-semibold text-gray-700">
            {{ $notifications->count() }} Notification{{ $notifications->count() === 1 ? '' : 's' }}
        </span>
        @if ($unreadCount > 0)
            <span class="inline-flex items-center rounded-full bg-blue-500 text-white text-xs px-2 py-1">
                {{ $unreadCount }} Unread
            </span>
        @endif
    </div>

    <div class="border rounded shadow-sm p-4 max-h-[70vh] overflow-y-auto space-y-3">
        @foreach ($notifications as $notification)
            <div id="notification-{{ $notification->id }}"
                class="notification-card p-3 border rounded cursor-pointer transition duration-150 ease-in-out
                {{ $notification->is_read ? 'bg-gray-100' : 'bg-gray-200 hover:bg-gray-300' }}"
                onclick="showNotificationModal({{ $notification->id }}, {{ $notification->is_read ? 'true' : 'false' }})">

                <p class="font-semibold truncate {{ $notification->is_read ? 'text-black' : 'text-black font-bold' }}">
                    {{ $notification->title ?? 'No Title' }}
                </p>

                <p class="text-sm truncate {{ $notification->is_read ? 'text-gray-600' : 'text-gray-700' }}">
                    {{ Str::limit($notification->message ?? 'No message', 50) }}
                </p>

                <p class="text-xs {{ $notification->is_read ? 'text-gray-400' : 'text-gray-500' }}">
                    Status: {{ $notification->is_read ? 'Read' : 'Unread' }}
                </p>
            </div>
        @endforeach
    </div>

    <style>
        /* General Notification Card Styles */
        .notification-card {
            padding: 0.75rem;
            /* Reduced padding for compact look */
            border-radius: 0.375rem;
            /* Slightly rounded corners */
            transition: background-color 0.2s ease-in-out;
            /* Smooth background color transition */
        }

        .notification-card p {
            margin-bottom: 0.25rem;
            /* Reduced space between text elements */
        }

        /* Background Colors for Read and Unread Notifications */
        .notification-card.bg-gray-200 {
            background-color: #f3f4f6;
            /* Light gray for unread */
        }

        .notification-card.bg-gray-100 {
            background-color: #f9fafb;
            /* Very light gray for read */
        }

        /* Cleaner text color handling */
        .notification-card .font-bold {
            font-weight: bold;
        }

        .max-h-\[70vh\] {
            max-height: 70vh;
            overflow-y: auto;
            scroll-behavior: smooth;
        }
    </style>

    <script>
        function toTitleCase(str) {
            return str.toLowerCase()
                .split(' ')
                .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                .join(' ');
        }

        function showNotificationModal(id, isRead) {
            const notificationElement = document.getElementById(`notification-${id}`);

            if (!isRead) {
                notificationElement.classList.add('bg-gray-100');
                notificationElement.classList.remove('bg-gray-200');
                notificationElement.querySelector('.text-gray-500').innerText = 'Status: Read';
                notificationElement.querySelector('.font-bold').classList.remove('font-bold');

                fetch(`/notifications/${id}/mark-as-read`, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            _token: '{{ csrf_token() }}'
                        })
                    })
                    .then(response => {
                        if (!response.ok) throw new Error(`Failed to mark as read: ${response.status}`);
                        return response.json();
                    })
                    .then(data => {
                        console.log(data.message);
                    })
                    .catch(err => {
                        console.error('Error marking notification as read:', err);
                    });
            }

            fetch(`/notifications/${id}/details`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) throw new Error(`Failed To Fetch Notification: ${response.status}`);
                    return response.json();
                })
                .then(notif => {
                    document.getElementById('modalNotifMessage').innerText = notif.message ?
                        toTitleCase(notif.message) :
                        'No Message';

                    document.getElementById('modalNotifType').innerText = notif.type ?
                        toTitleCase(notif.type) :
                        'General';

                    document.getElementById('modalNotifStatus').innerText = notif.status ?
                        toTitleCase(notif.status) :
                        'Pending';

                    document.getElementById('modalNotifReporterContact').innerText = notif.contact_number ?
                        toTitleCase(notif.contact_number) :
                        '-';

                    document.getElementById('modalNotifTimestamp').innerText = notif.created_at ?
                        new Date(notif.created_at).toLocaleString() :
                        'N/A';

                    const reporterName = notif.reported_by ?
                        toTitleCase([notif.reported_by.first_name ?? '', notif.reported_by.middle_name ?? '', notif
                            .reported_by.last_name ?? ''
                        ].join(' ').trim()) :
                        'N/A';
                    document.getElementById('modalNotifReporter').innerText = reporterName;

                    document.getElementById('modalNotifLatitude').innerText = notif.latitude ?? 'N/A';
                    document.getElementById('modalNotifLongitude').innerText = notif.longitude ?? 'N/A';

                    const locationContainer = document.getElementById('modalNotifLocation');
                    locationContainer.innerHTML = '';

                    if (notif.latitude && notif.longitude) {
                        const locationLink = document.createElement('a');
                        locationLink.href = `https://www.google.com/maps?q=${notif.latitude},${notif.longitude}`;
                        locationLink.target = '_blank';
                        locationLink.textContent = 'View on Map';
                        locationLink.style.color = '#007bff';
                        locationLink.style.textDecoration = 'underline';
                        locationContainer.appendChild(locationLink);
                    } else {
                        locationContainer.innerText = 'Coordinates Not Available';
                    }

                    $('#notifModal').modal('show');
                })
                .catch(err => {
                    console.error('Error Fetching Notification:', err);
                    alert('Failed To Load Notification Details.');
                });
        }
    </script>
</x-app-layout>
