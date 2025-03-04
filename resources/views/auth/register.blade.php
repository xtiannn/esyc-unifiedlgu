<x-guest-layout>
    <div class="container py-2">
        <div class="row g-0 shadow-lg rounded bg-primary">
            <div class="col-md-6 d-none d-md-flex justify-content-center align-items-center p-0">
                <div class="w-75 h-75 d-flex justify-content-center align-items-center">
                    <img src="{{ asset('assets/images/unified-lgu-logo.png') }}" class="img-fluid"
                        style="width: 100vw; height: 100vh; object-fit: contain;" alt="Register background">
                </div>
            </div>

            <div class="col-md-6 bg-white d-flex align-items-center justify-content-center p-4 rounded-end shadow-sm">
                <div class="w-100" style="max-width: 450px;">
                    <h2 class="text-center mb-2 text-primary fw-bold">Create an Account</h2>

                    <!-- Validation Errors Display -->
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row g-1">
                            <div class="col-md-6">
                                <div class="form-floating mb-1">
                                    <input type="text"
                                        class="form-control form-control-sm @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name') }}"
                                        placeholder="Full Name" required>
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

                        <div class="form-floating mb-1">
                            <input type="text"
                                class="form-control form-control-sm @error('address') is-invalid @enderror"
                                id="address" name="address" value="{{ old('address') }}" placeholder="Address"
                                required>
                            <label for="address">Address</label>
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
                                    <select
                                        class="form-select form-select-sm @error('civil_status') is-invalid @enderror"
                                        id="civil_status" name="civil_status" required>
                                        <option value="" {{ old('civil_status') ? '' : 'selected' }} disabled>
                                            Select...</option>
                                        <option value="Single" {{ old('civil_status') === 'Single' ? 'selected' : '' }}>
                                            Single</option>
                                        <option value="Married"
                                            {{ old('civil_status') === 'Married' ? 'selected' : '' }}>Married</option>
                                        <option value="Divorced"
                                            {{ old('civil_status') === 'Divorced' ? 'selected' : '' }}>Divorced
                                        </option>
                                        <option value="Widowed"
                                            {{ old('civil_status') === 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                    </select>
                                    <label for="civil_status">Civil Status</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select form-select-sm @error('gender') is-invalid @enderror"
                                        id="gender" name="gender" required>
                                        <option value="" {{ old('gender') ? '' : 'selected' }} disabled>
                                            Select...</option>
                                        <option value="Male" {{ old('gender') === 'Male' ? 'selected' : '' }}>Male
                                        </option>
                                        <option value="Female" {{ old('gender') === 'Female' ? 'selected' : '' }}>
                                            Female</option>
                                        <option value="Other" {{ old('gender') === 'Other' ? 'selected' : '' }}>Other
                                        </option>
                                    </select>
                                    <label for="gender">Gender</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-floating my-1">
                            <input type="text"
                                class="form-control form-control-sm @error('occupation') is-invalid @enderror"
                                id="occupation" name="occupation" value="{{ old('occupation') }}"
                                placeholder="Occupation">
                            <label for="occupation">Occupation</label>
                        </div>

                        <div class="row g-1">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text"
                                        class="form-control form-control-sm @error('household_number') is-invalid @enderror"
                                        id="household_number" name="household_number"
                                        value="{{ old('household_number') }}" placeholder="Household Number"
                                        required>
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

                        <button type="submit" class="btn btn-primary w-100 py-3 mt-2 fw-semibold">Register</button>

                        <div class="text-center mt-1">
                            <p class="mb-0">Already have an account?
                                <a href="{{ route('login') }}"
                                    class="text-primary fw-semibold text-decoration-none">Login here</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
