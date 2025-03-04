<?php

namespace App\Http\Controllers;

use App\Models\Scholarship;
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validate request
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|max:255',
                'role' => 'required|string', // Removed Rule::in
            ]);

            // Create new user with hashed password
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role, // Ensure the value matches ENUM options
                'password' => Hash::make($request->password),
            ]);

            flash()->success('User created successfully!');

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        try {
            // Validate request
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
                'role' => ['required', Rule::in(['Admin', 'User'])],
            ]);

            // Update user
            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'role' => $validated['role'],
            ]);

            return to_route('users.index');
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();

            flash()->success('User deleted successfully!');

            return redirect()->route('users.index');
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete user: ' . $e->getMessage()]);
        }
    }
}
