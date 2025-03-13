<style>
    .announcement-container {
        overflow: hidden;
        white-space: nowrap;
        width: 200px;
        /* Adjust width as needed */
        position: relative;
    }

    .announcement-content {
        display: inline-block;
        animation: scrollText 20s linear infinite;
        /* Slow down by increasing time */
    }

    @keyframes scrollText {
        from {
            transform: translateX(100%);
        }

        to {
            transform: translateX(-100%);
        }
    }
</style>

<nav class="topnav navbar navbar-light">

    <button type="button" class="navbar-toggler text-muted mt-2 p-0 mr-3 collapseSidebar">
        <i class="fe fe-menu navbar-toggler-icon"></i>
    </button>

    <!-- Announcement Section (Now at the Start) -->
    <ul class="nav">
        <li class="nav-item d-flex align-items-center p-2 rounded" style="background-color: #ebebeb; min-width: 300px;">
            <span class="text-dark font-weight-bold mr-2">📢 Announcement:</span>
            <div class="announcement-container">
                <div class="announcement-content">
                    {{ $announcement->message ?? 'No announcements at the moment.' }}
                </div>
            </div>
        </li>
    </ul>






    <ul class="nav ml-auto">
        <!-- Date & Time Display -->
        <li class="nav-item d-flex align-items-center">
            <i class="fe fe-clock text-muted text-white mr-2"></i>
            <span id="datetime-display" class="text-muted font-weight-bold text-white mr-3"
                style="font-size: 14px;"></span>
        </li>

        <!-- Chat Icon -->
        <li class="nav-item">
            <section class="nav-link text-muted my-2 circle-icon" href="#" data-toggle="modal"
                data-target=".modal-shortcut">
                <span class="fe fe-message-circle fe-16"></span>
            </section>
        </li>

        <!-- Notifications -->
        <li class="nav-item nav-notif dropdown">
            <section class="nav-link text-muted my-2 circle-icon" href="#" id="notifDropdown"
                data-toggle="dropdown">
                <span class="fe fe-bell fe-16"></span>
                <span id="notification-count"
                    style="
                        position: absolute;
                        top: 12px; right: 5px;
                        font-size:13px; color: white;
                        background-color: red;
                        width:15px;
                        height: 15px;
                        display: none;
                        justify-content: center;
                        align-items: center;
                        border-radius: 50px;">
                </span>
            </section>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notifDropdown" style="min-width: 300px;">
                <div class="dropdown-header font-weight-bold">Recent Announcements</div>
                <ul id="notification-list" class="list-unstyled mb-0">
                    <li class="dropdown-item text-center text-muted">No new announcements</li>
                </ul>
            </div>
        </li>


        <!-- Profile Dropdown -->
        <li class="nav-item dropdown">
            <span class="nav-link text-muted pr-0 avatar-icon" href="#" id="navbarDropdownMenuLink" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="avatar avatar-sm mt-2">
                    <div class="avatar-img rounded-circle avatar-initials-min text-center position-relative">
                        <img src="{{ Auth::user()->profile_picture ? asset(Auth::user()->profile_picture) : asset('assets/images/avatar.png') }}"
                            alt="User Avatar">
                    </div>
                </span>
            </span>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item editUserBtn" href="{{ route('profile.index') }}">
                    <i class="fe fe-user"></i> Profile
                </a>

                {{-- <a class="dropdown-item" href="#"><i class="fe fe-settings"></i> Settings</a> --}}
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="dropdown-item text-danger" type="submit">
                        <i class="fe fe-log-out"></i> Log Out
                    </button>
                </form>
            </div>
        </li>
    </ul>
</nav>

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

    function fetchAnnouncements() {
        fetch("{{ route('announcements.fetch') }}")
            .then(response => response.json())
            .then(data => {
                let notificationList = document.getElementById("notification-list");
                let notificationCount = document.getElementById("notification-count");

                notificationList.innerHTML = ""; // Clear old notifications

                if (data.count > 0) {
                    data.announcements.forEach(announcement => {
                        let notifItem = document.createElement("li");
                        notifItem.classList.add("dropdown-item");
                        notifItem.innerHTML = `
                            <i class="fe fe-bell text-warning"></i>
                            <strong>${announcement.title}:</strong> ${announcement.message}
                            <small class="d-block text-muted">${announcement.time}</small>
                        `;
                        notificationList.appendChild(notifItem);
                    });

                    // Update Notification Count
                    notificationCount.innerText = data.count;
                    notificationCount.style.display = "flex";
                } else {
                    notificationList.innerHTML =
                        `<li class="dropdown-item text-center text-muted">No new announcements</li>`;
                    notificationCount.style.display = "none";
                }
            })
            .catch(error => console.error("Error fetching announcements:", error));
    }

    // Fetch announcements every 10 seconds
    setInterval(fetchAnnouncements, 10000);
    fetchAnnouncements(); // Initial load
</script>
