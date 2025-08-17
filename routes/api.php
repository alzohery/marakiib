<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SocialAuthController;
use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CarCategoryController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\CarTagController;
use App\Http\Controllers\Api\OptionController;
use App\Http\Controllers\Api\ExtraOptionController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\ReviewController;

Route::post('register', [AuthController::class, 'register']);
Route::post('verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('login', [AuthController::class, 'login']);

Route::controller(SocialAuthController::class)->group(function () {
    
    Route::get('/auth/{provider}/redirect', [SocialAuthController::class, 'redirectToProvider']);
    Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback']);

});
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'user']);

    Route::apiResource('cars', CarController::class);
    Route::prefix('cars/{car}')->group(function () {
        Route::post('categories', [CarCategoryController::class, 'attach'])->name('cars.categories.attach');
        Route::delete('categories', [CarCategoryController::class, 'detach'])->name('cars.categories.detach');
        Route::get('categories', [CarCategoryController::class, 'index'])->name('cars.categories.index');
        Route::post('tags', [CarTagController::class, 'attach'])->name('cars.tags.attach');
        Route::delete('tags', [CarTagController::class, 'detach'])->name('cars.tags.detach');
        Route::get('tags', [CarTagController::class, 'index'])->name('cars.tags.index');
    });

    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('tags', TagController::class);
    Route::apiResource('options', OptionController::class);
    Route::apiResource('extra-options', ExtraOptionController::class);
    Route::apiResource('bookings', BookingController::class);
    Route::apiResource('reviews', ReviewController::class);
});
