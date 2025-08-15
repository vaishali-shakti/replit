<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\UserController;

// Home Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// User Authentication Routes
Route::get('/user/login', [UserAuthController::class, 'showLogin'])->name('user.login');
Route::post('/user/login', [UserAuthController::class, 'login']);
Route::get('/user/register', [UserAuthController::class, 'showRegister'])->name('user.register');
Route::post('/user/register', [UserAuthController::class, 'register']);
Route::get('/user/forgot-password', [UserAuthController::class, 'showForgotPassword'])->name('user.forgot-password');
Route::post('/user/forgot-password', [UserAuthController::class, 'forgotPassword']);
Route::get('/user/logout', [UserAuthController::class, 'logout'])->name('user.logout');

// User Dashboard Routes
Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
Route::get('/user/profile', function() { return view('user.profile'); })->name('user.profile');
Route::get('/user/change-password', function() { return view('user.change-password'); })->name('user.change-password');
Route::get('/user/orders', function() { return view('user.orders'); })->name('user.orders');
Route::get('/user/scheduled', function() { return view('user.scheduled'); })->name('user.scheduled');
Route::get('/user/reviews', function() { return view('user.reviews'); })->name('user.reviews');
Route::get('/user/payments', function() { return view('user.payments'); })->name('user.payments');

// Admin Authentication Routes
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::get('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Admin Panel Routes
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/profile', function() { return view('admin.profile'); })->name('admin.profile');
Route::get('/admin/clients', [AdminController::class, 'clients'])->name('admin.clients');
Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');

// Admin Masters Module Routes
Route::get('/admin/banners', function() { return view('admin.banners'); })->name('admin.banners');
Route::get('/admin/content', function() { return view('admin.content'); })->name('admin.content');
Route::get('/admin/services', function() { return view('admin.services'); })->name('admin.services');
Route::get('/admin/packages', function() { return view('admin.packages'); })->name('admin.packages');
Route::get('/admin/testimonials', function() { return view('admin.testimonials'); })->name('admin.testimonials');
Route::get('/admin/inquiries', function() { return view('admin.inquiries'); })->name('admin.inquiries');
Route::get('/admin/subscribers', function() { return view('admin.subscribers'); })->name('admin.subscribers');