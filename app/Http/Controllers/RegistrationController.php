<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\SystemAlertNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;
use Yajra\Address\Entities\Province;

class RegistrationController extends Controller
{
    /**
     * Display the registration view with the top-level Province list.
     */
    public function create()
    {
        // Fetch all provinces ordered alphabetically to populate step 2
        $provinces = Province::orderBy('name', 'asc')->get();

        return view('auth.registration', compact('provinces'));
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request)
    {
        // Validate all custom wizard steps fields
        $request->validate([
            // Step 1: Personal Profile Info
            'prefix'        => ['nullable', 'string', 'in:Mr.,Ms.,Mrs.'],
            'first_name'    => ['required', 'string', 'max:100'],
            'middle_name'   => ['nullable', 'string', 'max:100'],
            'last_name'     => ['required', 'string', 'max:100'],
            'suffix'        => ['nullable', 'string'],
            'email'         => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'mobile_number' => ['required', 'string', 'regex:/^9\d{9}$/'], // Match PH 9xxxxxxxxx
            'birthdate'     => ['required', 'date', 'before:today'],
            'gender'        => ['required', 'string', 'in:Male,Female,Other'],
            'religion'      => ['nullable', 'string', 'max:100'],
            'disability'    => ['required', 'string', 'in:No Data,No,Yes'],
            'ethnic_group'  => ['nullable', 'string', 'max:100'],

            // Step 2: Address Structural Identifiers (Foreign keys matching Yajra package)
            'province_id'   => ['required', 'integer', 'exists:provinces,province_id'],
            'city_id'       => ['required', 'integer', 'exists:cities,city_id'],
            'barangay_id'   => ['required', 'integer', 'exists:barangays,id'],
            'purok'         => ['nullable', 'string', 'max:255'],

            // Step 3: Application Access Rules
            'username'      => ['required', 'string', 'min:4', 'max:50', 'unique:users,username'],
            'password'      => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        // 1. Create the user record
        $user = User::create([
            'prefix'        => $request->prefix,
            'first_name'    => $request->first_name,
            'middle_name'   => $request->middle_name,
            'last_name'     => $request->last_name,
            'suffix'        => $request->suffix,
            'name'          => trim("{$request->first_name} {$request->middle_name} {$request->last_name} {$request->suffix}"),
            'email'         => $request->email,
            'mobile_number' => '+63' . $request->mobile_number,
            'birthdate'     => $request->birthdate,
            'religion'      => $request->religion,
            'gender'        => $request->gender,
            'disability'    => $request->disability,
            'ethnic_group'  => $request->ethnic_group,

            // Address configuration mappings
            'province_id'   => $request->province_id,
            'city_id'       => $request->city_id,
            'barangay_id'   => $request->barangay_id,
            'street'        => $request->purok,

            'username'      => $request->username,
            'password'      => Hash::make($request->password),
            'status'        => 'pending',
        ]);

        // 2. Safely locate and assign the default Staff role profile
        $staffRole = Role::where('name', 'Staff')->first();
        if ($staffRole) {
            $user->assignRole($staffRole);
        }

        // 3. Notify Super Admins that a profile is awaiting approval
        $admins = User::role('Super Admin')->get();
        $payload = [
            'title'      => 'New Registration Awaiting Review',
            'message'    => "Account application submitted by {$user->name} ({$user->email}).",
            'icon'       => 'fas fa-user-clock text-warning',
            'action_url' => route('users.index'),
        ];
        foreach ($admins as $admin) {
            $admin->notify(new SystemAlertNotification($payload));
        }

        // 4. Trigger the Registered event to automatically send the verification email
        event(new Registered($user));

        // 5. Authenticate the user session so they can access the verification notice page
        Auth::login($user);

        // 6. Redirect to the email verification notice route
        return redirect()->route('verification.notice');
    }
}
