<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $data = [
            'stats' => [
                'total_clients' => 156,
                'scheduled_services' => 23,
                'completed_services' => 89,
                'monthly_revenue' => 12450,
                'pending_inquiries' => 8,
                'active_subscriptions' => 45
            ],
            'recent_bookings' => [
                ['client' => 'Sarah Johnson', 'service' => 'Bridal Makeup', 'date' => '2024-01-15', 'status' => 'Confirmed'],
                ['client' => 'Emily Chen', 'service' => 'Party Makeup', 'date' => '2024-01-16', 'status' => 'Pending'],
                ['client' => 'Maria Rodriguez', 'service' => 'Photoshoot', 'date' => '2024-01-17', 'status' => 'Confirmed'],
                ['client' => 'Jennifer Lee', 'service' => 'Makeup Lesson', 'date' => '2024-01-18', 'status' => 'Completed']
            ],
            'revenue_data' => [
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                'values' => [8500, 9200, 10100, 11800, 12200, 12450]
            ]
        ];

        return view('admin.dashboard', compact('data'));
    }

    public function clients()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $clients = [
            ['id' => 1, 'name' => 'Sarah Johnson', 'email' => 'sarah@example.com', 'phone' => '+1 555-0101', 'services' => 3, 'total_spent' => 750],
            ['id' => 2, 'name' => 'Emily Chen', 'email' => 'emily@example.com', 'phone' => '+1 555-0102', 'services' => 2, 'total_spent' => 450],
            ['id' => 3, 'name' => 'Maria Rodriguez', 'email' => 'maria@example.com', 'phone' => '+1 555-0103', 'services' => 5, 'total_spent' => 1200]
        ];

        return view('admin.clients', compact('clients'));
    }

    public function orders()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $orders = [
            ['id' => 1, 'client' => 'Sarah Johnson', 'service' => 'Bridal Makeup', 'date' => '2024-01-15', 'amount' => 299, 'status' => 'Scheduled'],
            ['id' => 2, 'client' => 'Emily Chen', 'service' => 'Party Makeup', 'date' => '2024-01-16', 'amount' => 149, 'status' => 'Pending'],
            ['id' => 3, 'client' => 'Maria Rodriguez', 'service' => 'Photoshoot', 'date' => '2024-01-17', 'amount' => 199, 'status' => 'Completed']
        ];

        return view('admin.orders', compact('orders'));
    }
}