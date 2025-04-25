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
                            <div class="col-md-12">
                                <div class="form-floating mb-1">
                                    <input type="text"
                                        class="form-control form-control-sm @error('first_name') is-invalid @enderror"
                                        id="first_name" name="first_name" value="{{ old('first_name') }}"
                                        placeholder="First Name" required>
                                    <label for="first_name">First Name</label>
                                </div>
                            </div>
                        </div>

                        <div class="row g-1">
                            <div class="col-md-12">
                                <div class="form-floating mb-1">
                                    <input type="text"
                                        class="form-control form-control-sm @error('middle_name') is-invalid @enderror"
                                        id="middle_name" name="middle_name" value="{{ old('middle_name') }}"
                                        placeholder="Middle Name" required>
                                    <label for="middle_name">Middle Name</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-1">
                            <div class="col-md-12">
                                <div class="form-floating mb-1">
                                    <input type="text"
                                        class="form-control form-control-sm @error('last_name') is-invalid @enderror"
                                        id="last_name" name="last_name" value="{{ old('last_name') }}"
                                        placeholder="Last Name" required>
                                    <label for="last_name">Last Name</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-1">
                            <div class="col-md-6">
                                <div class="form-floating mb-1">
                                    <select class="form-select form-select-sm @error('sex') is-invalid @enderror"
                                        id="sex" name="sex" required>
                                        <option value="" disabled {{ old('sex') ? '' : 'selected' }}>Select
                                            Gender:
                                        </option>
                                        <option value="Male" {{ old('sex') === 'Male' ? 'selected' : '' }}>Male
                                        </option>
                                        <option value="Female" {{ old('sex') === 'Female' ? 'selected' : '' }}>
                                            Female
                                        </option>
                                    </select>
                                    <label for="sex">Gender</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-1">
                                    <select class="form-select form-select-sm @error('role') is-invalid @enderror"
                                        id="role" name="role" required>
                                        <option value="" disabled {{ old('role') ? '' : 'selected' }}>Select Role:
                                        </option>
                                        <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User
                                        </option>
                                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin
                                        </option>
                                    </select>
                                    <label for="role">Role</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-1">
                            <div class="col-md-6">
                                <div class="form-floating mb-1">
                                    <input type="email"
                                        class="form-control form-control-sm @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email') }}"
                                        placeholder="Email Address" required>
                                    <label for="email">Email Address</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-1">
                                    <input type="text"
                                        class="form-control form-control-sm @error('contact_number') is-invalid @enderror"
                                        id="contact_number" name="contact_number" value="{{ old('contact_number') }}"
                                        placeholder="Mobile Number" required>
                                    <label for="contact_number">Mobile Number</label>
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
