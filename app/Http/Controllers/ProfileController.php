<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Assuming you're using the default User model

class ProfileController extends Controller
{
    public function index()
    {
        $profile = Auth::user(); // Get the authenticated user
        return view('profile.index', compact('profile'));
    }

    public function edit()
    {
        $profile = Auth::user();
        return view('profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'contact_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'civil_status' => 'nullable|in:single,married,widowed,separated',
            'occupation' => 'nullable|string|max:255',
            'household_number' => 'nullable|string|max:50',
            'barangay_id' => 'nullable|integer', // 🔥 Fixed: Removed "exists:barangays,id"
            'password' => 'nullable|min:8|confirmed',
        ]);

        $profile = Auth::user();
        $profile->update($request->except('password'));

        if ($request->filled('password')) {
            $profile->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('profile.index')->with('success', 'Profile updated successfully.');
    }

}
