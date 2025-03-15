<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{


    public function autoLogin(Request $request)
    {
        $email = $request->query('email');
        $token = $request->query('session_token');

        if (!$email || !$token) {
            return redirect('/login')->with('error', 'Invalid login link');
        }

        // Check if user exists
        $user = User::where('email', $email)->first();

        if (!$user) {
            // If user doesn't exist, fetch from API
            $response = Http::post('https://smartbarangayconnect.com/api_get_registerlanding.php', [
                'email' => $email
            ]);

            if ($response->failed()) {
                return redirect('/login')->with('error', 'Failed to fetch user data.');
            }

            $users = $response->json();
            $userData = collect($users)->firstWhere('email', $email);

            if (!$userData) {
                return redirect('/login')->with('error', 'User not found in API.');
            }

            // Create user in database
            $user = User::create([
                'email' => $userData['email'],
                'first_name' => $userData['first_name'],
                'last_name' => $userData['last_name'],
                'name' => trim("{$userData['last_name']}, {$userData['first_name']}"),
                'password' => bcrypt('default_password'), // You can change this logic
                'session_token' => $token, // Store the session token
                'role' => $userData['role'] ?? 'User',
                'verified' => (bool) ($userData['verified'] ?? false),
            ]);
        } else {
            // Validate session token if user exists
            if ($user->session_token !== $token) {
                return redirect('/login')->with('error', 'Invalid session token.');
            }
        }

        // Log in the user
        Auth::login($user);

        return redirect('/dashboard'); // Redirect to dashboard
    }


    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Get email & password from request
        $credentials = $request->only('email', 'password');

        // Validate credentials with local database first
        $user = \App\Models\User::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            // If user exists and password is correct, authenticate locally
            Auth::login($user);
        }

        // Proceed with API authentication regardless
        $response = Http::post('https://smartbarangayconnect.com/api_get_registerlanding.php', $credentials);

        // If API request fails, return an error
        if ($response->failed()) {
            return back()->withErrors(['email' => 'API request failed: ' . $response->body()]);
        }

        // Decode the API response
        $users = $response->json();

        // Ensure response is an array
        if (!is_array($users)) {
            return back()->withErrors(['email' => 'Invalid API response format.']);
        }

        // Find user by email from API response
        $userData = collect($users)->firstWhere('email', $credentials['email']);

        if (!$userData) {
            return back()->withErrors(['email' => 'Invalid credentials.']);
        }

        // Extract user data safely
        $external_id = $userData['id'];
        $email = $userData['email'];
        $first_name = $userData['first_name'];
        $last_name = $userData['last_name'];
        $middle_name = $userData['middle_name'] ?? null;
        $suffix = $userData['suffix'] ?? null;
        $birth_date = $userData['birth_date'] ?? null;
        $sex = $userData['sex'] ?? null;
        $mobile = $userData['mobile'] ?? null;
        $city = $userData['city'] ?? null;
        $house = $userData['house'] ?? null;
        $street = $userData['street'] ?? null;
        $barangay = $userData['barangay'] ?? null;
        $working = $userData['working'] ?? 'no';
        $occupation = $userData['occupation'] ?? null;
        $verified = (bool) ($userData['verified'] ?? false);
        $reset_token = $userData['reset_token'] ?? null;
        $reset_token_expiry = $userData['reset_token_expiry'] ?? null;
        $otp = $userData['otp'] ?? null;
        $otp_expiry = $userData['otp_expiry'] ?? null;
        $session_token = $userData['session_token'] ?? null;
        $role = $userData['role'] ?? 'User';
        $session_id = $userData['session_id'] ?? null;
        $last_activity = $userData['last_activity'] ?? null;


        // Create or update user in the database
        $user = \App\Models\User::updateOrCreate(
            ['email' => $email],
            [

                'first_name' => $first_name,
                'middle_name' => $middle_name,
                'last_name' => $last_name,
                'name' => trim("$last_name, $first_name $middle_name"), // Auto-fill name                'suffix' => $suffix,
                'password' => bcrypt($credentials['password']), // Store hashed password
                'birth_date' => $birth_date,
                'sex' => $sex,
                'mobile' => $mobile,
                'city' => $city,
                'house' => $house,
                'street' => $street,
                'barangay' => $barangay,
                'working' => $working,
                'occupation' => $occupation,
                'verified' => $verified,
                'reset_token' => $reset_token,
                'reset_token_expiry' => $reset_token_expiry,
                'otp' => $otp,
                'otp_expiry' => $otp_expiry,
                'session_token' => $session_token,
                'role' => $role,
                'session_id' => $session_id,
                'last_activity' => $last_activity,
            ]
        );

        // Authenticate the user after API validation
        Auth::login($user);

        // Regenerate session
        $request->session()->regenerate();

        // Store user ID in scholarships table (if not already exists)
        \App\Models\Scholarship::firstOrCreate(['user_id' => $user->id]);





        // Check if an admin exists
        $adminExists = \App\Models\User::where('role', 'Admin')->exists();

        if (!$adminExists) {
            // Create admin user
            $admin = \App\Models\User::create([
                'email' => 'email@example.com',
                'password' => bcrypt('P@ssw0rd123'),
                'first_name' => 'John',
                'last_name' => 'Doe',
                'name' => 'Doe, John', // Auto-fill name
                'role' => 'Admin',
                'verified' => true,
            ]);

            // Insert admin ID into scholarships table
            \App\Models\Scholarship::firstOrCreate(['user_id' => $admin->id]);
        }


        return redirect()->intended(route('dashboard'));
    }




    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
