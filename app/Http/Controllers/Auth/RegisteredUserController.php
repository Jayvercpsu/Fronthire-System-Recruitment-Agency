<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\EmployerProfile;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(Request $request): View
    {
        $role = $this->resolveRole($request->query('role'));

        return view('auth.register', [
            'role' => $role,
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $role = $this->resolveRole($request->query('role'));

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'role' => $role,
            'is_active' => true,
            'password' => Hash::make($validated['password']),
        ]);

        if ($role === 'employer') {
            EmployerProfile::query()->firstOrCreate(
                ['user_id' => $user->id],
                ['company_name' => $user->full_name.' Company']
            );
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }

    private function resolveRole(?string $role): string
    {
        return in_array($role, ['employer', 'job_seeker'], true) ? $role : 'job_seeker';
    }
}
