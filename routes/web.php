<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SocialAuthController; 
// use App\Http\Controllers\PaymentController; 

use App\Http\Controllers\MyFatoorahController;

Route::get('/', function () {
    return view('welcome');
});



// Route::get('/pay', [MyFatoorahController::class, 'index']);


