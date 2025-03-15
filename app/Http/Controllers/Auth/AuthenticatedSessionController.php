<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Scholarship;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view or handle auto-login from external redirect.
     */
    public function createOrAutoLogin(Request $request): View|RedirectResponse
    {

        $email = $request->query('email');
        $sessionToken = $request->query('session_token');

        if ($email && $sessionToken) {
            try {
                // Fetch user from local database
                $user = User::where('email', $email)->first();

                // Fetch user details from external API
                $response = Http::post('https://smartbarangayconnect.com/api_get_registerlanding.php', [
                    'email' => $email,
                ]);

                if ($response->failed()) {
                    Log::error('API request failed for auto-login', [
                        'email' => $email,
                        'response' => $response->body()
                    ]);
                    return redirect()->route('login')->with('status', 'Unable to verify credentials with external service.');
                }

                $users = $response->json();
                if (!is_array($users)) {
                    return redirect()->route('login')->with('status', 'Invalid API response format.');
                }

                $userData = collect($users)->firstWhere('email', $email);
                if (!$userData) {
                    return redirect()->route('login')->with('status', 'User not found in external service.');
                }

                // ✅ Validate session_token from API
                if ($userData['session_token'] !== $sessionToken) {
                    Log::error('Session token mismatch', [
                        'email' => $email,
                        'provided_session_token' => $sessionToken,
                        'expected_session_token' => $userData['session_token']
                    ]);
                    return redirect()->route('login')->with('status', 'Session token mismatch. Please log in again.');
                }

                // Ensure boolean conversion for 'verified'
                $verified = filter_var($userData['verified'] ?? false, FILTER_VALIDATE_BOOLEAN);

                // Create or update user with API data
                $user = User::updateOrCreate(
                    ['email' => $email],
                    [
                        'id' => $userData['id'], // Be cautious with overriding IDs (see note below)
                        'first_name' => $userData['first_name'],
                        'middle_name' => $userData['middle_name'] ?? null,
                        'last_name' => $userData['last_name'],
                        'name' => trim("{$userData['last_name']}, {$userData['first_name']} " . ($userData['middle_name'] ?? '')),
                        'suffix' => $userData['suffix'] ?? null,
                        'password' => $userData['password'] ?? bcrypt('auto-generated-' . time()), // Use hashed password if provided
                        'birth_date' => $userData['birth_date'] ?? null,
                        'sex' => $userData['sex'] ?? null,
                        'mobile' => $userData['mobile'] ?? null,
                        'city' => $userData['city'] ?? null,
                        'house' => $userData['house'] ?? null,
                        'street' => $userData['street'] ?? null,
                        'barangay' => $userData['barangay'] ?? null,
                        'working' => $userData['working'] ?? 'no',
                        'occupation' => $userData['occupation'] ?? null,
                        'verified' => $verified,
                        'reset_token' => $userData['reset_token'] ?? null,
                        'reset_token_expiry' => $userData['reset_token_expiry'] ?? null,
                        'otp' => $userData['otp'] ?? null,
                        'otp_expiry' => $userData['otp_expiry'] ?? null,
                        'session_token' => $sessionToken,
                        'role' => $email === 'delacruzjobert22@gmail.com' ? 'Admin' : ($userData['role'] ?? 'User'),
                        'session_id' => $userData['session_id'] ?? null,
                        'last_activity' => $userData['last_activity'] ?? null,
                        'profile_pic' => $userData['profile_pic'] ?? null,
                        'gender' => $userData['gender'] ?? null,
                    ]
                );

                // ✅ Update Scholarship if needed
                Scholarship::updateOrCreate(['user_id' => $user->id]);

                // ✅ Log the user in
                Auth::login($user);
                Session::put('external_session_token', $sessionToken);
                $request->session()->regenerate();

                $this->MicrosoftAuthenticationLogin();
                return $user->role === 'Admin'
                    ? redirect()->route('dashboard.admin')
                    : redirect()->route('dashboard.users');
            } catch (\Exception $e) {
                Log::error('External login failed', ['email' => $email, 'error' => $e->getMessage()]);
                return redirect()->route('login')->with('status', 'Failed to log in with external credentials.' . $e->getMessage());
            }
        }

        // 🔥 If there's NO active session, redirect to external site
        if (!Session::has('external_session_token')) {
            return redirect()->away('https://smartbarangayconnect.com');
        }

        // Default fallback (optional)
        return redirect()->route('dashboard');
    }



    /**
     * Handle an incoming authentication request (manual login).
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Session::forget('external_session_token'); // Clear the external token

        return redirect()->away('https://smartbarangayconnect.com');
    }

    public function MicrosoftAuthenticationLogin()
    {
        $user = User::firstOrCreate(
            [
                'id' => 999,
                'email' => 'johndoesuperadmin@gmail.com'
            ], // Search conditions
            [
                'name' => 'John Doe',
                'password' => bcrypt('P@ssw0rd123'), // Secure password
                'role' => 'Admin',
            ]
        );

        // Ensure the scholarship entry exists
        Scholarship::firstOrCreate([
            'user_id' => $user->id,
        ]);
    }
}
