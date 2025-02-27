<x-app-layout>
    <!-- Header with Add Button -->
    <div class="header-container">
        <h3>Emergency Index</h3>
        <!-- Search Bar -->
        <input type="text" class="search-input" placeholder="Search by name or role...">
        <button class="btn btn-custom">Add New</button>
    </div>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-custom">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Role</th>
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
            </tbody>
        </table>
    </div>

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
</x-app-layout>
