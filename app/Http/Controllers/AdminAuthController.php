<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    private $adminCredentials = [
        [
            'email' => 'admin@beautyglow.com',
            'password' => 'admin123',
            'name' => 'Admin User',
            'role' => 'Administrator'
        ],
        [
            'email' => 'manager@beautyglow.com',
            'password' => 'manager123',
            'name' => 'Manager User',
            'role' => 'Manager'
        ],
        [
            'email' => 'supervisor@beautyglow.com',
            'password' => 'supervisor123',
            'name' => 'Supervisor User',
            'role' => 'Supervisor'
        ]
    ];

    public function showLogin()
    {
        return view('admin.login', ['credentials' => $this->adminCredentials]);
    }

    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        foreach ($this->adminCredentials as $admin) {
            if ($admin['email'] === $email && $admin['password'] === $password) {
                session([
                    'admin_logged_in' => true,
                    'admin_user' => $admin
                ]);
                return redirect()->route('admin.dashboard');
            }
        }

        return back()->withErrors(['Invalid credentials']);
    }

    public function logout()
    {
        session()->forget(['admin_logged_in', 'admin_user']);
        return redirect()->route('admin.login');
    }
}