<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SocialAuthController; 
// use App\Http\Controllers\PaymentController; 

use App\Http\Controllers\MyFatoorahController;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/pay', [MyFatoorahController::class, 'index']);
// Route::get('/checkout


// use App\Http\Controllers\PaymentController;

// Route::get('/payment/checkout', [PaymentController::class, 'checkout'])->name('payment.checkout');
// Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');

// Route::get('/payment', [PaymentController::class, 'showPaymentForm'])->name('payment.form');
// Route::post('/payment/process', [PaymentController::class, 'processPayment'])->name('payment.process');
// Route::get('/payment/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');


