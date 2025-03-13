<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ApiAuthController extends Controller
{
    public function loginWithPhpSession(Request $request)
    {
        $email = $request->query('email');
        $sessionToken = $request->query('session_token');

        if (!$email || !$sessionToken) {
            return redirect('https://smartbarangayconnect.com');
        }

        // ✅ Fetch all users from the PHP system
        $response = Http::get('https://smartbarangayconnect.com/api_get_registerlanding.php');
        $users = $response->json();

        if (!$users) {
            return redirect('https://smartbarangayconnect.com')->withErrors('Could not fetch user data.');
        }

        // ✅ Find user in the response
        $userData = collect($users)->firstWhere('email', $email);

        if (!$userData || $userData['session_token'] !== $sessionToken) {
            return redirect('https://smartbarangayconnect.com')->withErrors('Invalid session token.');
        }

        // ✅ Check if the user exists in Laravel
        $user = User::where('email', $email)->first();

        if (!$user) {
            // Create user if they don’t exist in Laravel
            $user = User::create([
                'name' => $userData['first_name'] . ' ' . $userData['last_name'],
                'email' => $userData['email'],
                'password' => bcrypt('default_password'), // Change this if needed
                'role' => User::count() === 0 ? 'Admin' : 'User', // First user is Admin
            ]);
        }

        // ✅ Log in the user
        Auth::login($user);

        // ✅ Store PHP session details in Laravel session
        Session::put('php_session_token', $sessionToken);
        Session::put('php_email', $email);

        return redirect('/dashboard');
    }
}
