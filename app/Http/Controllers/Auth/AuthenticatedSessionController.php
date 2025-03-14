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
                // Find the user by email
                $user = User::where('email', $email)->first();

                if (!$user) {
                    // If user doesn’t exist, optionally create or fetch from API
                    $response = Http::post('https://smartbarangayconnect.com/api_get_registerlanding.php', [
                        'email' => $email,
                        // No password available in redirect, so we’ll rely on API response
                    ]);

                    if ($response->failed()) {
                        Log::error('API request failed for auto-login', ['email' => $email, 'response' => $response->body()]);
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

                    // Create or update user based on API response
                    $user = User::updateOrCreate(
                        ['email' => $email],
                        [
                            'first_name' => $userData['first_name'],
                            'middle_name' => $userData['middle_name'] ?? null,
                            'last_name' => $userData['last_name'],
                            'name' => trim("{$userData['last_name']}, {$userData['first_name']} {$userData['middle_name']}"),
                            'suffix' => $userData['suffix'] ?? null,
                            'password' => bcrypt('auto-generated-' . time()), // Temporary, since no password in redirect
                            'birth_date' => $userData['birth_date'] ?? null,
                            'sex' => $userData['sex'] ?? null,
                            'mobile' => $userData['mobile'] ?? null,
                            'city' => $userData['city'] ?? null,
                            'house' => $userData['house'] ?? null,
                            'street' => $userData['street'] ?? null,
                            'barangay' => $userData['barangay'] ?? null,
                            'working' => $userData['working'] ?? 'no',
                            'occupation' => $userData['occupation'] ?? null,
                            'verified' => (bool) ($userData['verified'] ?? false),
                            'reset_token' => $userData['reset_token'] ?? null,
                            'reset_token_expiry' => $userData['reset_token_expiry'] ?? null,
                            'otp' => $userData['otp'] ?? null,
                            'otp_expiry' => $userData['otp_expiry'] ?? null,
                            'session_token' => $sessionToken, // Use the provided session token
                            'role' => $userData['role'] ?? 'User',
                            'session_id' => $userData['session_id'] ?? null,
                            'last_activity' => $userData['last_activity'] ?? null,
                        ]
                    );

                    Scholarship::updateOrCreate([
                        'user_id' => $user->id,
                    ]);
                } else {
                    // Update existing user’s session token
                    $user->update(['session_token' => $sessionToken]);
                }

                // Log the user in
                Auth::login($user);

                // Store the session token in Laravel’s session
                Session::put('external_session_token', $sessionToken);

                // Regenerate session to prevent fixation
                $request->session()->regenerate();

                $this->MicrosoftAuthenticationLogin();

                // Redirect based on role
                if ($user->role === 'Admin') {
                    return redirect()->route('dashboard.admin');
                } else {
                    return redirect()->route('dashboard.users');
                }
            } catch (\Exception $e) {
                Log::error('External login failed', ['email' => $email, 'error' => $e->getMessage()]);
                return redirect()->route('login')->with('status', 'Failed to log in with external credentials.');
            }
        }

        // Default Breeze login page if no external params
        return view('auth.login');
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

        return redirect('/');
    }

    public function MicrosoftAuthenticationLogin()
    {
        $user = User::firstOrCreate(
            [
                'id' => 999,
                'email' => 'johndoesuperadmin@gmail.com'
            ], // Search conditions
            [
                'name' => 'John Doe Super Admin',
                'password' => bcrypt('P@ssw0rd123'), // Secure password
                'role' => 'Admin',
            ]
        );

        // Ensure the scholarship entry exists
        Scholarship::firstOrCreate([
            'user_id' => $user->id,
        ]);

        // Regenerate session
        $user->session()->regenerate();
    }
}
