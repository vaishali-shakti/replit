<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Makeup Artist - Professional Beauty Services')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .gradient-pink { background: linear-gradient(135deg, #fce7f3 0%, #f3e8ff 50%, #fdf2f8 100%); }
        .text-gradient { background: linear-gradient(135deg, #ec4899, #be185d); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .pink-glow { box-shadow: 0 0 30px rgba(236, 72, 153, 0.3); }
        .slide { display: none; }
        .slide.active { display: block; }
    </style>
</head>
<body class="gradient-pink min-h-screen">
    <!-- Header -->
    <header class="bg-white/90 backdrop-blur-md shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-between py-4">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-gradient-to-r from-pink-400 to-rose-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-palette text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gradient">BeautyGlow</h1>
                        <p class="text-sm text-gray-600">Professional Makeup Artist</p>
                    </div>
                </div>

                <!-- Desktop Navigation -->
                <nav class="hidden lg:flex items-center space-x-8">
                    <a href="#home" class="text-gray-700 hover:text-pink-600 font-medium transition-colors duration-300">Home</a>
                    <a href="#about" class="text-gray-700 hover:text-pink-600 font-medium transition-colors duration-300">About</a>
                    <a href="#services" class="text-gray-700 hover:text-pink-600 font-medium transition-colors duration-300">Services</a>
                    <a href="#packages" class="text-gray-700 hover:text-pink-600 font-medium transition-colors duration-300">Packages</a>
                    <a href="#gallery" class="text-gray-700 hover:text-pink-600 font-medium transition-colors duration-300">Gallery</a>
                    <a href="#testimonials" class="text-gray-700 hover:text-pink-600 font-medium transition-colors duration-300">Reviews</a>
                    <a href="#contact" class="text-gray-700 hover:text-pink-600 font-medium transition-colors duration-300">Contact</a>
                </nav>

                <!-- Auth Buttons -->
                <div class="hidden lg:flex items-center space-x-4">
                    @if(session('user_logged_in'))
                        <a href="{{ route('user.dashboard') }}" class="bg-gradient-to-r from-pink-500 to-rose-600 text-white px-6 py-2 rounded-full font-semibold hover:from-pink-600 hover:to-rose-700 transition-all duration-300 shadow-lg">
                            Dashboard
                        </a>
                        <a href="{{ route('user.logout') }}" class="text-gray-700 hover:text-pink-600 font-medium">Logout</a>
                    @else
                        <a href="{{ route('user.login') }}" class="text-gray-700 hover:text-pink-600 font-medium">Login</a>
                        <a href="{{ route('user.register') }}" class="bg-gradient-to-r from-pink-500 to-rose-600 text-white px-6 py-2 rounded-full font-semibold hover:from-pink-600 hover:to-rose-700 transition-all duration-300 shadow-lg">
                            Register
                        </a>
                    @endif
                </div>

                <!-- Mobile Menu Button -->
                <button class="lg:hidden text-gray-700" onclick="toggleMobileMenu()">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>

            <!-- Mobile Navigation -->
            <div id="mobileMenu" class="lg:hidden hidden bg-white rounded-lg shadow-lg mt-2 p-4">
                <div class="flex flex-col space-y-4">
                    <a href="#home" class="text-gray-700 hover:text-pink-600 font-medium">Home</a>
                    <a href="#about" class="text-gray-700 hover:text-pink-600 font-medium">About</a>
                    <a href="#services" class="text-gray-700 hover:text-pink-600 font-medium">Services</a>
                    <a href="#packages" class="text-gray-700 hover:text-pink-600 font-medium">Packages</a>
                    <a href="#gallery" class="text-gray-700 hover:text-pink-600 font-medium">Gallery</a>
                    <a href="#testimonials" class="text-gray-700 hover:text-pink-600 font-medium">Reviews</a>
                    <a href="#contact" class="text-gray-700 hover:text-pink-600 font-medium">Contact</a>
                    <hr class="border-gray-200">
                    @if(session('user_logged_in'))
                        <a href="{{ route('user.dashboard') }}" class="bg-gradient-to-r from-pink-500 to-rose-600 text-white px-6 py-2 rounded-full font-semibold text-center">Dashboard</a>
                        <a href="{{ route('user.logout') }}" class="text-gray-700 hover:text-pink-600 font-medium">Logout</a>
                    @else
                        <a href="{{ route('user.login') }}" class="text-gray-700 hover:text-pink-600 font-medium">Login</a>
                        <a href="{{ route('user.register') }}" class="bg-gradient-to-r from-pink-500 to-rose-600 text-white px-6 py-2 rounded-full font-semibold text-center">Register</a>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4">
            <!-- Four Column Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
                
                <!-- Column 1: Company Info -->
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-r from-pink-400 to-rose-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-palette text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">BeautyGlow</h3>
                            <p class="text-sm text-gray-300">Professional Makeup Artist</p>
                        </div>
                    </div>
                    <p class="text-gray-300 text-sm mb-4 leading-relaxed">
                        Creating stunning looks for your special moments. Professional makeup artistry with a personal touch.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-8 h-8 bg-pink-600 rounded-full flex items-center justify-center hover:bg-pink-700 transition-colors duration-300">
                            <i class="fab fa-facebook-f text-sm"></i>
                        </a>
                        <a href="#" class="w-8 h-8 bg-pink-600 rounded-full flex items-center justify-center hover:bg-pink-700 transition-colors duration-300">
                            <i class="fab fa-instagram text-sm"></i>
                        </a>
                        <a href="#" class="w-8 h-8 bg-pink-600 rounded-full flex items-center justify-center hover:bg-pink-700 transition-colors duration-300">
                            <i class="fab fa-youtube text-sm"></i>
                        </a>
                    </div>
                </div>

                <!-- Column 2: Quick Links -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="#home" class="text-gray-300 hover:text-white transition-colors duration-300 text-sm">Home</a></li>
                        <li><a href="#about" class="text-gray-300 hover:text-white transition-colors duration-300 text-sm">About Us</a></li>
                        <li><a href="#services" class="text-gray-300 hover:text-white transition-colors duration-300 text-sm">Services</a></li>
                        <li><a href="#packages" class="text-gray-300 hover:text-white transition-colors duration-300 text-sm">Packages</a></li>
                        <li><a href="#gallery" class="text-gray-300 hover:text-white transition-colors duration-300 text-sm">Gallery</a></li>
                    </ul>
                </div>

                <!-- Column 3: Services -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Services</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-300 text-sm">Bridal Makeup</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-300 text-sm">Party Makeup</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-300 text-sm">Special Events</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-300 text-sm">Photoshoot Makeup</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-300 text-sm">Makeup Lessons</a></li>
                    </ul>
                </div>

                <!-- Column 4: Contact Info -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contact Info</h3>
                    <div class="space-y-3">
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-map-marker-alt text-pink-400 mt-1"></i>
                            <div>
                                <p class="text-gray-300 text-sm">123 Beauty Street</p>
                                <p class="text-gray-300 text-sm">Suite 100, City, State 12345</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-phone text-pink-400"></i>
                            <p class="text-gray-300 text-sm">+1 (555) 123-4567</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-envelope text-pink-400"></i>
                            <p class="text-gray-300 text-sm">hello@beautyglow.com</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-clock text-pink-400"></i>
                            <div>
                                <p class="text-gray-300 text-sm">Mon-Sat: 9AM-7PM</p>
                                <p class="text-gray-300 text-sm">Sunday: By Appointment</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Border and Copyright -->
            <div class="border-t border-gray-700 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <!-- Left: Copyright -->
                    <div class="text-sm text-gray-400 mb-4 md:mb-0">
                        © {{ date('Y') }} BeautyGlow. All rights reserved.
                    </div>
                    
                    <!-- Center: Privacy Links -->
                    <div class="flex space-x-6 mb-4 md:mb-0">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300 text-sm">Privacy Policy</a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300 text-sm">Terms of Service</a>
                    </div>
                    
                    <!-- Right: LaraCopilot Branding -->
                    <div class="text-sm text-gray-400">
                        Made with ❤️ <span class="text-white font-medium">LaraCopilot</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }

        // Smooth scrolling for anchor links
        $(document).ready(function() {
            $('a[href^="#"]').on('click', function(event) {
                var target = $(this.getAttribute('href'));
                if(target.length) {
                    event.preventDefault();
                    $('html, body').stop().animate({
                        scrollTop: target.offset().top - 100
                    }, 1000);
                }
            });
        });
    </script>
</body>
</html>