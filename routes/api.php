<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\FavouriteController;
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
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\FeatureController;
use App\Http\Controllers\Api\PublicController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\WalletController;
use App\Http\Controllers\Api\SupportController;
use App\Http\Controllers\Api\PagesController;
use App\Http\Controllers\Api\FAQController;
// use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\PaymentController; 
// ------------------------
// Public Endpoints
// ------------------------

// Auth
Route::post('register', [AuthController::class, 'register']);
Route::post('testPixel', [AuthController::class, 'testPixel']);
Route::post('verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('login', [AuthController::class, 'login']);
Route::post('resend-otp', [AuthController::class, 'resendOtp']);
Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('reset-password', [AuthController::class, 'resetPassword']);

// Social Auth
Route::controller(SocialAuthController::class)->group(function () {
    Route::get('/auth/{provider}/redirect', 'redirectToProvider');
    Route::get('/auth/{provider}/callback', 'handleProviderCallback');
});

// Features (Public)
Route::prefix('features')->group(function () {
    Route::get('/', [FeatureController::class, 'index']);          // كل الـ features
    Route::delete('/{feature}', [FeatureController::class, 'destroy']); // feature واحدة
});
// support (Public)
Route::prefix('pages')->group(function () {
    Route::post('support', [SupportController::class, 'store']);
    Route::get('/pages', [PagesController::class, 'index']);     // كل الصفحات
    Route::get('/faqs', [FAQController::class, 'index']);
    Route::get('/{slug}', [PagesController::class, 'show']); // صفحة محددة بالـ slug
});

// Public Controller Endpoints
Route::prefix('public')->group(function () {
    Route::get('/cars/available', [PublicController::class, 'viewAvailableCars']);
    Route::get('/cars/popular', [PublicController::class, 'viewPopularCars']);
    Route::get('/cars/{id}', [PublicController::class, 'getCarDetails']);
    Route::get('/cars/viewCategoriesWithCars', [PublicController::class, 'viewCategoriesWithCars']);

    
    Route::apiResource('/categories', CategoryController::class);
    Route::apiResource('/tags', TagController::class);
    Route::apiResource('/options', OptionController::class);
    Route::apiResource('/extra-options', ExtraOptionController::class);

    Route::get('/features', [PublicController::class, 'features']);          // features مع القيم
    Route::get('/features-only', [PublicController::class, 'featuresOnly']); // features لوحدها
    Route::get('/feature-values', [PublicController::class, 'featureValues']); // قيم feature محدد
});

// ------------------------
// Authenticated Endpoints
// ------------------------
// Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'user']);
    Route::post('/user/update', [AuthController::class, 'update']);

    // Cars Categories & Tags
    Route::prefix('cars/{car}')->group(function () {
        Route::post('categories', [CarCategoryController::class, 'attach'])->name('cars.categories.attach');
        Route::delete('categories', [CarCategoryController::class, 'detach'])->name('cars.categories.detach');
        Route::get('categories', [CarCategoryController::class, 'index'])->name('cars.categories.index');

        Route::post('tags', [CarTagController::class, 'attach'])->name('cars.tags.attach');
        Route::delete('tags', [CarTagController::class, 'detach'])->name('cars.tags.detach');
        Route::get('tags', [CarTagController::class, 'index'])->name('cars.tags.index');
    });

    // Customer Routes
    Route::prefix('customer')->group(function () {
        Route::get('favorite-cars', [CustomerController::class, 'viewFavoriteCars']);
        Route::get('suggested-cars', [PublicController::class, 'viewSuggestedCars']);
        Route::get('search', [PublicController::class, 'advancedSearch']);
        Route::get('cars/{car}', [CustomerController::class, 'getCarDetails']);

        // Favorites
        Route::post('favorites', [CustomerController::class, 'addFavorite']);
        Route::delete('favorites/{favorite}', [CustomerController::class, 'removeFavorite']);    

    });

    // Renter Routes
    Route::prefix('renter')->group(function () {
        Route::get('cars/{car}', [CustomerController::class, 'getCarDetails']);
    });

    // Admin Routes
    // Route::prefix('admin')->group(function () {
    //     Route::apiResource('features', FeatureController::class);
    // });

    // Cars Management for Users with Permission
    // Route::middleware('permission:manage-cars')->group(function() {
    //     // Route::apiResource('cars', CarController::class);
    //     Route::get('/my-cars', [CarController::class, 'myCars']);
    //     Route::post('/cars/{car}', [CarController::class, 'update']);
    //     Route::post('/cars', [CarController::class, 'store']);
    //     Route::delete('/cars', [CarController::class, 'destroy']);
    // });
    Route::middleware('permission:manage-cars')->group(function() {
        Route::apiResource('cars', CarController::class);
        Route::get('/my-cars', [CarController::class, 'myCars']);
        Route::post('/cars', [CarController::class, 'store']);
        Route::delete('/cars/{car}', [CarController::class, 'destroy']);
        Route::post('/cars/{car}', [CarController::class, 'update']);
    });


    // Favourites
    Route::prefix('favourites')->group(function () {
        Route::get('/', [FavouriteController::class, 'index']);
        Route::post('{carId}', [FavouriteController::class, 'store']);
        Route::delete('{carId}', [FavouriteController::class, 'destroy']);
    });

    
        // Bookings

        Route::get('/bookings', [BookingController::class, 'index']); 
        Route::get('/bookings/{id}', [BookingController::class, 'show']);
        Route::post('/bookings', [BookingController::class, 'store']);
        Route::post('/bookings/{id}/cancel', [BookingController::class, 'cancel']);
        Route::post('/bookings/{id}/confirm', [BookingController::class, 'confirm']);
        Route::post('/bookings/{id}/reject', [BookingController::class, 'reject']);

        Route::prefix('wallet')->group(function () {
            Route::get('balance', [WalletController::class, 'balance']);
            Route::post('deposit', [WalletController::class, 'deposit']);
            Route::post('withdraw', [WalletController::class, 'withdraw']);
        });

        // Conversations
    Route::post('chat/start', [ChatController::class, 'startConversation']);
    Route::get('/conversations', [ChatController::class, 'index']);
    Route::post('/conversations', [ChatController::class, 'store']);

    // Messages
    Route::get('/conversations/{conversationId}/messages', [ChatController::class, 'getMessages']);
    Route::post('/conversations/{conversationId}/messages', [ChatController::class, 'sendMessage']);

    // Mark as read
    Route::post('/conversations/{conversationId}/read', [ChatController::class, 'markConversationAsRead']);

    // باقي الـ routes اللي عندك
 


    // إضافة مراجعة جديدة
    Route::post('/cars/{car}/reviews', [ReviewController::class, 'store']);
    // تعديل مراجعة موجودة
    Route::put('/reviews/{review}', [ReviewController::class, 'update']);
    Route::patch('/reviews/{review}', [ReviewController::class, 'update']);
    // حذف مراجعة
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy']);
    // (اختياري) لو عايز تجيب كل الريفيوز لعربية معينة
    Route::get('/cars/{car}/reviews', [ReviewController::class, 'index']);



        

// });

// Webhook لـ MyFatoorah (بدون auth لأن الـ webhook بيجي من MyFatoorah)
Route::post('webhook/myfatoorah', [WalletController::class, 'handleWebhook']);
/*
╔════════════════════════════════════════╗
║  🔷  hi every one my name ismohame  ║
╚════════════════════════════════════════╝
*/
