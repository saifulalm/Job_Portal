<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\CompanyProfile; // Add this
use App\Models\EmployeeProfile; // Add this
use Illuminate\Support\Facades\DB; // Add this for transactions

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    // Add this method to show the employee registration form
    public function createEmployee(): \Illuminate\View\View
    {
        return view('auth.register-employee');
    }

// Add this method to show the company registration form
    public function createCompany(): \Illuminate\View\View
    {
        return view('auth.register-company');
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
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:employee,company'],
            'company_name' => ['required_if:role,company', 'string', 'max:255'],
        ]);

        // Use a database transaction to ensure data integrity
        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            if ($request->role === 'company') {
                CompanyProfile::create([
                    'user_id' => $user->id,
                    'company_name' => $request->company_name,
                ]);
            } else {
                EmployeeProfile::create([
                    'user_id' => $user->id,
                ]);
            }

            event(new Registered($user));

            Auth::login($user);
        });

        return redirect(route('dashboard', absolute: false));
    }
}
