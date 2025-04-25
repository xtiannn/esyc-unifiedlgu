<x-app-layout>
    @section('title', 'Update Profile')

    <div class="row">
        <div class="col-md-10 mb-3">
            <h1>Update Profile</h1>
        </div>
    </div>

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-12">
                <div class="form-floating mb-1">
                    <input type="text" class="form-control form-control-sm @error('first_name') is-invalid @enderror"
                        id="first_name" name="first_name" value="{{ old('first_name', $profile->first_name) }}"
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
                        class="form-control form-control-sm @error('middle_name') is-invalid @enderror" id="middle_name"
                        name="middle_name" value="{{ old('middle_name', $profile->middle_name) }}"
                        placeholder="Middle Name">
                    <label for="middle_name">Middle Name</label>
                    @error('middle_name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-floating mb-1">
                    <input type="text" class="form-control form-control-sm @error('last_name') is-invalid @enderror"
                        id="last_name" name="last_name" value="{{ old('last_name', $profile->last_name) }}"
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
                    <select class="form-select form-select-sm @error('sex') is-invalid @enderror" id="sex"
                        name="sex" required>
                        <option value="" disabled {{ old('sex', $profile->sex) ? '' : 'selected' }}>Select...
                        </option>
                        <option value="MALE" {{ old('sex', $profile->sex) === 'MALE' ? 'selected' : '' }}>Male
                        </option>
                        <option value="FEMALE" {{ old('sex', $profile->sex) === 'FEMALE' ? 'selected' : '' }}>Female
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
                    <input type="email" class="form-control form-control-sm @error('email') is-invalid @enderror"
                        id="email" name="email" value="{{ old('email', $profile->email) }}"
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
                    <input type="text" class="form-control form-control-sm @error('address') is-invalid @enderror"
                        id="address" name="address" value="{{ old('address', $profile->address) }}"
                        placeholder="Address" required>
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
                    <input type="text" class="form-control form-control-sm @error('mobile') is-invalid @enderror"
                        id="mobile" name="mobile" value="{{ old('mobile', $profile->mobile) }}"
                        placeholder="Contact Number" required>
                    <label for="mobile">Contact Number</label>
                    @error('mobile')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating mb-1">
                    <input type="date" class="form-control form-control-sm @error('birth_date') is-invalid @enderror"
                        id="birth_date" name="birth_date" value="{{ old('birth_date', $profile->birth_date) }}"
                        required>
                    <label for="birth_date">Birthdate</label>
                    @error('birth_date')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row g-1 my-1">
            <div class="col-md-6">
                <div class="form-floating">
                    <select class="form-select form-select-sm @error('role') is-invalid @enderror" id="role"
                        name="role" required>
                        <option value="" disabled {{ old('role', $profile->role) ? '' : 'selected' }}>Select...
                        </option>
                        <option value="Admin" {{ old('role', $profile->role) === 'Admin' ? 'selected' : '' }}>Admin
                        </option>
                        <option value="User" {{ old('role', $profile->role) === 'User' ? 'selected' : '' }}>User
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
                        class="form-control form-control-sm @error('occupation') is-invalid @enderror" id="occupation"
                        name="occupation" value="{{ old('occupation', $profile->occupation) }}"
                        placeholder="Occupation">
                    <label for="occupation">Occupation</label>
                    @error('occupation')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>

        <div class="modal-footer mt-2">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-save"></i> Update Profile
            </button>
        </div>
    </form>
</x-app-layout>
