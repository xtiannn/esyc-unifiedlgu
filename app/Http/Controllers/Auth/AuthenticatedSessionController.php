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

class AuthenticatedSessionController extends Controller
{
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
        //     $request->authenticate();

        //     $request->session()->regenerate();

        //     return redirect()->intended(route('dashboard', absolute: false));
        // Validate the request (email and password)
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Fetch user data from the external API
        $client = new Client();
        $response = $client->get('https://smartbarangayconnect.com/api_get_registerlanding.php');
        $users = json_decode($response->getBody(), true);

        // Find the user by email
        $userData = collect($users)->firstWhere('email', $request->email);

        if (!$userData || !Hash::check($request->password, $userData['password'])) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        // Manually log in the user
        $user = new \stdClass();
        $user->id = $userData['id'];
        $user->email = $userData['email'];
        $user->first_name = $userData['first_name'];
        $user->last_name = $userData['last_name'];
        $user->role = $userData['role'];

        // Use a custom guard or session logic if needed
        Auth::loginUsingId($user->id, $request->boolean('remember'));

        // Regenerate session
        $request->session()->regenerate();

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
