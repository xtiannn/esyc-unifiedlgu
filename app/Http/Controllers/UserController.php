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
                'address' => 'required|string|max:100',
                'role' => 'required|string|max:5',
                'contact_number' => 'required|string|max:15',
                'birth_date' => 'required',
                'civil_status' => 'required|string',
                'gender' => 'required|string',
                'occupation' => 'required|string',
                'household_number' => 'required|string',
                'barangay_id' => 'required|string',
            ]);

            // Create new user with hashed password
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'address' => $request->address,
                'role' => $request->role,
                'contact_number' => $request->contact_number,
                'birth_date' => $request->birth_date,
                'civil_status' => $request->civil_status,
                'gender' => $request->gender,
                'occupation' => $request->occupation,
                'household_number' => $request->household_number,
                'barangay_id' => $request->barangay_id,

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
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|max:255',
                'address' => 'required|string|max:100',
                'role' => 'required|string|max:5',
                'contact_number' => 'required|string|max:15',
                'birth_date' => 'required',
                'civil_status' => 'required|string',
                'gender' => 'required|string',
                'occupation' => 'required|string',
                'household_number' => 'required|string',
                'barangay_id' => 'required|string',
            ]);

            // Create new user with hashed password
            $user = User::update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'address' => $request->address,
                'role' => $request->role,
                'contact_number' => $request->contact_number,
                'birth_date' => $request->birth_date,
                'civil_status' => $request->civil_status,
                'gender' => $request->gender,
                'occupation' => $request->occupation,
                'household_number' => $request->household_number,
                'barangay_id' => $request->barangay_id,

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
