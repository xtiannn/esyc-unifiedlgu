<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fw-bolder" id="addUserModalLabel" style="font-size: 25px">Add New User</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('users.store') }}">
                    @csrf
                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-floating mb-1">
                                <input type="text"
                                    class="form-control form-control-sm @error('first_name') is-invalid @enderror"
                                    id="first_name" name="first_name" value="{{ old('first_name') }}"
                                    placeholder="First Name" required>
                                <label for="first_name">First Name</label>
                                @error('first_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating mb-1">
                                <input type="text"
                                    class="form-control form-control-sm @error('middle_name') is-invalid @enderror"
                                    id="middle_name" name="middle_name" value="{{ old('middle_name') }}"
                                    placeholder="Middle Name">
                                <label for="middle_name">Middle Name</label>
                                @error('middle_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating mb-1">
                                <input type="text"
                                    class="form-control form-control-sm @error('last_name') is-invalid @enderror"
                                    id="last_name" name="last_name" value="{{ old('last_name') }}"
                                    placeholder="Last Name" required>
                                <label for="last_name">Last Name</label>
                                @error('last_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row g-1">
                        <div class="col-md-6">
                            <div class="form-floating mb-1">
                                <select class="form-select form-select-sm @error('sex') is-invalid @enderror"
                                    id="sex" name="sex" required>
                                    <option value="" {{ old('sex') ? '' : 'selected' }} disabled>Select...
                                    </option>
                                    <option value="MALE" {{ old('sex') === 'MALE' ? 'selected' : '' }}>Male</option>
                                    <option value="FEMALE" {{ old('sex') === 'FEMALE' ? 'selected' : '' }}>Female
                                    </option>
                                </select>
                                <label for="sex">Sex</label>
                                @error('sex')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-1">
                                <input type="email"
                                    class="form-control form-control-sm @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}"
                                    placeholder="Email Address" required>
                                <label for="email">Email Address</label>
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>


                    <div class="row g-1">
                        <div class="col-md-12">
                            <div class="form-floating mb-1">
                                <input type="text"
                                    class="form-control form-control-sm @error('address') is-invalid @enderror"
                                    id="address" name="address" value="{{ old('address') }}" placeholder="Address"
                                    required>
                                <label for="address">Address</label>
                                @error('address')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row g-1">
                        <div class="col-md-6">
                            <div class="form-floating mb-1">
                                <input type="text"
                                    class="form-control form-control-sm @error('mobile') is-invalid @enderror"
                                    id="mobile" name="mobile" value="{{ old('mobile') }}"
                                    placeholder="Contact Number" required>
                                <label for="mobile">Contact Number</label>
                                @error('mobile')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-1">
                                <input type="date"
                                    class="form-control form-control-sm @error('birth_date') is-invalid @enderror"
                                    id="birth_date" name="birth_date" value="{{ old('birth_date') }}" required>
                                <label for="birth_date">Birthdate</label>
                                @error('birth_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Additional Fields -->
                    <div class="row g-1 my-1">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select form-select-sm @error('role') is-invalid @enderror"
                                    id="role" name="role" required>
                                    <option value="" {{ old('role') ? '' : 'selected' }} disabled>Select...
                                    </option>
                                    <option value="Admin" {{ old('role') === 'Admin' ? 'selected' : '' }}>Admin
                                    </option>
                                    <option value="User" {{ old('role') === 'User' ? 'selected' : '' }}>User
                                    </option>
                                </select>
                                <label for="role">User Role</label>
                                @error('role')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text"
                                    class="form-control form-control-sm @error('occupation') is-invalid @enderror"
                                    id="occupation" name="occupation" value="{{ old('occupation') }}"
                                    placeholder="Occupation">
                                <label for="occupation">Occupation</label>
                                @error('occupation')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row g-1">
                        <div class="col-md-6">
                            <div class="form-floating mb-1">
                                <input type="password"
                                    class="form-control form-control-sm @error('password') is-invalid @enderror"
                                    id="password" name="password" placeholder="Password" required>
                                <label for="password">Password</label>
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-1">
                                <input type="password"
                                    class="form-control form-control-sm @error('password_confirmation') is-invalid @enderror"
                                    id="password_confirmation" name="password_confirmation"
                                    placeholder="Confirm Password" required>
                                <label for="password_confirmation">Confirm Password</label>
                                @error('password_confirmation')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer mt-2">
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

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-floating mb-1">
                                <input type="text"
                                    class="form-control form-control-sm @error('first_name') is-invalid @enderror"
                                    id="edit_first_name" name="first_name" required>
                                <label for="edit_first_name">First Name</label>
                                @error('first_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating mb-1">
                                <input type="text"
                                    class="form-control form-control-sm @error('middle_name') is-invalid @enderror"
                                    id="edit_middle_name" name="middle_name">
                                <label for="edit_middle_name">Middle Name</label>
                                @error('middle_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating mb-1">
                                <input type="text"
                                    class="form-control form-control-sm @error('last_name') is-invalid @enderror"
                                    id="edit_last_name" name="last_name" required>
                                <label for="edit_last_name">Last Name</label>
                                @error('last_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row g-1">
                        <div class="col-md-6">
                            <div class="form-floating mb-1">
                                <select class="form-select form-select-sm @error('sex') is-invalid @enderror"
                                    id="edit_sex" name="sex" required>
                                    <option value="" disabled>Select...</option>
                                    <option value="MALE">Male</option>
                                    <option value="FEMALE">Female</option>
                                </select>
                                <label for="edit_sex">Sex</label>
                                @error('sex')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-1">
                                <input type="email"
                                    class="form-control form-control-sm @error('email') is-invalid @enderror"
                                    id="edit_email" name="email" required>
                                <label for="edit_email">Email Address</label>
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row g-1">
                        <div class="col-md-12">
                            <div class="form-floating mb-1">
                                <input type="text"
                                    class="form-control form-control-sm @error('address') is-invalid @enderror"
                                    id="edit_address" name="address" required>
                                <label for="edit_address">Address</label>
                                @error('address')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row g-1">
                        <div class="col-md-6">
                            <div class="form-floating mb-1">
                                <input type="text"
                                    class="form-control form-control-sm @error('mobile') is-invalid @enderror"
                                    id="edit_mobile" name="mobile" required>
                                <label for="edit_mobile">Contact Number</label>
                                @error('mobile')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-1">
                                <input type="date"
                                    class="form-control form-control-sm @error('birth_date') is-invalid @enderror"
                                    id="edit_birth_date" name="birth_date" required>
                                <label for="edit_birth_date">Birthdate</label>
                                @error('birth_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row g-1">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select form-select-sm @error('role') is-invalid @enderror"
                                    id="edit_role" name="role" required>
                                    <option value="" disabled>Select...</option>
                                    <option value="Admin">Admin</option>
                                    <option value="User">User</option>
                                </select>
                                <label for="edit_role">User Role</label>
                                @error('role')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text"
                                    class="form-control form-control-sm @error('occupation') is-invalid @enderror"
                                    id="edit_occupation" name="occupation">
                                <label for="edit_occupation">Occupation</label>
                                @error('occupation')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer mt-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fa fa-times-circle"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-edit"></i> Update User
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

                ["last_name", "first_name", "middle_name", "email", "address", "mobile",
                    "birth_date", "civil_status",
                    "sex", "occupation", "role"
                ].forEach(field => {
                    let input = document.getElementById("edit_" + field);
                    if (input) input.value = this.getAttribute("data-" + field);
                });
            });
        });
    });
</script>
