@extends('layouts.user')

@section('title', 'User Dashboard - BeautyGlow')
@section('page-title', 'Welcome Back, ' . session('user.name', 'User'))
@section('page-description', 'Manage your bookings and account')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Bookings -->
    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Bookings</p>
                <p class="text-3xl font-bold text-gray-800">{{ $data['stats']['total_bookings'] }}</p>
            </div>
            <div class="w-12 h-12 bg-pink-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-calendar-check text-pink-600 text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Completed Services -->
    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Completed</p>
                <p class="text-3xl font-bold text-gray-800">{{ $data['stats']['completed_services'] }}</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-check-circle text-green-600 text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Scheduled Services -->
    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Scheduled</p>
                <p class="text-3xl font-bold text-gray-800">{{ $data['stats']['scheduled_services'] }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-clock text-blue-600 text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Total Spent -->
    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Spent</p>
                <p class="text-3xl font-bold text-gray-800">${{ number_format($data['stats']['total_spent']) }}</p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-dollar-sign text-purple-600 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <button class="bg-gradient-to-r from-pink-500 to-rose-600 text-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <i class="fas fa-plus text-2xl mb-3"></i>
        <h3 class="text-lg font-semibold mb-2">Book New Service</h3>
        <p class="text-pink-100">Schedule your next appointment</p>
    </button>

    <button class="bg-gradient-to-r from-purple-500 to-pink-600 text-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <i class="fas fa-star text-2xl mb-3"></i>
        <h3 class="text-lg font-semibold mb-2">Leave Review</h3>
        <p class="text-purple-100">Share your experience</p>
    </button>

    <button class="bg-gradient-to-r from-blue-500 to-purple-600 text-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <i class="fas fa-credit-card text-2xl mb-3"></i>
        <h3 class="text-lg font-semibold mb-2">Payment Methods</h3>
        <p class="text-blue-100">Manage your payments</p>
    </button>
</div>

<!-- Recent Orders and Upcoming Appointments -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Recent Orders -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Recent Orders</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @foreach($data['recent_orders'] as $order)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-r from-pink-400 to-rose-500 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-palette text-white"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800">{{ $order['service'] }}</h4>
                            <p class="text-sm text-gray-600">{{ $order['date'] }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-gray-800">${{ $order['amount'] }}</p>
                        <span class="text-xs px-2 py-1 rounded-full 
                            @if($order['status'] === 'Completed') bg-green-100 text-green-800
                            @else bg-blue-100 text-blue-800 @endif">
                            {{ $order['status'] }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Upcoming Appointments -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Upcoming Appointments</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @foreach($data['upcoming_appointments'] as $appointment)
                <div class="p-4 bg-gradient-to-r from-pink-50 to-rose-50 rounded-xl border border-pink-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="font-semibold text-gray-800">{{ $appointment['service'] }}</h4>
                            <p class="text-sm text-gray-600">{{ $appointment['date'] }} at {{ $appointment['time'] }}</p>
                            <p class="text-sm text-pink-600">{{ $appointment['location'] }}</p>
                        </div>
                        <div class="flex space-x-2">
                            <button class="px-3 py-1 bg-pink-600 text-white rounded-lg text-sm hover:bg-pink-700">
                                Reschedule
                            </button>
                            <button class="px-3 py-1 bg-gray-600 text-white rounded-lg text-sm hover:bg-gray-700">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection