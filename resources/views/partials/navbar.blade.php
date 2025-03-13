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
                <a class="dropdown-item editUserBtn" href="#" data-bs-toggle="modal"
                    data-bs-target="#editUserModal" data-id="{{ Auth::user()->id }}"
                    data-name="{{ Auth::user()->name }}" data-email="{{ Auth::user()->email }}"
                    data-role="{{ Auth::user()->role }}" data-contact_number="{{ Auth::user()->contact_number }}"
                    data-birth_date="{{ Auth::user()->birth_date }}" data-gender="{{ Auth::user()->gender }}"
                    data-civil_status="{{ Auth::user()->civil_status }}"
                    data-occupation="{{ Auth::user()->occupation }}"
                    data-barangay_id="{{ Auth::user()->barangay_id }}" data-address="{{ Auth::user()->address }}"
                    data-household_number="{{ Auth::user()->household_number }}">
                    <i class="fe fe-user"></i> Profile
                </a>

                <a class="dropdown-item" href="#"><i class="fe fe-settings"></i> Settings</a>
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
<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fw-bolder" id="editUserModalLabel" style="font-size: 25px">Edit User</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-1">
                        <div class="col-md-6">
                            <div class="form-floating mb-1">
                                <input type="text" class="form-control" id="edit_name" name="name" required>
                                <label for="edit_name">Full Name</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-1">
                                <input type="email" class="form-control" id="edit_email" name="email" required>
                                <label for="edit_email">Email Address</label>
                            </div>
                        </div>
                    </div>

                    <div class="row g-1">
                        <div class="col-md-6">
                            <div class="form-floating mb-1">
                                <input type="text" class="form-control" id="edit_address" name="address"
                                    required>
                                <label for="edit_address">Address</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-1">
                                <input type="text" class="form-control" id="edit_contact_number"
                                    name="contact_number" required>
                                <label for="edit_contact_number">Contact Number</label>
                            </div>
                        </div>
                    </div>

                    <div class="row g-1">
                        <div class="col-md-6">
                            <div class="form-floating mb-1">
                                <input type="date" class="form-control" id="edit_birth_date" name="birth_date"
                                    required>
                                <label for="edit_birth_date">Birthdate</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-1">
                                <select class="form-select" id="edit_civil_status" name="civil_status" required>
                                    <option value="" disabled>Select...</option>
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Divorced">Divorced</option>
                                    <option value="Widowed">Widowed</option>
                                </select>
                                <label for="edit_civil_status">Civil Status</label>
                            </div>
                        </div>
                    </div>

                    <div class="row g-1">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" id="edit_gender" name="gender" required>
                                    <option value="" disabled>Select...</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                                <label for="edit_gender">Gender</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="edit_occupation" name="occupation">
                                <label for="edit_occupation">Occupation</label>
                            </div>
                        </div>
                    </div>

                    <div class="row g-1 my-1">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" id="edit_role" name="role" required>
                                    <option value="" disabled>Select...</option>
                                    <option value="Admin">Admin</option>
                                    <option value="User">User</option>
                                </select>
                                <label for="edit_role">User Role</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="edit_household_number"
                                    name="household_number" required>
                                <label for="edit_household_number">Household Number</label>
                            </div>
                        </div>
                    </div>

                    <div class="row g-1">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="edit_barangay_id" name="barangay_id"
                                    required>
                                <label for="edit_barangay_id">Barangay ID</label>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer mt-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fa fa-times-circle"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-edit"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".editUserBtn").forEach(button => {
            button.addEventListener("click", function() {
                let userId = this.getAttribute("data-id");
                document.getElementById("editUserForm").action = `/users/${userId}`;

                ["name", "email", "address", "contact_number", "birth_date", "civil_status",
                    "gender", "occupation", "role", "household_number", "barangay_id"
                ].forEach(field => {
                    let input = document.getElementById("edit_" + field);
                    if (input) input.value = this.getAttribute("data-" + field);
                });
            });
        });
    });

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
