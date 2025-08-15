<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - BeautyGlow</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .gradient-pink { background: linear-gradient(135deg, #fce7f3 0%, #f3e8ff 50%, #fdf2f8 100%); }
    </style>
</head>
<body class="gradient-pink min-h-screen flex items-center justify-center px-4">
    <div class="max-w-md w-full">
        <!-- Forgot Password Card -->
        <div class="bg-white/90 backdrop-blur-md rounded-3xl shadow-2xl p-8 border border-pink-200/50">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-gradient-to-r from-pink-500 to-rose-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-key text-white text-2xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-800">Forgot Password?</h1>
                <p class="text-gray-600">Enter your email to reset your password</p>
            </div>

            <!-- Reset Form -->
            <form action="/user/forgot-password" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <input type="email" name="email" required class="w-full px-4 py-3 border border-pink-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent" placeholder="Enter your email">
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-pink-500 to-rose-600 text-white py-3 rounded-xl font-semibold hover:from-pink-600 hover:to-rose-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                    Send Reset Link
                </button>
            </form>

            <!-- Back to Login -->
            <div class="mt-6 text-center">
                <a href="{{ route('user.login') }}" class="text-pink-600 hover:text-pink-700 font-medium">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Login
                </a>
            </div>

            <!-- Back to Website -->
            <div class="mt-4 text-center">
                <a href="/" class="text-gray-500 hover:text-gray-700 text-sm">
                    <i class="fas fa-home mr-2"></i>Back to Website
                </a>
            </div>
        </div>
    </div>
</body>
</html>