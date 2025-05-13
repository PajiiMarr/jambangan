<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.auth')]
class Register extends Component
{
    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        // Validate the input fields
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        // Hash the password
        $validated['password'] = Hash::make($validated['password']);

        // Check if this is the first user
        $isFirstUser = User::count() === 0;

        // Set the request status and is_superadmin value based on first user
        $validated['request_status'] = $isFirstUser ? 'accepted' : 'pending';
        $validated['is_superadmin'] = $isFirstUser ? true : false;

        // Log debug information
        \Log::info('Is first user: ' . $isFirstUser); // Check if it's the first user
        \Log::info('Validated data: ', $validated); // Check the values being passed to the database

        // Create the user
        event(new Registered($user = User::create($validated)));

        // Log the user in
        Auth::login($user);

        // Redirect to the dashboard
        $this->dispatch('redirect-to', url()->route('dashboard'));
    }
}
