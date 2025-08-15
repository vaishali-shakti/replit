<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AppBannerController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CmsController;
use App\Http\Controllers\Api\SuperCategoryController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\SubCategoryController;
use App\Http\Controllers\Api\PhotosController;
use App\Http\Controllers\Api\SocialAuthController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\LikesController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\SupportController;
use App\Http\Middleware\API;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('app-banner', [AppBannerController::class, 'index']);
Route::post('social-register', [SocialAuthController::class, 'register']);
Route::post('social-login', [SocialAuthController::class, 'login']);
Route::post('forgot-password',[AuthController::class,'forgot_password']);
Route::get('user-delete/{id}',[UserController::class,'delete_user']);
Route::post('cms', [CmsController::class, 'index']);

Route::middleware([API::class])->group(function () {

    Route::post('banner', [AppBannerController::class, 'banner']);
    Route::post('contact-create', [ContactController::class, 'index']);
    Route::post('super-category', [SuperCategoryController::class, 'index']);
    Route::post('main-category', [SuperCategoryController::class, 'main_category']);
    Route::post('special-category', [SuperCategoryController::class, 'special_category']);
    Route::post('sub-category', [SubCategoryController::class, 'sub_category']);
    Route::post('photos', [PhotosController::class, 'index']);

    Route::post('user_data', [UserController::class, 'user_data']);
    Route::post('updateprofile', [UserController::class, 'updateprofile']);
    Route::post('remove-profile-img', [UserController::class, 'remove_profile_img']);
    Route::post('changepassword', [AuthController::class, 'changepassword']);
    Route::post('sub-categories', [SubCategoryController::class, 'sub_categories']);
    Route::post('delete-user', [UserController::class, 'user_delete']);
    Route::post('rate-category', [RatingController::class, 'rate_category']);
    Route::post('like-unlike-category', [LikesController::class, 'like_unlike_category']);
    Route::post('favorites-list', [LikesController::class, 'favorites_list']);
    Route::post('search-category', [SearchController::class, 'search_category']);
    Route::post('store-payment', [PaymentController::class, 'store_payment']);
    Route::post('generate-recpt-no', [PaymentController::class, 'generate_recpt_no']);
    Route::post('user-subscriptions', [PaymentController::class, 'user_subscriptions']);
    Route::post('plans', [AppBannerController::class, 'plans']);

    Route::post('raise-new-ticket', [SupportController::class, 'raise_new_ticket']);
    Route::post('support-list', [SupportController::class, 'support_list']);
    Route::post('messages-list', [SupportController::class, 'messages_list']);
    Route::post('send-message', [SupportController::class, 'send_message']);
    Route::post('close-query', [SupportController::class, 'close_query']);

    Route::post('logout', [AuthController::class, 'logout']);
});

