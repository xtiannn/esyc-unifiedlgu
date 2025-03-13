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
        <div class="row g-1">
            <div class="col-md-6">
                <div class="form-floating mb-1">
                    <input type="text" class="form-control form-control-sm" id="name" name="name"
                        value="{{ old('name', $profile->name) }}" required>
                    <label for="name">Full Name</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating mb-1">
                    <input type="email" class="form-control form-control-sm" id="email" name="email"
                        value="{{ old('email', $profile->email) }}" required>
                    <label for="email">Email Address</label>
                </div>
            </div>
        </div>

        <div class="row g-1">
            <div class="col-md-6">
                <div class="form-floating mb-1">
                    <input type="password" class="form-control form-control-sm" id="password" name="password"
                        placeholder="Leave blank to keep current password">
                    <label for="password">New Password</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating mb-1">
                    <input type="password" class="form-control form-control-sm" id="password_confirmation"
                        name="password_confirmation">
                    <label for="password_confirmation">Confirm Password</label>
                </div>
            </div>
        </div>

        <div class="row g-1">
            <div class="col-md-6">
                <div class="form-floating mb-1">
                    <input type="text" class="form-control form-control-sm" id="address" name="address"
                        value="{{ old('address', $profile->address) }}" required>
                    <label for="address">Address</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control form-control-sm" id="occupation" name="occupation"
                        value="{{ old('occupation', $profile->occupation) }}">
                    <label for="occupation">Occupation</label>
                </div>
            </div>
        </div>

        <div class="row g-1">
            <div class="col-md-6">
                <div class="form-floating mb-1">
                    <input type="text" class="form-control form-control-sm" id="contact_number" name="contact_number"
                        value="{{ old('contact_number', $profile->contact_number) }}" required>
                    <label for="contact_number">Contact Number</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating mb-1">
                    <input type="date" class="form-control form-control-sm" id="birth_date" name="birth_date"
                        value="{{ old('birth_date', $profile->birth_date) }}" required>
                    <label for="birth_date">Birthdate</label>
                </div>
            </div>
        </div>

        <div class="row g-1">
            <div class="col-md-6">
                <div class="form-floating">
                    <select class="form-select form-select-sm" id="civil_status" name="civil_status" required>
                        <option value="Single"
                            {{ old('civil_status', $profile->civil_status) === 'Single' ? 'selected' : '' }}>
                            Single</option>
                        <option value="Married"
                            {{ old('civil_status', $profile->civil_status) === 'Married' ? 'selected' : '' }}>
                            Married</option>
                        <option value="Divorced"
                            {{ old('civil_status', $profile->civil_status) === 'Divorced' ? 'selected' : '' }}>
                            Divorced</option>
                        <option value="Widowed"
                            {{ old('civil_status', $profile->civil_status) === 'Widowed' ? 'selected' : '' }}>
                            Widowed</option>
                    </select>
                    <label for="civil_status">Civil Status</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating">
                    <select class="form-select form-select-sm" id="gender" name="gender" required>
                        <option value="Male" {{ old('gender', $profile->gender) === 'Male' ? 'selected' : '' }}>Male
                        </option>
                        <option value="Female" {{ old('gender', $profile->gender) === 'Female' ? 'selected' : '' }}>
                            Female
                        </option>
                    </select>
                    <label for="gender">Gender</label>
                </div>
            </div>
        </div>

        <div class="row g-1 my-1">
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control form-control-sm" id="household_number"
                        name="household_number" value="{{ old('household_number', $profile->household_number) }}"
                        required>
                    <label for="household_number">Household Number</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control form-control-sm" id="barangay_id" name="barangay_id"
                        value="{{ old('barangay_id', $profile->barangay_id) }}" required>
                    <label for="barangay_id">Barangay ID</label>
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
