<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        // Load users with their assigned roles eager loaded to prevent N+1 queries
        $users = User::with('roles')->get();
        $roles = Role::all(); // Used to build our role selection list checkboxes/options

        return view('users.index', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username|max:255',
            'email' => 'required|string|email|unique:users,email|max:255',
            'password' => 'required|string|min:8',
            'status' => 'required|in:active,inactive',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'User created successfully.',
            'user' => $user
        ]);
    }

    public function assignRoles(Request $request, User $user)
    {
        $request->validate([
            'roles'   => 'nullable|array',
            'roles.*' => 'string|exists:roles,name'
        ]);

        // Sync roles via Spatie package array mapping helper
        // Passing an empty array or missing key implicitly clears out all old assignments
        $user->syncRoles($request->input('roles', []));

        return response()->json([
            'success' => true,
            'message' => "Access profiles for '{$user->name}' updated successfully."
        ]);
    }

    public function updateStatus(Request $request, User $user)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,active,suspended'
        ]);

        $user->update(['status' => $validated['status']]);

        return response()->json([
            'success' => true,
            'message' => "Account verification identity for '{$user->name}' altered to: {$validated['status']}."
        ]);
    }

    public function show(User $user)
    {
        return response()->json($user);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8',
            'status' => 'required|in:active,inactive',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully.',
            'user' => $user
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully.'
        ]);
    }
}
