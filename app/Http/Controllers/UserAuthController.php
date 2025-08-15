<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserAuthController extends Controller
{
    private $userCredentials = [
        [
            'email' => 'user@example.com',
            'password' => 'user123',
            'name' => 'Demo User',
            'phone' => '+1 (555) 123-4567'
        ],
        [
            'email' => 'sarah@example.com',
            'password' => 'sarah123',
            'name' => 'Sarah Johnson',
            'phone' => '+1 (555) 234-5678'
        ]
    ];

    public function showLogin()
    {
        return view('user.login', ['credentials' => $this->userCredentials]);
    }

    public function showRegister()
    {
        return view('user.register');
    }

    public function showForgotPassword()
    {
        return view('user.forgot-password');
    }

    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        foreach ($this->userCredentials as $user) {
            if ($user['email'] === $email && $user['password'] === $password) {
                session([
                    'user_logged_in' => true,
                    'user' => $user
                ]);
                return redirect()->route('user.dashboard');
            }
        }

        return back()->withErrors(['Invalid credentials']);
    }

    public function register(Request $request)
    {
        // Simulate registration
        $user = [
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'phone' => $request->input('phone')
        ];

        session([
            'user_logged_in' => true,
            'user' => $user
        ]);

        return redirect()->route('user.dashboard');
    }

    public function logout()
    {
        session()->forget(['user_logged_in', 'user']);
        return redirect()->route('user.login');
    }
}