<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AdminLogin extends Component
{
    public string $email = 'admin@airlanggatravel.com';

    public string $password = 'password123';

    public string $errorMessage = '';

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            session()->regenerate();

            return redirect()->route('admin.dashboard');
        }

        $this->errorMessage = 'Email atau password salah. Silakan coba lagi.';
    }

    public function render()
    {
        return view('livewire.admin.admin-login')->layout('components.layouts.app', ['title' => 'Admin Login | Airlangga Travel']);
    }
}
