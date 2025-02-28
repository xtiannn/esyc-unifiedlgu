<x-app-layout>
    <div class="row">
        <div class="col-md-10">
            <h1>User Management</h1>
        </div>
        <div class="col-md-2">
            <button type="button" role="button" class="btn btn-success mt-2" data-bs-toggle="modal"
                data-bs-target="#addUserModal">
                <i class="fa fa-user-plus mr-2"></i>
                Add User
            </button>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-custom">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Role</th>
                    <th scope="col">Date Created</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
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
                @endforeach
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

    @include('users.modals.addUser');



</x-app-layout>
