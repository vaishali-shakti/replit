<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'User Dashboard - BeautyGlow')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .gradient-pink { background: linear-gradient(135deg, #fce7f3 0%, #f3e8ff 50%, #fdf2f8 100%); }
        .text-gradient { background: linear-gradient(135deg, #ec4899, #be185d); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    </style>
</head>
<body class="gradient-pink min-h-screen">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg min-h-screen fixed left-0 top-0 z-40">
            <div class="p-6">
                <div class="flex items-center space-x-3 mb-8">
                    <div class="w-10 h-10 bg-gradient-to-r from-pink-500 to-rose-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">User Dashboard</h2>
                        <p class="text-sm text-gray-600">{{ session('user.name', 'User') }}</p>
                    </div>
                </div>

                <nav class="space-y-2">
                    <!-- Dashboard -->
                    <a href="{{ route('user.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 text-white bg-pink-600 rounded-lg hover:bg-pink-700 transition-colors duration-200">
                        <i class="fas fa-tachometer-alt w-5"></i>
                        <span>Dashboard</span>
                    </a>

                    <!-- Profile -->
                    <a href="{{ route('user.profile') ?? '#' }}" 
                       @if(!Route::has('user.profile')) onclick="alert('Profile management coming soon!')" @endif
                       class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:text-pink-600 hover:bg-pink-50 rounded-lg transition-colors duration-200">
                        <i class="fas fa-user w-5"></i>
                        <span>Update Profile</span>
                        @if(!Route::has('user.profile'))
                            <span class="ml-auto text-xs bg-orange-500 text-white px-2 py-1 rounded-full">Soon</span>
                        @endif
                    </a>

                    <!-- Change Password -->
                    <a href="{{ route('user.change-password') ?? '#' }}" 
                       @if(!Route::has('user.change-password')) onclick="alert('Change password coming soon!')" @endif
                       class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:text-pink-600 hover:bg-pink-50 rounded-lg transition-colors duration-200">
                        <i class="fas fa-lock w-5"></i>
                        <span>Change Password</span>
                        @if(!Route::has('user.change-password'))
                            <span class="ml-auto text-xs bg-orange-500 text-white px-2 py-1 rounded-full">Soon</span>
                        @endif
                    </a>

                    <!-- Orders -->
                    <a href="{{ route('user.orders') ?? '#' }}" 
                       @if(!Route::has('user.orders')) onclick="alert('Orders management coming soon!')" @endif
                       class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:text-pink-600 hover:bg-pink-50 rounded-lg transition-colors duration-200">
                        <i class="fas fa-shopping-bag w-5"></i>
                        <span>My Orders</span>
                        @if(!Route::has('user.orders'))
                            <span class="ml-auto text-xs bg-orange-500 text-white px-2 py-1 rounded-full">Soon</span>
                        @endif
                    </a>

                    <!-- Scheduled Services -->
                    <a href="{{ route('user.scheduled') ?? '#' }}" 
                       @if(!Route::has('user.scheduled')) onclick="alert('Scheduled services coming soon!')" @endif
                       class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:text-pink-600 hover:bg-pink-50 rounded-lg transition-colors duration-200">
                        <i class="fas fa-calendar w-5"></i>
                        <span>Scheduled Services</span>
                        @if(!Route::has('user.scheduled'))
                            <span class="ml-auto text-xs bg-orange-500 text-white px-2 py-1 rounded-full">Soon</span>
                        @endif
                    </a>

                    <!-- Service Reviews -->
                    <a href="{{ route('user.reviews') ?? '#' }}" 
                       @if(!Route::has('user.reviews')) onclick="alert('Service reviews coming soon!')" @endif
                       class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:text-pink-600 hover:bg-pink-50 rounded-lg transition-colors duration-200">
                        <i class="fas fa-star w-5"></i>
                        <span>Service Reviews</span>
                        @if(!Route::has('user.reviews'))
                            <span class="ml-auto text-xs bg-orange-500 text-white px-2 py-1 rounded-full">Soon</span>
                        @endif
                    </a>

                    <!-- Payment History -->
                    <a href="{{ route('user.payments') ?? '#' }}" 
                       @if(!Route::has('user.payments')) onclick="alert('Payment history coming soon!')" @endif
                       class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:text-pink-600 hover:bg-pink-50 rounded-lg transition-colors duration-200">
                        <i class="fas fa-credit-card w-5"></i>
                        <span>Payment History</span>
                        @if(!Route::has('user.payments'))
                            <span class="ml-auto text-xs bg-orange-500 text-white px-2 py-1 rounded-full">Soon</span>
                        @endif
                    </a>
                </nav>
            </div>

            <!-- Back to Website Button -->
            <div class="absolute bottom-0 left-0 right-0 p-6">
                <a href="/" class="w-full flex items-center justify-center space-x-2 px-4 py-3 bg-gradient-to-r from-pink-500 to-rose-600 hover:from-pink-600 hover:to-rose-700 text-white rounded-lg font-semibold transition-all duration-300 shadow-lg hover:shadow-xl">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Website</span>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="ml-64 flex-1">
            <!-- Top Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                        <p class="text-sm text-gray-600">@yield('page-description', 'Welcome to your dashboard')</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-700">{{ session('user.name', 'User') }}</p>
                            <p class="text-xs text-gray-500">{{ session('user.email', 'user@example.com') }}</p>
                        </div>
                        <div class="w-10 h-10 bg-gradient-to-r from-pink-400 to-rose-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <a href="{{ route('user.logout') }}" class="text-gray-600 hover:text-red-600 transition-colors duration-200">
                            <i class="fas fa-sign-out-alt"></i>
                        </a>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>