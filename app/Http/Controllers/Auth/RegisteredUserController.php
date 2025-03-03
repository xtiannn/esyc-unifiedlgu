<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Scholarship;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'address' => ['required', 'string', 'max:255'],
            'contact_number' => ['required', 'string', 'max:15'],
            'birth_date' => ['required', 'date'],
            'civil_status' => ['required', 'string'],
            'gender' => ['required', 'string'],
            'occupation' => ['nullable', 'string', 'max:255'],
            'household_number' => ['required', 'string', 'max:50'],
            'barangay_id' => ['required', 'string', 'max:50'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'contact_number' => $request->contact_number,
            'birth_date' => $request->birthdate,
            'civil_status' => $request->civil_status,
            'gender' => $request->gender,
            'occupation' => $request->occupation,
            'household_number' => $request->household_number,
            'barangay_id' => $request->barangay_id,
        ]);

        event(new Registered($user));

        Scholarship::create(['user_id' => $user->id]);

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
