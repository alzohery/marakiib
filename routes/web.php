<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SocialAuthController; 
Route::get('/', function () {
    return view('welcome');
});


// Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback']);
