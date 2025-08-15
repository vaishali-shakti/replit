@extends('layouts.app')

@section('title', 'BeautyGlow - Professional Makeup Artist Services')

@section('content')
<!-- Hero Banner with Slider -->
<section id="home" class="relative min-h-screen overflow-hidden">
    <div class="slider-container relative w-full h-screen">
        <!-- Slide 1 -->
        <div class="slide active absolute inset-0 bg-gradient-to-br from-pink-900 via-rose-800 to-pink-900">
            <div class="absolute inset-0 bg-black/40"></div>
            <div class="relative z-10 flex items-center justify-center h-full">
                <div class="text-center text-white max-w-4xl mx-auto px-4">
                    <h1 class="text-5xl md:text-7xl font-bold mb-6 text-gradient">
                        Bridal Makeup Perfection
                    </h1>
                    <p class="text-xl md:text-2xl mb-8 text-pink-100">
                        Your special day deserves the perfect look
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <button class="bg-gradient-to-r from-pink-500 to-rose-600 hover:from-pink-600 hover:to-rose-700 text-white px-8 py-4 rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            Book Bridal Package
                        </button>
                        <button class="bg-white/20 backdrop-blur-md border border-white/30 text-white px-8 py-4 rounded-xl font-semibold hover:bg-white/30 transition-all duration-300">
                            View Portfolio
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slide 2 -->
        <div class="slide absolute inset-0 bg-gradient-to-br from-purple-900 via-pink-800 to-rose-900">
            <div class="absolute inset-0 bg-black/40"></div>
            <div class="relative z-10 flex items-center justify-center h-full">
                <div class="text-center text-white max-w-4xl mx-auto px-4">
                    <h1 class="text-5xl md:text-7xl font-bold mb-6">
                        Party & Event Makeup
                    </h1>
                    <p class="text-xl md:text-2xl mb-8 text-purple-100">
                        Stand out at every celebration
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <button class="bg-gradient-to-r from-purple-500 to-pink-600 hover:from-purple-600 hover:to-pink-700 text-white px-8 py-4 rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            Book Party Look
                        </button>
                        <button class="bg-white/20 backdrop-blur-md border border-white/30 text-white px-8 py-4 rounded-xl font-semibold hover:bg-white/30 transition-all duration-300">
                            See Packages
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slide 3 -->
        <div class="slide absolute inset-0 bg-gradient-to-br from-rose-900 via-pink-800 to-purple-900">
            <div class="absolute inset-0 bg-black/40"></div>
            <div class="relative z-10 flex items-center justify-center h-full">
                <div class="text-center text-white max-w-4xl mx-auto px-4">
                    <h1 class="text-5xl md:text-7xl font-bold mb-6">
                        Professional Photoshoot
                    </h1>
                    <p class="text-xl md:text-2xl mb-8 text-rose-100">
                        Camera-ready looks that capture perfection
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <button class="bg-gradient-to-r from-rose-500 to-purple-600 hover:from-rose-600 hover:to-purple-700 text-white px-8 py-4 rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            Book Photoshoot
                        </button>
                        <button class="bg-white/20 backdrop-blur-md border border-white/30 text-white px-8 py-4 rounded-xl font-semibold hover:bg-white/30 transition-all duration-300">
                            View Gallery
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Slider Navigation -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 flex space-x-3 z-20">
        <button onclick="currentSlide(1)" class="slider-dot w-3 h-3 bg-white/50 rounded-full hover:bg-white transition-all duration-300"></button>
        <button onclick="currentSlide(2)" class="slider-dot w-3 h-3 bg-white/50 rounded-full hover:bg-white transition-all duration-300"></button>
        <button onclick="currentSlide(3)" class="slider-dot w-3 h-3 bg-white/50 rounded-full hover:bg-white transition-all duration-300"></button>
    </div>

    <!-- Slider Arrows -->
    <button onclick="plusSlides(-1)" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white/20 backdrop-blur-md text-white p-3 rounded-full hover:bg-white/30 transition-all duration-300 z-20">
        <i class="fas fa-chevron-left"></i>
    </button>
    <button onclick="plusSlides(1)" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white/20 backdrop-blur-md text-white p-3 rounded-full hover:bg-white/30 transition-all duration-300 z-20">
        <i class="fas fa-chevron-right"></i>
    </button>
</section>

<!-- About Us Section -->
<section id="about" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6">
                    About <span class="text-gradient">BeautyGlow</span>
                </h2>
                <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                    With over 8 years of experience in the beauty industry, I specialize in creating stunning makeup looks that enhance your natural beauty. From intimate gatherings to grand celebrations, I bring artistry and passion to every client.
                </p>
                <div class="grid grid-cols-2 gap-6 mb-8">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-pink-600 mb-2">500+</div>
                        <p class="text-gray-600">Happy Clients</p>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-pink-600 mb-2">8+</div>
                        <p class="text-gray-600">Years Experience</p>
                    </div>
                </div>
                <button class="bg-gradient-to-r from-pink-500 to-rose-600 text-white px-8 py-3 rounded-lg font-semibold hover:from-pink-600 hover:to-rose-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                    Learn More About Me
                </button>
            </div>
            <div class="relative">
                <div class="w-full h-96 bg-gradient-to-br from-pink-100 to-rose-100 rounded-3xl flex items-center justify-center">
                    <i class="fas fa-user-circle text-pink-300 text-9xl"></i>
                </div>
                <div class="absolute -bottom-6 -right-6 w-24 h-24 bg-gradient-to-r from-pink-400 to-rose-500 rounded-2xl flex items-center justify-center shadow-xl">
                    <i class="fas fa-award text-white text-2xl"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section id="services" class="py-20 gradient-pink">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                Our <span class="text-gradient">Services</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Professional makeup artistry services tailored to your unique style and occasion
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Service 1 -->
            <div class="bg-white/90 backdrop-blur-md rounded-3xl p-8 shadow-2xl hover:shadow-3xl transition-all duration-500 hover:-translate-y-3 border border-pink-200/50">
                <div class="w-16 h-16 bg-gradient-to-r from-pink-500 to-rose-600 rounded-2xl flex items-center justify-center mb-6">
                    <i class="fas fa-ring text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Bridal Makeup</h3>
                <p class="text-gray-600 mb-6">Complete bridal makeup package including trial session, wedding day application, and touch-up kit.</p>
                <div class="text-2xl font-bold text-pink-600 mb-4">From $299</div>
                <button class="bg-gradient-to-r from-pink-500 to-rose-600 text-white px-6 py-2 rounded-lg font-semibold hover:from-pink-600 hover:to-rose-700 transition-all duration-300 w-full">
                    Book Now
                </button>
            </div>

            <!-- Service 2 -->
            <div class="bg-white/90 backdrop-blur-md rounded-3xl p-8 shadow-2xl hover:shadow-3xl transition-all duration-500 hover:-translate-y-3 border border-pink-200/50">
                <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center mb-6">
                    <i class="fas fa-glass-cheers text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Party Makeup</h3>
                <p class="text-gray-600 mb-6">Glamorous party looks perfect for special events, celebrations, and night outs.</p>
                <div class="text-2xl font-bold text-pink-600 mb-4">From $149</div>
                <button class="bg-gradient-to-r from-purple-500 to-pink-600 text-white px-6 py-2 rounded-lg font-semibold hover:from-purple-600 hover:to-pink-700 transition-all duration-300 w-full">
                    Book Now
                </button>
            </div>

            <!-- Service 3 -->
            <div class="bg-white/90 backdrop-blur-md rounded-3xl p-8 shadow-2xl hover:shadow-3xl transition-all duration-500 hover:-translate-y-3 border border-pink-200/50">
                <div class="w-16 h-16 bg-gradient-to-r from-rose-500 to-purple-600 rounded-2xl flex items-center justify-center mb-6">
                    <i class="fas fa-camera text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Photoshoot Makeup</h3>
                <p class="text-gray-600 mb-6">Professional makeup designed specifically for photography and videography sessions.</p>
                <div class="text-2xl font-bold text-pink-600 mb-4">From $199</div>
                <button class="bg-gradient-to-r from-rose-500 to-purple-600 text-white px-6 py-2 rounded-lg font-semibold hover:from-rose-600 hover:to-purple-700 transition-all duration-300 w-full">
                    Book Now
                </button>
            </div>

            <!-- Service 4 -->
            <div class="bg-white/90 backdrop-blur-md rounded-3xl p-8 shadow-2xl hover:shadow-3xl transition-all duration-500 hover:-translate-y-3 border border-pink-200/50">
                <div class="w-16 h-16 bg-gradient-to-r from-pink-400 to-rose-500 rounded-2xl flex items-center justify-center mb-6">
                    <i class="fas fa-graduation-cap text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Makeup Lessons</h3>
                <p class="text-gray-600 mb-6">Learn professional makeup techniques with personalized one-on-one training sessions.</p>
                <div class="text-2xl font-bold text-pink-600 mb-4">From $99</div>
                <button class="bg-gradient-to-r from-pink-400 to-rose-500 text-white px-6 py-2 rounded-lg font-semibold hover:from-pink-500 hover:to-rose-600 transition-all duration-300 w-full">
                    Book Now
                </button>
            </div>

            <!-- Service 5 -->
            <div class="bg-white/90 backdrop-blur-md rounded-3xl p-8 shadow-2xl hover:shadow-3xl transition-all duration-500 hover:-translate-y-3 border border-pink-200/50">
                <div class="w-16 h-16 bg-gradient-to-r from-indigo-500 to-pink-600 rounded-2xl flex items-center justify-center mb-6">
                    <i class="fas fa-users text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Group Bookings</h3>
                <p class="text-gray-600 mb-6">Special packages for bridal parties, group events, and corporate functions.</p>
                <div class="text-2xl font-bold text-pink-600 mb-4">Custom Pricing</div>
                <button class="bg-gradient-to-r from-indigo-500 to-pink-600 text-white px-6 py-2 rounded-lg font-semibold hover:from-indigo-600 hover:to-pink-700 transition-all duration-300 w-full">
                    Get Quote
                </button>
            </div>

            <!-- Service 6 -->
            <div class="bg-white/90 backdrop-blur-md rounded-3xl p-8 shadow-2xl hover:shadow-3xl transition-all duration-500 hover:-translate-y-3 border border-pink-200/50">
                <div class="w-16 h-16 bg-gradient-to-r from-teal-500 to-pink-600 rounded-2xl flex items-center justify-center mb-6">
                    <i class="fas fa-home text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Home Service</h3>
                <p class="text-gray-600 mb-6">Convenient at-home makeup services for your comfort and convenience.</p>
                <div class="text-2xl font-bold text-pink-600 mb-4">+$50 Travel Fee</div>
                <button class="bg-gradient-to-r from-teal-500 to-pink-600 text-white px-6 py-2 rounded-lg font-semibold hover:from-teal-600 hover:to-pink-700 transition-all duration-300 w-full">
                    Book Home Service
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Packages Section -->
<section id="packages" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                Special <span class="text-gradient">Packages</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Comprehensive packages designed to give you the best value for your special occasions
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Basic Package -->
            <div class="bg-gradient-to-br from-pink-50 to-rose-50 rounded-3xl p-8 border-2 border-pink-200 hover:border-pink-400 transition-all duration-300">
                <div class="text-center mb-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Basic Glam</h3>
                    <div class="text-4xl font-bold text-pink-600 mb-2">$149</div>
                    <p class="text-gray-600">Perfect for casual events</p>
                </div>
                <ul class="space-y-4 mb-8">
                    <li class="flex items-center">
                        <i class="fas fa-check text-pink-600 mr-3"></i>
                        <span>Professional makeup application</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-pink-600 mr-3"></i>
                        <span>Basic contouring & highlighting</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-pink-600 mr-3"></i>
                        <span>Lipstick touch-up included</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-pink-600 mr-3"></i>
                        <span>1 hour session</span>
                    </li>
                </ul>
                <button class="w-full bg-gradient-to-r from-pink-500 to-rose-600 text-white py-3 rounded-xl font-semibold hover:from-pink-600 hover:to-rose-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                    Choose Basic
                </button>
            </div>

            <!-- Premium Package -->
            <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-3xl p-8 border-2 border-purple-400 relative transform scale-105 shadow-2xl">
                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 bg-gradient-to-r from-purple-600 to-pink-600 text-white px-6 py-2 rounded-full text-sm font-semibold">
                    Most Popular
                </div>
                <div class="text-center mb-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Premium Glam</h3>
                    <div class="text-4xl font-bold text-purple-600 mb-2">$249</div>
                    <p class="text-gray-600">Perfect for special events</p>
                </div>
                <ul class="space-y-4 mb-8">
                    <li class="flex items-center">
                        <i class="fas fa-check text-purple-600 mr-3"></i>
                        <span>Complete makeup transformation</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-purple-600 mr-3"></i>
                        <span>Advanced contouring & highlighting</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-purple-600 mr-3"></i>
                        <span>Eye makeup with lashes</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-purple-600 mr-3"></i>
                        <span>Touch-up kit included</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-purple-600 mr-3"></i>
                        <span>1.5 hour session</span>
                    </li>
                </ul>
                <button class="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white py-3 rounded-xl font-semibold hover:from-purple-700 hover:to-pink-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                    Choose Premium
                </button>
            </div>

            <!-- Luxury Package -->
            <div class="bg-gradient-to-br from-rose-50 to-pink-50 rounded-3xl p-8 border-2 border-rose-200 hover:border-rose-400 transition-all duration-300">
                <div class="text-center mb-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Luxury Bridal</h3>
                    <div class="text-4xl font-bold text-rose-600 mb-2">$399</div>
                    <p class="text-gray-600">Complete bridal experience</p>
                </div>
                <ul class="space-y-4 mb-8">
                    <li class="flex items-center">
                        <i class="fas fa-check text-rose-600 mr-3"></i>
                        <span>Bridal trial session</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-rose-600 mr-3"></i>
                        <span>Wedding day makeup</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-rose-600 mr-3"></i>
                        <span>Premium lashes & styling</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-rose-600 mr-3"></i>
                        <span>Complete touch-up kit</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-rose-600 mr-3"></i>
                        <span>2+ hour session</span>
                    </li>
                </ul>
                <button class="w-full bg-gradient-to-r from-rose-500 to-pink-600 text-white py-3 rounded-xl font-semibold hover:from-rose-600 hover:to-pink-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                    Choose Luxury
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Video Section -->
<section id="video" class="py-20 gradient-pink">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                See Our <span class="text-gradient">Work</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Watch our makeup transformation videos and behind-the-scenes content
            </p>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="relative bg-white rounded-3xl shadow-2xl overflow-hidden">
                <div class="aspect-video bg-gradient-to-br from-pink-100 to-rose-100 flex items-center justify-center">
                    <button class="w-20 h-20 bg-gradient-to-r from-pink-500 to-rose-600 rounded-full flex items-center justify-center shadow-2xl hover:shadow-3xl transition-all duration-300 transform hover:scale-110 pink-glow">
                        <i class="fas fa-play text-white text-2xl ml-1"></i>
                    </button>
                </div>
                <div class="p-6">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Bridal Makeup Transformation</h3>
                    <p class="text-gray-600">Watch as we create the perfect bridal look for a beautiful bride on her special day.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Gallery Section -->
<section id="gallery" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                Our <span class="text-gradient">Gallery</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Browse through our portfolio of stunning makeup transformations
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Gallery Item 1 -->
            <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500">
                <div class="aspect-square bg-gradient-to-br from-pink-200 to-rose-200 flex items-center justify-center">
                    <i class="fas fa-image text-pink-400 text-4xl"></i>
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300">
                    <div class="absolute bottom-4 left-4 right-4 text-white">
                        <h3 class="text-lg font-semibold mb-1">Bridal Makeup</h3>
                        <p class="text-sm text-gray-200">Classic bridal look with soft glam</p>
                    </div>
                </div>
            </div>

            <!-- Gallery Item 2 -->
            <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500">
                <div class="aspect-square bg-gradient-to-br from-purple-200 to-pink-200 flex items-center justify-center">
                    <i class="fas fa-image text-purple-400 text-4xl"></i>
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300">
                    <div class="absolute bottom-4 left-4 right-4 text-white">
                        <h3 class="text-lg font-semibold mb-1">Party Glam</h3>
                        <p class="text-sm text-gray-200">Bold and glamorous party look</p>
                    </div>
                </div>
            </div>

            <!-- Gallery Item 3 -->
            <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500">
                <div class="aspect-square bg-gradient-to-br from-rose-200 to-pink-200 flex items-center justify-center">
                    <i class="fas fa-image text-rose-400 text-4xl"></i>
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300">
                    <div class="absolute bottom-4 left-4 right-4 text-white">
                        <h3 class="text-lg font-semibold mb-1">Photoshoot</h3>
                        <p class="text-sm text-gray-200">Professional photoshoot makeup</p>
                    </div>
                </div>
            </div>

            <!-- Gallery Item 4 -->
            <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500">
                <div class="aspect-square bg-gradient-to-br from-indigo-200 to-pink-200 flex items-center justify-center">
                    <i class="fas fa-image text-indigo-400 text-4xl"></i>
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300">
                    <div class="absolute bottom-4 left-4 right-4 text-white">
                        <h3 class="text-lg font-semibold mb-1">Natural Look</h3>
                        <p class="text-sm text-gray-200">Soft and natural everyday makeup</p>
                    </div>
                </div>
            </div>

            <!-- Gallery Item 5 -->
            <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500">
                <div class="aspect-square bg-gradient-to-br from-teal-200 to-pink-200 flex items-center justify-center">
                    <i class="fas fa-image text-teal-400 text-4xl"></i>
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300">
                    <div class="absolute bottom-4 left-4 right-4 text-white">
                        <h3 class="text-lg font-semibold mb-1">Editorial</h3>
                        <p class="text-sm text-gray-200">High-fashion editorial makeup</p>
                    </div>
                </div>
            </div>

            <!-- Gallery Item 6 -->
            <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500">
                <div class="aspect-square bg-gradient-to-br from-orange-200 to-pink-200 flex items-center justify-center">
                    <i class="fas fa-image text-orange-400 text-4xl"></i>
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300">
                    <div class="absolute bottom-4 left-4 right-4 text-white">
                        <h3 class="text-lg font-semibold mb-1">Special Event</h3>
                        <p class="text-sm text-gray-200">Elegant special occasion makeup</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-12">
            <button class="bg-gradient-to-r from-pink-500 to-rose-600 text-white px-8 py-3 rounded-xl font-semibold hover:from-pink-600 hover:to-rose-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                View Full Gallery
            </button>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section id="testimonials" class="py-20 gradient-pink">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                Client <span class="text-gradient">Testimonials</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                See what our happy clients have to say about their experience
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Testimonial 1 -->
            <div class="bg-white/90 backdrop-blur-md rounded-3xl p-8 shadow-xl border border-pink-200/50">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-gradient-to-r from-pink-400 to-rose-500 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-user text-white"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800">Sarah Johnson</h4>
                        <p class="text-sm text-gray-600">Bride</p>
                    </div>
                </div>
                <div class="flex mb-4">
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                </div>
                <p class="text-gray-600 italic">
                    "Absolutely amazing! She made me feel like a princess on my wedding day. The makeup lasted all day and looked perfect in photos. Highly recommend!"
                </p>
            </div>

            <!-- Testimonial 2 -->
            <div class="bg-white/90 backdrop-blur-md rounded-3xl p-8 shadow-xl border border-pink-200/50">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-gradient-to-r from-purple-400 to-pink-500 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-user text-white"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800">Emily Chen</h4>
                        <p class="text-sm text-gray-600">Event Client</p>
                    </div>
                </div>
                <div class="flex mb-4">
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                </div>
                <p class="text-gray-600 italic">
                    "Professional, talented, and so easy to work with. She understood exactly what I wanted and delivered beyond my expectations. Will definitely book again!"
                </p>
            </div>

            <!-- Testimonial 3 -->
            <div class="bg-white/90 backdrop-blur-md rounded-3xl p-8 shadow-xl border border-pink-200/50">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-gradient-to-r from-rose-400 to-pink-500 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-user text-white"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800">Maria Rodriguez</h4>
                        <p class="text-sm text-gray-600">Photoshoot Client</p>
                    </div>
                </div>
                <div class="flex mb-4">
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                </div>
                <p class="text-gray-600 italic">
                    "The makeup for my photoshoot was flawless! She knew exactly how to make me camera-ready. The photos turned out incredible. Thank you so much!"
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                Get In <span class="text-gradient">Touch</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Ready to book your appointment? Contact us today to discuss your makeup needs
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Form -->
            <div class="bg-gradient-to-br from-pink-50 to-rose-50 rounded-3xl p-8 border border-pink-200">
                <h3 class="text-2xl font-bold text-gray-800 mb-6">Send us a message</h3>
                <form class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                            <input type="text" class="w-full px-4 py-3 border border-pink-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                            <input type="text" class="w-full px-4 py-3 border border-pink-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" class="w-full px-4 py-3 border border-pink-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                        <input type="tel" class="w-full px-4 py-3 border border-pink-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Service Interested In</label>
                        <select class="w-full px-4 py-3 border border-pink-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                            <option>Select a service</option>
                            <option>Bridal Makeup</option>
                            <option>Party Makeup</option>
                            <option>Photoshoot Makeup</option>
                            <option>Makeup Lessons</option>
                            <option>Group Booking</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                        <textarea rows="4" class="w-full px-4 py-3 border border-pink-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-gradient-to-r from-pink-500 to-rose-600 text-white py-3 rounded-lg font-semibold hover:from-pink-600 hover:to-rose-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                        Send Message
                    </button>
                </form>
            </div>

            <!-- Contact Info -->
            <div class="space-y-8">
                <div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Contact Information</h3>
                    <div class="space-y-6">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-r from-pink-500 to-rose-600 rounded-xl flex items-center justify-center">
                                <i class="fas fa-map-marker-alt text-white"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800 mb-1">Address</h4>
                                <p class="text-gray-600">123 Beauty Street<br>Suite 100, City, State 12345</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-r from-pink-500 to-rose-600 rounded-xl flex items-center justify-center">
                                <i class="fas fa-phone text-white"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800 mb-1">Phone</h4>
                                <p class="text-gray-600">+1 (555) 123-4567</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-r from-pink-500 to-rose-600 rounded-xl flex items-center justify-center">
                                <i class="fas fa-envelope text-white"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800 mb-1">Email</h4>
                                <p class="text-gray-600">hello@beautyglow.com</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-r from-pink-500 to-rose-600 rounded-xl flex items-center justify-center">
                                <i class="fas fa-clock text-white"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800 mb-1">Working Hours</h4>
                                <p class="text-gray-600">Mon-Sat: 9AM-7PM<br>Sunday: By Appointment</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Map Placeholder -->
                <div class="bg-gradient-to-br from-pink-100 to-rose-100 rounded-2xl h-64 flex items-center justify-center">
                    <div class="text-center">
                        <i class="fas fa-map text-pink-400 text-4xl mb-4"></i>
                        <p class="text-gray-600">Interactive Map Coming Soon</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Subscribe Section -->
<section id="subscribe" class="py-20 gradient-pink">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <div class="bg-white/90 backdrop-blur-md rounded-3xl p-12 shadow-2xl border border-pink-200/50">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                Stay Updated with <span class="text-gradient">BeautyGlow</span>
            </h2>
            <p class="text-lg text-gray-600 mb-8">
                Subscribe to our newsletter for beauty tips, special offers, and latest updates
            </p>
            <div class="flex flex-col md:flex-row gap-4 max-w-lg mx-auto">
                <input type="email" placeholder="Enter your email address" class="flex-1 px-6 py-4 border border-pink-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                <button class="bg-gradient-to-r from-pink-500 to-rose-600 text-white px-8 py-4 rounded-xl font-semibold hover:from-pink-600 hover:to-rose-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                    Subscribe
                </button>
            </div>
            <p class="text-sm text-gray-500 mt-4">
                We respect your privacy. Unsubscribe at any time.
            </p>
        </div>
    </div>
</section>

<script>
// Slider functionality
let slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
    showSlides(slideIndex += n);
}

function currentSlide(n) {
    showSlides(slideIndex = n);
}

function showSlides(n) {
    let slides = document.getElementsByClassName("slide");
    let dots = document.getElementsByClassName("slider-dot");
    if (n > slides.length) {slideIndex = 1}
    if (n < 1) {slideIndex = slides.length}
    for (let i = 0; i < slides.length; i++) {
        slides[i].classList.remove("active");
    }
    for (let i = 0; i < dots.length; i++) {
        dots[i].classList.remove("bg-white");
        dots[i].classList.add("bg-white/50");
    }
    slides[slideIndex-1].classList.add("active");
    dots[slideIndex-1].classList.remove("bg-white/50");
    dots[slideIndex-1].classList.add("bg-white");
}

// Auto-advance slides
setInterval(function() {
    plusSlides(1);
}, 5000);

// Form submission handling
$(document).ready(function() {
    $('form').on('submit', function(e) {
        e.preventDefault();
        alert('Thank you for your message! We will get back to you soon.');
    });
});
</script>
@endsection