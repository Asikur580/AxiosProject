<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\userController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\TokenVerificationMiddleware;

// page route


Route::view('/registration','pages.auth.registration-page');
Route::view('/login','pages.auth.login-page');
Route::view('/dashboard','pages.dashboard.dashboard')->middleware([TokenVerificationMiddleware::class]);


// user route

Route::post('/registration',[userController::class,'registration'])->name('user.registration');
Route::post('/login',[userController::class,'login'])->name('user.login');
Route::post('/sendOTP',[userController::class,'sendOTP'])->name('user.sendOTP');
Route::post('/verifyOTP',[userController::class,'verifyOTP'])->name('user.verifyOTP');
Route::post('/resetPassword',[userController::class,'resetPassword'])->name('user.resetPassword')->middleware([TokenVerificationMiddleware::class]);
Route::get("/profile",[UserController::class,'profile'])->middleware([TokenVerificationMiddleware::class]);
Route::get("/logout",[UserController::class,'logout'])->middleware([TokenVerificationMiddleware::class]);

// customer route

Route::get('/customer',[CustomerController::class,'index'])->name('customer.index');
Route::get('/customer/{customer}',[CustomerController::class,'show'])->name('customer.show');
Route::post('/customer',[CustomerController::class,'store'])->name('customer.store');
Route::put('/customer/{customer}',[CustomerController::class,'update'])->name('customer.update');
Route::delete('/customer/{customer}',[CustomerController::class,'destory'])->name('customer.destory');



