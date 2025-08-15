@extends('layouts.app')

@section('title', '404 - Page Not Found')

@section('content')
<div class="min-h-screen gradient-pink flex items-center justify-center px-4">
    <div class="text-center max-w-2xl mx-auto">
        <!-- 404 Icon -->
        <div class="mb-8">
            <div class="w-32 h-32 bg-gradient-to-r from-pink-400 to-rose-500 rounded-full flex items-center justify-center mx-auto mb-6 pink-glow">
                <i class="fas fa-palette text-white text-6xl"></i>
            </div>
        </div>

        <!-- Error Content -->
        <h1 class="text-4xl md:text-6xl font-bold text-gray-800 mb-4">404</h1>
        <h2 class="text-2xl md:text-3xl font-semibold text-gray-600 mb-6">Page Not Found</h2>
        <p class="text-lg text-gray-500 mb-8 leading-relaxed">
            Sorry, the page you are looking for doesn't exist or has been moved. 
            Let's get you back to discovering beautiful makeup services!
        </p>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center mb-8">
            <a href="/" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-pink-500 to-rose-600 hover:from-pink-600 hover:to-rose-700 text-white rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-home mr-2"></i>
                Go Home
            </a>
            <button onclick="history.back()" class="inline-flex items-center px-6 py-3 bg-white border border-pink-300 hover:bg-pink-50 text-pink-700 rounded-xl font-semibold transition-all duration-300 shadow-md hover:shadow-lg">
                <i class="fas fa-arrow-left mr-2"></i>
                Go Back
            </button>
        </div>

        <!-- Search Box -->
        <div class="max-w-md mx-auto">
            <div class="relative">
                <input type="text" placeholder="Search our services..." class="w-full px-4 py-3 pl-12 border border-pink-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                <i class="fas fa-search text-pink-400 absolute left-4 top-1/2 transform -translate-y-1/2"></i>
            </div>
        </div>
    </div>
</div>
@endsection