
<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CmsController;
use App\Http\Controllers\PhotosController;
use App\Http\Controllers\SuperCategoryController;
use App\Http\Controllers\MainCategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AppBannerController;
use App\Http\Controllers\EmailSignupsController;
use App\Http\Controllers\PlansController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\FrontLoginController;
use App\Http\Controllers\Front\GalleryController;
use App\Http\Controllers\Front\FrontCategoryController;
use App\Http\Controllers\Front\FrontDashboardController;
use App\Http\Controllers\Front\PaymentController;
use App\Http\Controllers\Front\ChatController;
use App\Http\Controllers\Front\FavouritesController;
use App\Http\Middleware\auth;
use App\Http\Middleware\web;
use App\Http\Middleware\SingleDeviceLogout;

Route::group(['prefix' => 'admin'], function () {
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('verify-otp', [LoginController::class, 'verifyPost'])->name('verify.post');
    Route::post('post-login', [LoginController::class, 'postLogin'])->name('login.post');
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('forgot-password', [LoginController::class, 'forgotPassword'])->name('forgot.password');
    Route::post('forgot-password', [LoginController::class, 'forgotPasswordPost'])->name('forgot.password.post');
    Route::get('/check-email', [UserController::class, 'checkEmail'])->name('check.email');

    Route::middleware([web::class])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('edit-profile', [DashboardController::class, 'editProfile'])->name('edit-profile');
        Route::post('update-profile', [DashboardController::class, 'updateProfile'])->name('update-profile');
        Route::get('change-password', [ResetController::class, 'index'])->name('reset');
        Route::post('post-reset', [ResetController::class, 'postReset'])->name('reset.post');
        Route::get('resetpasswordvalidation', [ResetController::class, 'resetpasswordvalidation'])->name('resetpasswordvalidation');

        // Route::get('generate-report/{user_id?}',[DashboardController::class,"generate_report"])->name('generate_report');
        // Route::post('report-start-date',[DashboardController::class,"report_start_date"])->name('report_start_date');
        // Route::post('generate-report',[DashboardController::class,"generate_report_post"])->name('generate.report.post');

        Route::resource('roles', RoleController::class);

        Route::resource('users', UserController::class);
        Route::get('/check-email-edit', [UserController::class, 'checkEmailEdit'])->name('check.email.edit');
        Route::get('update-status/{id?}', [UserController::class, 'updateStatus'])->name('users.updateStatus');


        Route::resource('category', SuperCategoryController::class);
        Route::resource('main_category', MainCategoryController::class);
        Route::resource('subcategory', SubCategoryController::class);
        Route::get('subcategory-status/{id?}', [SubCategoryController::class, 'updateStatus'])->name('subcategory.updateStatus');
        Route::resource('photos', PhotosController::class);
        Route::resource('banner', BannerController::class);
        Route::resource('cms', CmsController::class);
        Route::resource('support', ChatController::class);
        Route::post('admin-send-messages',[ChatController::class,"admin_send_messages"])->name('admin_send_messages');
        Route::post('admin-close-query',[ChatController::class,"admin_close_query"])->name('admin_close_query');

        Route::controller(CmsController::class)->group(function () {
            Route::get('title_unique_name', 'title_unique_name')->name('title_unique_name');
            Route::get('edit_title_unique_name', 'edit_title_unique_name')->name('edit_title_unique_name');
        });
        Route::resource('testimonial', TestimonialController::class);
        Route::resource('contact', ContactController::class);
        Route::resource('setting', SettingController::class);
        Route::get('title_unique_name_setting', [SettingController::class, 'title_unique_name_setting'])->name('title_unique_name_setting');
        Route::get('title_edit_unique_name', [SettingController::class, 'title_edit_unique_name'])->name('title_edit_unique_name');
        Route::get('key_unique', [SettingController::class, 'key_unique'])->name('key_unique');
        Route::get('edit_key_unique', [SettingController::class, 'edit_key_unique'])->name('edit_key_unique');
        Route::resource('email-signups', EmailSignupsController::class);
        Route::resource('app-banner', AppBannerController::class);
        Route::resource('plans', PlansController::class);
        Route::resource('reviews', ReviewsController::class);
        Route::get('main-category-status/{id}',[MainCategoryController::class,"status_change"])->name('main_category.status_change');
    });

});
Route::get('dynamic-sitemap', [HomeController::class, "dynamicSitemap"])->name('dynamic_sitemap');

Route::middleware([SingleDeviceLogout::class])->group(function () {
    Route::get('/', [HomeController::class, "index"])->name('home');
    Route::post('contact-post', [HomeController::class, "contact_post"])->name('contact.post');
    Route::post('email-signups', [HomeController::class, "email_signups"])->name('email_signups');
    Route::get('get_main_categories/{id?}', [HomeController::class, "get_main_categories"])->name('get_main_categories');
    Route::post('save_user_country', [HomeController::class, "save_user_country"])->name('save_user_country');
    Route::post('save_user_currency', [HomeController::class, "save_user_currency"])->name('save_user_currency');

    Route::get('category/{id}', [FrontCategoryController::class, "index"])->name('category');
    Route::get('pro-music', [FrontCategoryController::class, "pro_music_list"])->name('pro_music_list');
    Route::get('music-details/{id}', [FrontCategoryController::class, "music_details"])->name('music_details');

    Route::get('gallery', [GalleryController::class, "index"])->name('gallery');
    Route::post('gallery_load_more', [GalleryController::class, "gallery_load_more"])->name('gallery_load_more');
    Route::get('/cms/{slug_name}', [HomeController::class, 'cms'])->name('cms');

    Route::get('favourites', [FavouritesController::class, "index"])->name('favourites');
    Route::post('like-unlike-category', [FavouritesController::class, "like_unlike_category"])->name('like_unlike_category');

    Route::get('login', [FrontLoginController::class, "login"])->name('front_login');
    Route::post('login-post', [FrontLoginController::class, "login_post"])->name('front_login.post');
    Route::get('front_register', [FrontLoginController::class, "front_register"])->name('front_register');
    Route::post('register-post', [FrontLoginController::class, "register_post"])->name('front_register.post');
    Route::get('front_forgot_password', [FrontLoginController::class, "front_forgot_password"])->name('front_forgot_password');
    Route::post('front_forgot-password', [FrontLoginController::class, 'forgotPasswordPost'])->name('front.forgot.password.post');
    Route::post('save_checkout_detail', [FrontLoginController::class, 'save_checkout_detail'])->name('save_checkout_detail');
    Route::get('store-timezone',[FrontLoginController::class,"store_timezone"])->name('store_timezone');

    Route::get('login_google/{slug?}',[FrontLoginController::class, "redirectToGoogle"])->name('login.google');
    Route::get('login/google/callback',[FrontLoginController::class, "handleGoogleCallback"]);

    Route::middleware([auth::class])->group(function () {
        Route::get('user-dashboard/{slug?}', [HomeController::class, "user_dashboard"])->name('user_dashboard');
        Route::get('/check-email-edit', [FrontDashboardController::class, 'checkEmailEdit'])->name('front.check.email.edit');
        Route::post('front-update-profile/{id}',[FrontDashboardController::class,'front_update_profile'])->name('front_update_profile');
        Route::post('front-change-password',[FrontDashboardController::class,'front_change_password'])->name('front_change_password');
        Route::get('front-logout', [FrontLoginController::class, 'front_logout'])->name('front.logout');
        Route::post('/payment-callback', [PaymentController::class, 'payment_callback'])->name('payment_callback');
        Route::post('/fetch-payment-details', [PaymentController::class, 'fetch_payment_details'])->name('fetch_payment_details');
        Route::post('/payment-failure', [PaymentController::class, 'payment_failure'])->name('payment_failure');
        Route::post('send_message',[ChatController::class,"send_message"])->name('send_message');
        Route::post('audio-detail',[FrontCategoryController::class,"audio_detail"])->name("audio_detail");
        Route::post('video-detail',[FrontCategoryController::class,"video_detail"])->name("video_detail");
        Route::post('close-chat/{slug?}',[ChatController::class,"close_chat"])->name('close_chat');
        Route::post('update-ticket',[ChatController::class,"update_ticket"])->name('update_ticket');
        Route::post('chat-message-list',[ChatController::class,"chat_message_list"])->name('chat_message_list');
        Route::post('review-store',[FrontCategoryController::class,"review_store"])->name('review_store');
    });

    Route::get('/{slug?}',[FrontCategoryController::class,"categories"])->name("category");
    Route::get('/{slug}/{slug1?}',[FrontCategoryController::class,"main_categories"])->name("main_categories");
    Route::get('/{slug}/{slug1}/{slug2?}',[FrontCategoryController::class,"sub_categories"])->name("sub_categories");
});
