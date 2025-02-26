<x-app-layout>
    <h1>Emergency Index</h1>
    <div class="table-responsive">
        <table class="table table-custom">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Role</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td data-label="#">1</td>
                    <td data-label="Name">Alice</td>
                    <td data-label="Role">Designer</td>
                    <td data-label="Status" class="status-active">Active</td>
                </tr>
                <tr>
                    <td data-label="#">2</td>
                    <td data-label="Name">Bob</td>
                    <td data-label="Role">Developer</td>
                    <td data-label="Status" class="status-inactive">Inactive</td>
                </tr>
                <tr>
                    <td data-label="#">3</td>
                    <td data-label="Name">Charlie</td>
                    <td data-label="Role">Manager</td>
                    <td data-label="Status" class="status-active">Active</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Reusable Pagination -->
    <nav aria-label="Table pagination" class="pagination-custom">
        <ul class="pagination">
            <li class="page-item disabled">
                <a class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo; Prev</span>
                </a>
            </li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Next">
                    <span aria-hidden="true">Next &raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</x-app-layout>
