<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all(); // Fetch all users
        return view('users.index', compact('users')); // Pass users to the view
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return a view for creating a user (optional implementation)
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            // Validate request
            $data = $request->validate([
                'last_name' => 'required|string|max:255',
                'first_name' => 'required|string|max:255',
                'middle_name' => 'nullable|string|max:255',
                'email' => ['required', 'email', Rule::unique('users', 'email')],
                'password' => 'required|string|min:8|max:255|confirmed', // Use Laravel's password confirmation validation
                'address' => 'required|string|max:255',
                'birth_date' => 'nullable|date',
                'role' => ['nullable', 'string', Rule::in(['User', 'Admin'])],
                'sex' => ['nullable', 'string', Rule::in(['FEMALE', 'MALE'])],
                'mobile' => 'required|string|max:15',
                'occupation' => 'required|string|max:255',
            ]);

            // Hash password
            $data['password'] = Hash::make($data['password']);
            $data['role'] = $data['role'] ?? 'User'; // Default to 'User'

            // Create user
            User::create($data);
            session()->flash('success', 'User created successfully!');
            return redirect()->route('users.index');
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Failed to create user: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // Return a view to show user details (optional implementation)
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // Return a view for editing the user
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        try {
            // Validate request
            $data = $request->validate([
                'last_name' => 'required|string|max:255',
                'first_name' => 'required|string|max:255',
                'middle_name' => 'nullable|string|max:255',
                'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
                'password' => 'nullable|string|min:8|max:255',
                'address' => 'required|string|max:100',
                'birth_date' => 'nullable|date',
                'role' => ['nullable', 'string', Rule::in(['User', 'Admin'])],
                'working' => ['nullable', 'string', Rule::in(['yes', 'no'])],
                'mobile' => 'required|string|max:15',
                'sex' => 'required|string',
                'occupation' => 'required|string',
            ]);
            // Hash password if provided
            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']); // Do not update the password field
            }

            $user->update($data);

            session()->flash('success', 'User updated successfully!');
            return redirect()->route('users.index');
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Failed to update user: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();

            session()->flash('success', 'User deleted successfully!');
            return redirect()->route('users.index');
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete user: ' . $e->getMessage()]);
        }
    }
}
