<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function dashboard()
    {
        if (!session('user_logged_in')) {
            return redirect()->route('user.login');
        }

        $data = [
            'user' => session('user'),
            'stats' => [
                'total_bookings' => 8,
                'completed_services' => 5,
                'scheduled_services' => 3,
                'total_spent' => 1450
            ],
            'recent_orders' => [
                ['id' => 1, 'service' => 'Bridal Makeup', 'date' => '2024-01-15', 'amount' => 299, 'status' => 'Scheduled'],
                ['id' => 2, 'service' => 'Party Makeup', 'date' => '2023-12-20', 'amount' => 149, 'status' => 'Completed'],
                ['id' => 3, 'service' => 'Photoshoot', 'date' => '2023-12-10', 'amount' => 199, 'status' => 'Completed']
            ],
            'upcoming_appointments' => [
                ['service' => 'Bridal Makeup', 'date' => '2024-01-15', 'time' => '10:00 AM', 'location' => 'Studio'],
                ['service' => 'Makeup Lesson', 'date' => '2024-01-22', 'time' => '2:00 PM', 'location' => 'Home Service']
            ]
        ];

        return view('user.dashboard', compact('data'));
    }
}