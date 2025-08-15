<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - BeautyGlow</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .gradient-pink { background: linear-gradient(135deg, #fce7f3 0%, #f3e8ff 50%, #fdf2f8 100%); }
        .text-gradient { background: linear-gradient(135deg, #ec4899, #be185d); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    </style>
</head>
<body class="gradient-pink min-h-screen flex items-center justify-center px-4">
    <div class="max-w-md w-full">
        <!-- Login Card -->
        <div class="bg-white/90 backdrop-blur-md rounded-3xl shadow-2xl p-8 border border-pink-200/50">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-gradient-to-r from-pink-500 to-rose-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-palette text-white text-2xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-800">Admin Login</h1>
                <p class="text-gray-600">BeautyGlow Management System</p>
            </div>

            <!-- Demo Credentials -->
            <div class="mb-6 p-4 bg-blue-50 rounded-xl border border-blue-200">
                <h3 class="font-semibold text-blue-800 mb-2">Demo Credentials:</h3>
                <div class="space-y-1 text-sm text-blue-700">
                    @foreach($credentials as $cred)
                        <div>{{ $cred['email'] }} | {{ $cred['password'] }}</div>
                    @endforeach
                </div>
            </div>

            <!-- Login Form -->
            <form action="/admin/login" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <input type="email" name="email" required class="w-full px-4 py-3 border border-pink-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent" placeholder="Enter your email">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" required class="w-full px-4 py-3 border border-pink-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent" placeholder="Enter your password">
                </div>

                @if($errors->any())
                    <div class="text-red-600 text-sm">{{ $errors->first() }}</div>
                @endif

                <button type="submit" class="w-full bg-gradient-to-r from-pink-500 to-rose-600 text-white py-3 rounded-xl font-semibold hover:from-pink-600 hover:to-rose-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                    Login to Admin Panel
                </button>
            </form>

            <!-- Back to Website -->
            <div class="mt-6 text-center">
                <a href="/" class="text-pink-600 hover:text-pink-700 font-medium">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Website
                </a>
            </div>
        </div>
    </div>
</body>
</html>