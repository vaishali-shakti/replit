@extends('layouts.admin')

@section('title', 'Admin Dashboard - BeautyGlow')
@section('page-title', 'Dashboard')
@section('page-description', 'Overview of your makeup artistry business')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
    <!-- Total Clients -->
    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Clients</p>
                <p class="text-3xl font-bold text-gray-800">{{ $data['stats']['total_clients'] }}</p>
                <p class="text-sm text-green-600">+12% from last month</p>
            </div>
            <div class="w-12 h-12 bg-pink-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-users text-pink-600 text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Scheduled Services -->
    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Scheduled Services</p>
                <p class="text-3xl font-bold text-gray-800">{{ $data['stats']['scheduled_services'] }}</p>
                <p class="text-sm text-blue-600">Next 30 days</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-calendar text-blue-600 text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Completed Services -->
    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Completed Services</p>
                <p class="text-3xl font-bold text-gray-800">{{ $data['stats']['completed_services'] }}</p>
                <p class="text-sm text-green-600">This month</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-check-circle text-green-600 text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Monthly Revenue -->
    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Monthly Revenue</p>
                <p class="text-3xl font-bold text-gray-800">${{ number_format($data['stats']['monthly_revenue']) }}</p>
                <p class="text-sm text-green-600">+8% from last month</p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-dollar-sign text-purple-600 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Revenue Chart -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Monthly Revenue Trend</h3>
        <div class="w-full overflow-x-auto">
            <div style="width: 500px; height: 300px; min-width: 500px;">
                <canvas id="revenueChart" width="500" height="300"></canvas>
            </div>
        </div>
        <p class="text-sm text-gray-500 mt-4">*Fixed dimensions optimized for desktop viewing</p>
    </div>

    <!-- Service Distribution -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Service Distribution</h3>
        <div class="w-full overflow-x-auto">
            <div style="width: 500px; height: 300px; min-width: 500px;">
                <canvas id="serviceChart" width="500" height="300"></canvas>
            </div>
        </div>
        <p class="text-sm text-gray-500 mt-4">*Fixed dimensions optimized for desktop viewing</p>
    </div>
</div>

<!-- Recent Bookings -->
<div class="bg-white rounded-2xl shadow-lg border border-gray-100">
    <div class="p-6 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800">Recent Bookings</h3>
            <a href="{{ route('admin.orders') ?? '#' }}" class="text-pink-600 hover:text-pink-700 font-medium text-sm">View All</a>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($data['recent_bookings'] as $booking)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-r from-pink-400 to-rose-500 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-user text-white"></i>
                            </div>
                            <div class="text-sm font-medium text-gray-900">{{ $booking['client'] }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $booking['service'] }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $booking['date'] }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @if($booking['status'] === 'Confirmed') bg-green-100 text-green-800
                            @elseif($booking['status'] === 'Pending') bg-yellow-100 text-yellow-800
                            @else bg-blue-100 text-blue-800 @endif">
                            {{ $booking['status'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button class="text-pink-600 hover:text-pink-900 mr-3">Edit</button>
                        <button class="text-red-600 hover:text-red-900">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
// Revenue Chart
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
const revenueChart = new Chart(revenueCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($data['revenue_data']['labels']) !!},
        datasets: [{
            label: 'Revenue ($)',
            data: {!! json_encode($data['revenue_data']['values']) !!},
            borderColor: 'rgb(236, 72, 153)',
            backgroundColor: 'rgba(236, 72, 153, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: false,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: true
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Service Distribution Chart
const serviceCtx = document.getElementById('serviceChart').getContext('2d');
const serviceChart = new Chart(serviceCtx, {
    type: 'doughnut',
    data: {
        labels: ['Bridal Makeup', 'Party Makeup', 'Photoshoot', 'Lessons', 'Other'],
        datasets: [{
            data: [35, 25, 20, 15, 5],
            backgroundColor: [
                'rgb(236, 72, 153)',
                'rgb(168, 85, 247)',
                'rgb(59, 130, 246)',
                'rgb(16, 185, 129)',
                'rgb(245, 158, 11)'
            ]
        }]
    },
    options: {
        responsive: false,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>
@endsection