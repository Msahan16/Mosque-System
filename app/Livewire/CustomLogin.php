<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.login')]
class CustomLogin extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function mount()
    {
        // Redirect authenticated users based on role
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'mosque') {
                return redirect()->route('mosque.dashboard');
            } elseif ($user->role === 'staff') {
                return redirect()->route('mosque.dashboard');
            }
            return redirect()->route('dashboard');
        }
    }

    public function login()
    {
        $this->validate();

        // Authenticate using email and password
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            session()->regenerate();
            
            $user = Auth::user();
            
            // Check if user is active
            if (!$user->is_active) {
                Auth::logout();
                $this->addError('email', 'Your account has been deactivated. Please contact your administrator.');
                return;
            }
            
            // Redirect based on user role
            if ($user->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            } elseif ($user->role === 'mosque' || $user->role === 'staff') {
                return redirect()->intended(route('mosque.dashboard'));
            }
            
            return redirect()->intended(route('dashboard'));
        }

        $this->addError('email', 'These credentials do not match our records.');
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        
        session()->invalidate();
        session()->regenerateToken();

        return redirect('/');
    }

    public function render()
    {
        return view('livewire.custom-login');
    }
}
