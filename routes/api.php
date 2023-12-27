<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\userController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/customer',[CustomerController::class,'index'])->name('customer.index');
Route::get('/customer/{id}',[CustomerController::class,'show'])->name('customer.show');
Route::post('/customer',[CustomerController::class,'store'])->name('customer.store');
Route::put('/customer/{id}',[CustomerController::class,'update'])->name('customer.update');
Route::delete('/customer/{id}',[CustomerController::class,'destory'])->name('customer.destory');

