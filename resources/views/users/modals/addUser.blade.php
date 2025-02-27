<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fw-bolder" id="addUserModalLabel" style="font-size: 25px">Add New User</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-control" id="role" name="role" style="height: 40px">
                            <option selected disabled>Select Role</option>
                            <option value="Admin">Admin</option>
                            <option value="User">User</option>
                        </select>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fa fa-times-circle"></i> Cancel

                            </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




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

                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email" required>
                    </div>

                    {{-- <div class="mb-3">
                        <label for="edit_password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="edit_password" name="password">
                        </div>
                    </div> --}}

                    <div class="mb-3">
                        <label for="edit_role" class="form-label">Role</label>
                        <select class="form-control" id="edit_role" name="role" style="height: 40px">
                            <option value="Admin" {{ old('role', $user->role) == 'Admin' ? 'selected' : '' }}>Admin</option>
                            <option value="User" {{ old('role', $user->role) == 'User' ? 'selected' : '' }}>User</option>
                        </select>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fa fa-times-circle"></i>
                            Cancel
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
    document.addEventListener("DOMContentLoaded", function () {

        document.querySelectorAll(".editUserBtn").forEach(button => {
            button.addEventListener("click", function () {
                let userId = this.getAttribute("data-id");
                let userName = this.getAttribute("data-name");
                let userEmail = this.getAttribute("data-email");
                let userRole = this.getAttribute("data-role"); // Ensure the role is captured

                document.getElementById("editUserForm").action = `/users/${userId}`;
                document.getElementById("edit_name").value = userName;
                document.getElementById("edit_email").value = userEmail;

                // Set the selected role in dropdown
                let roleDropdown = document.getElementById("edit_role");
                if (roleDropdown) {
                    for (let option of roleDropdown.options) {
                        if (option.value === userRole) {
                            option.selected = true;
                            break;
                        }
                    }
                }
            });
        })

        // Show/Hide Password Toggle
        document.querySelectorAll(".toggle-password").forEach(button => {
            button.addEventListener("click", function () {
                let targetId = this.getAttribute("data-target");
                let targetInput = document.getElementById(targetId);
                if (targetInput.type === "password") {
                    targetInput.type = "text";
                    this.innerHTML = '<i class="fa fa-eye-slash"></i>';
                } else {
                    targetInput.type = "password";
                    this.innerHTML = '<i class="fa fa-eye"></i>';
                }
            });
        });
    });
</script>
