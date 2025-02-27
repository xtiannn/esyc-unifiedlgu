<x-app-layout>
<<<<<<< HEAD
    <!-- Header with Add Button -->
    <div class="header-container">
        <h3>Emergency Index</h3>
        <!-- Search Bar -->
        <input type="text" class="search-input" placeholder="Search by name or role...">
        <button class="btn btn-custom">Add New</button>
    </div>

    <!-- Table -->
=======
    <div class="row">
        <div class="col-md-10">
            <h1>Emergency Alerts</h1>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-warning mt-2" data-bs-toggle="modal" data-bs-target="#sendAlertModal">
                <i class="fa fa-bell mr-2"></i> Send Alert
            </button>
        </div>
    </div>
>>>>>>> 8904025fcd6494ccd2966d40dc6125619d48c052
    <div class="table-responsive">
        <table class="table table-custom">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Role</th>
<<<<<<< HEAD
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td data-label="#">1</td>
                    <td data-label="Name">Alice</td>
                    <td data-label="Role">Designer</td>
                    <td data-label="Status" class="status-active">Active</td>
                    <td data-label="Action">
                        <div class="dropdown">
                            <button class="action-btn" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">⋮</button>
                            <ul class="dropdown-menu dropdown-menu-custom">
                                <li><a class="dropdown-item" href="#">Edit</a></li>
                                <li><a class="dropdown-item text-danger" href="#">Delete</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td data-label="#">2</td>
                    <td data-label="Name">Bob</td>
                    <td data-label="Role">Developer</td>
                    <td data-label="Status" class="status-inactive">Inactive</td>
                    <td data-label="Action">
                        <div class="dropdown">
                            <button class="action-btn" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">⋮</button>
                            <ul class="dropdown-menu dropdown-menu-custom">
                                <li><a class="dropdown-item" href="#">Edit</a></li>
                                <li><a class="dropdown-item text-danger" href="#">Delete</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td data-label="#">3</td>
                    <td data-label="Name">Charlie</td>
                    <td data-label="Role">Manager</td>
                    <td data-label="Status" class="status-active">Active</td>
                    <td data-label="Action">
                        <div class="dropdown">
                            <button class="btn btn-link text-primary p-0" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">⋮</button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Edit</a></li>
                                <li><a class="dropdown-item text-danger" href="#">Delete</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
=======
                    <th scope="col">Date Created</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                {{-- @foreach ($users as $user)
                    <tr>
                        <td data-label="#">{{ $loop->iteration }}.</td>
                        <td data-label="Name">{{ $user->name }}</td>
                        <td data-label="Email">{{ $user->email }}</td>
                        <td data-label="Role">{{ $user->role }}</td>
                        <td data-label="DateCreated">{{ $user->created_at->format('F j, Y g:i A') }}</td>
                        <td data-label="Action">
                            <button class="btn btn-primary btn-sm editUserBtn"
                                data-id="{{ $user->id }}"
                                data-name="{{ $user->name }}"
                                data-email="{{ $user->email }}"
                                data-role="{{ $user->role }}"
                                data-bs-toggle="modal"
                                data-bs-target="#editUserModal">
                                <i class="fa fa-edit"></i>
                            </button>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Your are about to delete user')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach --}}
>>>>>>> 8904025fcd6494ccd2966d40dc6125619d48c052
            </tbody>
        </table>
    </div>

<<<<<<< HEAD
    <!-- Reusable Pagination -->
    <nav aria-label="Table pagination" class="pagination-custom">
        <ul class="pagination">
            <li class="page-item disabled">
                <a class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">« Prev</span>
                </a>
            </li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Next">
                    <span aria-hidden="true">Next »</span>
                </a>
            </li>
        </ul>
    </nav>
=======

    {{-- @include('users.modals.addUser'); --}}



>>>>>>> 8904025fcd6494ccd2966d40dc6125619d48c052
</x-app-layout>
