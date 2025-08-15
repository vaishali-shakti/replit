<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel - BeautyGlow')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .gradient-pink { background: linear-gradient(135deg, #fce7f3 0%, #f3e8ff 50%, #fdf2f8 100%); }
        .text-gradient { background: linear-gradient(135deg, #ec4899, #be185d); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gradient-to-b from-gray-800 to-gray-900 text-white min-h-screen fixed left-0 top-0 z-40">
            <div class="p-6">
                <div class="flex items-center space-x-3 mb-8">
                    <div class="w-10 h-10 bg-gradient-to-r from-pink-500 to-rose-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-palette text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold">Admin Panel</h2>
                        <p class="text-sm text-gray-300">BeautyGlow Management</p>
                    </div>
                </div>

                <nav class="space-y-2">
                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 text-white bg-pink-600 rounded-lg hover:bg-pink-700 transition-colors duration-200">
                        <i class="fas fa-tachometer-alt w-5"></i>
                        <span>Dashboard</span>
                    </a>

                    <!-- Profile Management -->
                    <a href="{{ route('admin.profile') ?? '#' }}" 
                       @if(!Route::has('admin.profile')) onclick="alert('Profile management coming soon!')" @endif
                       class="flex items-center space-x-3 px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-700 rounded-lg transition-colors duration-200">
                        <i class="fas fa-user w-5"></i>
                        <span>Profile</span>
                        @if(!Route::has('admin.profile'))
                            <span class="ml-auto text-xs bg-orange-500 text-white px-2 py-1 rounded-full">Soon</span>
                        @endif
                    </a>

                    <!-- Clients -->
                    <a href="{{ route('admin.clients') ?? '#' }}" 
                       @if(!Route::has('admin.clients')) onclick="alert('Clients management coming soon!')" @endif
                       class="flex items-center space-x-3 px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-700 rounded-lg transition-colors duration-200">
                        <i class="fas fa-users w-5"></i>
                        <span>Clients</span>
                        @if(!Route::has('admin.clients'))
                            <span class="ml-auto text-xs bg-orange-500 text-white px-2 py-1 rounded-full">Soon</span>
                        @endif
                    </a>

                    <!-- Orders -->
                    <a href="{{ route('admin.orders') ?? '#' }}" 
                       @if(!Route::has('admin.orders')) onclick="alert('Orders management coming soon!')" @endif
                       class="flex items-center space-x-3 px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-700 rounded-lg transition-colors duration-200">
                        <i class="fas fa-shopping-bag w-5"></i>
                        <span>Orders</span>
                        @if(!Route::has('admin.orders'))
                            <span class="ml-auto text-xs bg-orange-500 text-white px-2 py-1 rounded-full">Soon</span>
                        @endif
                    </a>

                    <!-- Masters Module -->
                    <div class="pt-4 pb-2">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-4">Masters Module</p>
                    </div>

                    <a href="{{ route('admin.banners') ?? '#' }}" 
                       @if(!Route::has('admin.banners')) onclick="alert('Banner management coming soon!')" @endif
                       class="flex items-center space-x-3 px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-700 rounded-lg transition-colors duration-200">
                        <i class="fas fa-images w-5"></i>
                        <span>Manage Banners</span>
                        @if(!Route::has('admin.banners'))
                            <span class="ml-auto text-xs bg-orange-500 text-white px-2 py-1 rounded-full">Soon</span>
                        @endif
                    </a>

                    <a href="{{ route('admin.content') ?? '#' }}" 
                       @if(!Route::has('admin.content')) onclick="alert('Content management coming soon!')" @endif
                       class="flex items-center space-x-3 px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-700 rounded-lg transition-colors duration-200">
                        <i class="fas fa-file-alt w-5"></i>
                        <span>Manage Content</span>
                        @if(!Route::has('admin.content'))
                            <span class="ml-auto text-xs bg-orange-500 text-white px-2 py-1 rounded-full">Soon</span>
                        @endif
                    </a>

                    <a href="{{ route('admin.services') ?? '#' }}" 
                       @if(!Route::has('admin.services')) onclick="alert('Services management coming soon!')" @endif
                       class="flex items-center space-x-3 px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-700 rounded-lg transition-colors duration-200">
                        <i class="fas fa-concierge-bell w-5"></i>
                        <span>Manage Services</span>
                        @if(!Route::has('admin.services'))
                            <span class="ml-auto text-xs bg-orange-500 text-white px-2 py-1 rounded-full">Soon</span>
                        @endif
                    </a>

                    <a href="{{ route('admin.packages') ?? '#' }}" 
                       @if(!Route::has('admin.packages')) onclick="alert('Packages management coming soon!')" @endif
                       class="flex items-center space-x-3 px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-700 rounded-lg transition-colors duration-200">
                        <i class="fas fa-box w-5"></i>
                        <span>Manage Packages</span>
                        @if(!Route::has('admin.packages'))
                            <span class="ml-auto text-xs bg-orange-500 text-white px-2 py-1 rounded-full">Soon</span>
                        @endif
                    </a>

                    <a href="{{ route('admin.testimonials') ?? '#' }}" 
                       @if(!Route::has('admin.testimonials')) onclick="alert('Testimonials management coming soon!')" @endif
                       class="flex items-center space-x-3 px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-700 rounded-lg transition-colors duration-200">
                        <i class="fas fa-star w-5"></i>
                        <span>Manage Testimonials</span>
                        @if(!Route::has('admin.testimonials'))
                            <span class="ml-auto text-xs bg-orange-500 text-white px-2 py-1 rounded-full">Soon</span>
                        @endif
                    </a>

                    <a href="{{ route('admin.inquiries') ?? '#' }}" 
                       @if(!Route::has('admin.inquiries')) onclick="alert('Inquiries management coming soon!')" @endif
                       class="flex items-center space-x-3 px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-700 rounded-lg transition-colors duration-200">
                        <i class="fas fa-envelope w-5"></i>
                        <span>Contact Inquiries</span>
                        @if(!Route::has('admin.inquiries'))
                            <span class="ml-auto text-xs bg-orange-500 text-white px-2 py-1 rounded-full">Soon</span>
                        @endif
                    </a>

                    <a href="{{ route('admin.subscribers') ?? '#' }}" 
                       @if(!Route::has('admin.subscribers')) onclick="alert('Subscribers management coming soon!')" @endif
                       class="flex items-center space-x-3 px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-700 rounded-lg transition-colors duration-200">
                        <i class="fas fa-bell w-5"></i>
                        <span>Subscribers</span>
                        @if(!Route::has('admin.subscribers'))
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
                        <p class="text-sm text-gray-600">@yield('page-description', 'Welcome to your admin panel')</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-700">{{ session('admin_user.name', 'Admin User') }}</p>
                            <p class="text-xs text-gray-500">{{ session('admin_user.email', 'admin@beautyglow.com') }}</p>
                        </div>
                        <div class="w-10 h-10 bg-gradient-to-r from-pink-400 to-rose-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <a href="{{ route('admin.logout') }}" class="text-gray-600 hover:text-red-600 transition-colors duration-200">
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