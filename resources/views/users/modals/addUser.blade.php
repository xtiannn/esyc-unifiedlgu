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
                    <div class="row g-1">
                        <div class="col-md-6">
                            <div class="form-floating mb-1">
                                <input type="text"
                                    class="form-control form-control-sm @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}" placeholder="Full Name"
                                    value="{{ old('name') }}" required>
                                <label for="name">Full Name</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-1">
                                <input type="email"
                                    class="form-control form-control-sm @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}"
                                    placeholder="Email Address" required>
                                <label for="email">Email Address</label>
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
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-1">
                                <input type="password"
                                    class="form-control form-control-sm @error('password_confirmation') is-invalid @enderror"
                                    id="password_confirmation" name="password_confirmation"
                                    placeholder="Confirm Password" required>
                                <label for="password_confirmation">Confirm Password</label>
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
                            </div>
                        </div>
                    </div>

                    <div class="row g-1">
                        <div class="col-md-6">
                            <div class="form-floating mb-1">
                                <input type="text"
                                    class="form-control form-control-sm @error('contact_number') is-invalid @enderror"
                                    id="contact_number" name="contact_number" value="{{ old('contact_number') }}"
                                    placeholder="Contact Number" required>
                                <label for="contact_number">Contact Number</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-1">
                                <input type="date"
                                    class="form-control form-control-sm @error('birth_date') is-invalid @enderror"
                                    id="birth_date" name="birth_date" value="{{ old('birth_date') }}" required>
                                <label for="birth_date">Birthdate</label>
                            </div>
                        </div>
                    </div>

                    <div class="row g-1">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select form-select-sm @error('civil_status') is-invalid @enderror"
                                    id="civil_status" name="civil_status" required>
                                    <option value="" {{ old('civil_status') ? '' : 'selected' }} disabled>
                                        Select...</option>
                                    <option value="Single" {{ old('civil_status') === 'Single' ? 'selected' : '' }}>
                                        Single</option>
                                    <option value="Married" {{ old('civil_status') === 'Married' ? 'selected' : '' }}>
                                        Married</option>
                                    <option value="Divorced"
                                        {{ old('civil_status') === 'Divorced' ? 'selected' : '' }}>
                                        Divorced
                                    </option>
                                    <option value="Widowed" {{ old('civil_status') === 'Widowed' ? 'selected' : '' }}>
                                        Widowed</option>
                                </select>
                                <label for="civil_status">Civil Status</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select form-select-sm @error('gender') is-invalid @enderror"
                                    id="gender" name="gender" required>
                                    <option value="" {{ old('gender') ? '' : 'selected' }} disabled>
                                        Select...
                                    </option>
                                    <option value="Male" {{ old('gender') === 'Male' ? 'selected' : '' }}>
                                        Male
                                    </option>
                                    <option value="Female" {{ old('gender') === 'Female' ? 'selected' : '' }}>
                                        Female</option>
                                    </option>
                                </select>
                                <label for="gender">Gender</label>
                            </div>
                        </div>
                    </div>

                    <div class="row g-1 my-1">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text"
                                    class="form-control form-control-sm @error('occupation') is-invalid @enderror"
                                    id="occupation" name="occupation" value="{{ old('occupation') }}"
                                    placeholder="Occupation">
                                <label for="occupation">Occupation</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select form-select-sm @error('role') is-invalid @enderror"
                                    id="role" name="role" required>
                                    <option value="" {{ old('role') ? '' : 'selected' }} disabled>
                                        Select...
                                    </option>
                                    <option value="Admin" {{ old('role') === 'Admin' ? 'selected' : '' }}>
                                        Admin
                                    </option>
                                    <option value="User" {{ old('role') === 'User' ? 'selected' : '' }}>
                                        User
                                    </option>
                                </select>
                                <label for="role">User Role</label>
                            </div>
                        </div>
                    </div>

                    <div class="row g-1">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text"
                                    class="form-control form-control-sm @error('household_number') is-invalid @enderror"
                                    id="household_number" name="household_number"
                                    value="{{ old('household_number') }}" placeholder="Household Number" required>
                                <label for="household_number">Household Number</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text"
                                    class="form-control form-control-sm @error('barangay_id') is-invalid @enderror"
                                    id="barangay_id" name="barangay_id" value="{{ old('barangay_id') }}"
                                    placeholder="Barangay ID" required>
                                <label for="barangay_id">Barangay ID</label>
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
</script>
