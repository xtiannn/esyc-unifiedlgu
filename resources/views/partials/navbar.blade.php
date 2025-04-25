{{-- resources\views\partials\navbar.blade.php --}}
<style>
    .topnav .nav {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .announcement-container {
        overflow: hidden;
        white-space: nowrap;
        max-width: 300px;
        position: relative;
    }

    .announcement-content {
        display: inline-block;
        animation: scrollText 20s linear infinite;
        font-weight: 500;
        color: #333;
    }

    @keyframes scrollText {
        from {
            transform: translateX(100%);
        }

        to {
            transform: translateX(-100%);
        }
    }

    .announcement-box {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background-color: #f1f1f1;
        padding: 6px 12px;
        border-radius: 8px;
        min-width: 320px;
        max-width: 400px;
        overflow: hidden;
    }

    .dropdown-menu.dropdown-menu-lg {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: none;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        padding: 0.75rem 0;
        overflow: hidden;
        scrollbar-width: thin;
        scrollbar-color: #ccc transparent;
    }

    .dropdown-menu.dropdown-menu-lg::-webkit-scrollbar {
        width: 6px;
    }

    .dropdown-menu.dropdown-menu-lg::-webkit-scrollbar-thumb {
        background-color: #ccc;
        border-radius: 10px;
    }

    .dropdown-header {
        font-size: 14px;
        font-weight: 600;
        color: #495057;
        padding: 0.75rem 1.25rem;
        border-bottom: 1px solid #dee2e6;
    }

    .notification-item {
        display: flex;
        gap: 0.75rem;
        padding: 12px 16px;
        transition: background 0.2s ease;
        border-bottom: 1px solid #f1f1f1;
    }

    .notification-item:last-child {
        border-bottom: none;
    }

    .notification-item:hover {
        background-color: #f9f9f9;
        cursor: pointer;
    }

    .notif-icon {
        min-width: 36px;
        height: 36px;
        font-size: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #e9f3ff;
        color: #007bff;
        border-radius: 50%;
    }

    .notification-item .flex-grow-1 {
        display: flex;
        flex-direction: column;
    }

    .notification-item .font-weight-bold {
        font-size: 13px;
        color: #212529;
    }

    .notification-item .text-muted {
        font-size: 12px;
        color: #6c757d;
    }

    a.dropdown-item.text-center.text-primary {
        font-weight: 600;
        padding: 12px;
        font-size: 14px;
        color: #0d6efd;
        transition: background 0.2s;
    }

    a.dropdown-item.text-center.text-primary:hover {
        background-color: #f0f8ff;
    }

    #notif-list {
        background-color: #fff;
    }

    #unread-count {
        position: absolute;
        top: 2px;
        right: 2px;
        min-width: 14px;
        height: 14px;
        padding: 0 4px;
        font-size: 9px;
        font-weight: 600;
        line-height: 14px;
        border-radius: 9999px;
        background-color: #dc3545;
        color: #fff;
        display: inline-block;
        text-align: center;
        box-shadow: 0 0 0 1.5px #fff;
    }


    .avatar-img img {
        width: 36px;
        height: 36px;
        object-fit: cover;
        border-radius: 50%;
    }

    .modal-content {
        border-radius: 15px;
        padding: 2rem;
        background-color: #f8f9fa;
    }

    .modal-header {
        border-bottom: none;
    }

    .modal-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #343a40;
    }

    .incident-info {
        font-size: 14px;
        color: #495057;
    }

    .incident-info .d-flex {
        padding: 0.5rem 0;
        border-bottom: 1px solid #dee2e6;
    }

    .incident-info .font-weight-bold {
        font-size: 15px;
        color: #6c757d;
    }

    .incident-info .text-dark {
        font-size: 14px;
        font-weight: 500;
    }

    #modalNotifLink {
        font-weight: 600;
        text-align: center;
        padding: 0.5rem 1.5rem;
        background-color: #007bff;
        color: white;
        border-radius: 50px;
        text-decoration: none;
    }

    #modalNotifLink:hover {
        background-color: #0056b3;
        color: white;
    }

    #modalNotifLocationContainer {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
    }

    .notification-item.read {
        background-color: #f1f1f1;
        /* Lighter background for read notifications */
        opacity: 0.6;
        /* Optional: Reduce opacity to show it's read */
    }
</style>


<!-- Top Nav -->
<nav class="topnav navbar navbar-light">

    <button type="button" class="navbar-toggler text-muted mt-2 p-0 mr-3 collapseSidebar">
        <i class="fe fe-menu navbar-toggler-icon"></i>
    </button>

    <!-- Left Nav -->
    <ul class="nav">
        <!-- Announcement -->
        <li class="nav-item announcement-box">
            <span class="text-dark font-weight-bold">📢</span>
            <div class="announcement-container">
                <div class="announcement-content">
                    {{ $announcement->message ?? 'No announcements at the moment.' }}
                </div>
            </div>
        </li>
    </ul>

    <!-- Right Nav -->
    <ul class="nav ml-auto">
        <!-- Date & Time -->
        <li class="nav-item d-flex align-items-center">
            <i class="fe fe-clock text-white mr-2"></i>
            <span id="datetime-display" class="text-white font-weight-bold" style="font-size: 14px;"></span>
        </li>

        <!-- Chat -->
        <li class="nav-item">
            <a class="nav-link text-muted my-2 circle-icon" href="{{ route('chat') }}">
                <span class="fe fe-message-circle fe-16"></span>
            </a>
        </li>

        <!-- Notifications -->
        <li class="nav-item nav-notif dropdown">
            <a class="nav-link text-muted my-2 circle-icon position-relative" href="#" id="notifDropdown"
                role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="fe fe-bell fe-16"></span>
                <span class="badge badge-pill badge-danger" id="unread-count">0</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg" aria-labelledby="notifDropdown"
                style="min-width: 300px; max-height: 400px; overflow-y: auto;">
                <h6 class="dropdown-header">Notifications</h6>
                <div id="notif-list">
                    <p class="dropdown-item text-muted mb-0">Loading notifications...</p>
                </div>
                <div class="dropdown-divider"></div>
                <a href="{{ route('notifications.index') }}" class="dropdown-item text-center text-primary">View All</a>
            </div>
        </li>

        <!-- Profile -->
        <li class="nav-item dropdown">
            <span class="nav-link text-muted pr-0 avatar-icon" id="navbarDropdownMenuLink" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="avatar avatar-sm mt-2">
                    <div class="avatar-img rounded-circle avatar-initials-min text-center position-relative">
                        <img src="{{ Auth::user()->profile_picture ? asset(Auth::user()->profile_picture) : asset('assets/images/avatar.png') }}"
                            alt="User Avatar">
                    </div>
                </span>
            </span>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item editUserBtn" href="https://smartbarangayconnect.com/profile.php">
                    <i class="fe fe-user"></i> Profile
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="dropdown-item text-danger">
                    <i class="fe fe-log-out"></i> Log Out
                </a>

            </div>
        </li>
    </ul>
</nav>


<!-- Notification Modal -->
<div class="modal fade" id="notifModal" tabindex="-1" role="dialog" aria-labelledby="notifModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notifModalLabel">Incident Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Incident Title -->
                <h6 id="modalNotifTitle" class="font-weight-bold mb-3 text-primary d-none">Loading...</h6>

                <!-- Incident Info -->
                <div class="incident-info">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="font-weight-bold text-muted">Type:</span>
                        <span id="modalNotifType" class="text-dark">Loading...</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="font-weight-bold text-muted">Description:</span>
                        <span id="modalNotifMessage" class="text-dark">Loading...</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="font-weight-bold text-muted">Reported By:</span>
                        <span id="modalNotifReporter" class="text-dark">Loading...</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="font-weight-bold text-muted">Reporter's Contact:</span>
                        <span id="modalNotifReporterContact" class="text-dark">Loading...</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="font-weight-bold text-muted">Status:</span>
                        <span id="modalNotifStatus" class="text-dark">Loading...</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="font-weight-bold text-muted">Date:</span>
                        <span id="modalNotifTimestamp" class="text-dark">Loading...</span>
                    </div>

                    <!-- Location -->
                    <div class="d-flex justify-content-between mb-2" id="modalNotifLocationContainer">
                        <span class="font-weight-bold text-muted">Location:</span>
                        <span id="modalNotifLocation" class="text-dark">Loading...</span>
                    </div>

                    <!-- Coordinates -->
                    <div class="d-flex justify-content-between mb-2">
                        <span class="font-weight-bold text-muted">Latitude:</span>
                        <span id="modalNotifLatitude" class="text-dark">N/A</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="font-weight-bold text-muted">Longitude:</span>
                        <span id="modalNotifLongitude" class="text-dark">N/A</span>
                    </div>
                </div>

                <!-- Link To View Full Incident -->
                <div class="d-flex justify-content-center mt-4">
                    <a href="#" id="modalNotifLink" class="btn btn-outline-primary d-none" target="_blank">
                        View Full Incident
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>






<script>
    function updateDateTime() {
        let now = new Date();
        let options = {
            weekday: 'short',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        };
        document.getElementById('datetime-display').innerText = now.toLocaleDateString('en-US', options);
    }
    setInterval(updateDateTime, 1000);
    updateDateTime();

    // Fetch announcements every 10 seconds
    setInterval(fetchAnnouncements, 10000);
</script>


<script>
    // Helper Function: Title Case
    function toTitleCase(str) {
        return str
            .toLowerCase()
            .split(' ')
            .map(word => word.charAt(0).toUpperCase() + word.slice(1))
            .join(' ');
    }

    async function fetchNotifications() {
        try {
            const response = await fetch("{{ route('notifications.fetch') }}");
            const data = await response.json();

            const notifList = document.getElementById('notif-list');
            const unreadCount = document.getElementById('unread-count');

            notifList.innerHTML = '';

            if (data.length === 0) {
                notifList.innerHTML = '<p class="dropdown-item text-muted mb-0">No New Notifications.</p>';
                unreadCount.style.display = 'none';
                return;
            }

            data.forEach(notif => {
                const notifItem = document.createElement('div');
                notifItem.className = 'dropdown-item notification-item';
                notifItem.style.cursor = 'pointer';

                notifItem.innerHTML = `
                    <div class="d-flex align-items-start">
                        <div class="notif-icon mr-3">
                            <span class="fe fe-alert-circle text-primary"></span>
                        </div>
                        <div class="flex-grow-1">
                            <div class="font-weight-bold mb-1">${toTitleCase(notif.title)}</div>
                            <div class="small text-muted">${notif.message ? toTitleCase(notif.message) : ''}</div>
                            <div class="small text-muted mt-1">${new Date(notif.created_at).toLocaleString()}</div>
                        </div>
                    </div>
                `;

                notifItem.addEventListener('click', async () => {
                    try {
                        await fetch(`/notifications/${notif.id}/mark-as-read`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').content,
                            },
                            body: JSON.stringify({
                                is_read: 1
                            })
                        });

                        notifItem.classList.add('read');

                        const unreadCount = document.getElementById('unread-count');
                        unreadCount.innerText = Math.max(0, parseInt(unreadCount.innerText) -
                            1);
                        if (parseInt(unreadCount.innerText) === 0) {
                            unreadCount.style.display = 'none';
                        }

                        const res = await fetch(`/incident/${notif.incident_id}/data`);
                        const incident = await res.json();

                        const lat = incident.latitude;
                        const lng = incident.longitude;

                        const locationContainer = document.getElementById('modalNotifLocation');
                        locationContainer.innerHTML = '';

                        if (lat && lng) {
                            const locationLink = document.createElement('a');
                            locationLink.href = `https://www.google.com/maps?q=${lat},${lng}`;
                            locationLink.target = '_blank';
                            locationLink.textContent = 'View on Map';
                            locationLink.style.color = '#007bff';
                            locationLink.style.textDecoration = 'underline';
                            locationContainer.appendChild(locationLink);
                        } else {
                            locationContainer.innerText = 'Coordinates Not Available';
                        }

                        document.getElementById('modalNotifTitle').innerText = incident
                            .incident_type ?
                            toTitleCase(incident.incident_type) :
                            'Incident Reported';

                        document.getElementById('modalNotifMessage').innerText = incident
                            .description ?
                            toTitleCase(incident.description) :
                            'No Description Available.';

                        document.getElementById('modalNotifTimestamp').innerText = incident
                            .created_at ?
                            new Date(incident.created_at).toLocaleString() :
                            'N/A';

                        document.getElementById('modalNotifType').innerText = incident
                            .incident_type ?
                            toTitleCase(incident.incident_type) :
                            'General';

                        document.getElementById('modalNotifStatus').innerText = incident
                            .status ?
                            toTitleCase(incident.status) :
                            'Pending';

                        document.getElementById('modalNotifReporterContact').innerText =
                            incident
                            .contact_number ?
                            toTitleCase(incident.contact_number) :
                            '-';

                        const reporterName = incident.reported_by ?
                            toTitleCase([
                                incident.reported_by.first_name ?? '',
                                incident.reported_by.middle_name ?? '',
                                incident.reported_by.last_name ?? ''
                            ].join(' ').trim()) :
                            'N/A';


                        document.getElementById('modalNotifReporter').innerText = reporterName;

                        document.getElementById('modalNotifReporter').innerText = reporterName;

                        document.getElementById('modalNotifLatitude').innerText = incident
                            .latitude ?? 'Pending';
                        document.getElementById('modalNotifLongitude').innerText = incident
                            .longitude ?? 'Pending';
                        document.getElementById('modalNotifLink').href =
                            `/incidents/${incident.id}`;

                        $('#notifModal').modal('show');
                    } catch (err) {
                        console.error(
                            'Error fetching incident data or marking notification as read:',
                            err);
                    }
                });

                notifList.appendChild(notifItem);
            });

            unreadCount.innerText = data.length;
            unreadCount.style.display = data.length > 0 ? 'inline-block' : 'none';

        } catch (error) {
            console.error("Error fetching notifications:", error);
            const notifList = document.getElementById('notif-list');
            notifList.innerHTML = '<p class="dropdown-item text-muted mb-0">Error Loading Notifications.</p>';
        }
    }

    setInterval(fetchNotifications, 10000);
    fetchNotifications();
</script>
