<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="row g-0 shadow-lg rounded bg-primary">
        <!-- Left side image -->
        <div class="col-md-6 d-none d-md-block p-0">
            <img src="{{ asset('assets/images/unified-lgu-logo.png') }}"
                class="img-fluid h-100 w-100 object-fit-cover rounded-start" alt="Login background">
        </div>

        <!-- Right side form (centered) -->
        <div class="col-md-6 bg-white d-flex align-items-center justify-content-center p-5 rounded-end shadow-sm">
            <div class="w-100" style="max-width: 400px;">
                <h1 class="mb-4 text-center fw-bold text-primary" style="font-size: larger">Welcome Back</h1>

                <!-- Validation Errors Display -->
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    <div class="form-floating mb-3">
                        <input type="email" class="form-control rounded-3 @error('email') is-invalid @enderror"
                            id="email" placeholder="Enter your email" name="email" value="{{ old('email') }}"
                            required>
                        <label for="email">Email Address</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control rounded-3 @error('password') is-invalid @enderror"
                            id="password" placeholder="Enter your password" name="password" required>
                        <label for="password">Password</label>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>
                        <a href="#" class="text-decoration-none text-primary">Forgot password?</a>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-3 rounded-3 fw-semibold">
                        Login
                    </button>
                </form>

                <!-- Signup prompt -->
                <div class="text-center mt-4">
                    <p class="mb-0">Don't have an account?
                        <a href="https://smartbarangayconnect.com/register.php"   class="text-primary fw-semibold text-decoration-none">
                            Sign up here
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
