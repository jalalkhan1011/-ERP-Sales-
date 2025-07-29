<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::group(['prefix' => 'customer'], function () {
        Route::resource('/customers', CustomerController::class);
    });
    Route::group(['prefix' => 'product'], function () {
        Route::resource('/products', ProductController::class);
    });
    Route::group(['prefix' => 'sale'], function () {
        Route::get('/trash', [SaleController::class, 'trash'])->name('sales.trash');
        Route::get('/restore/{id}', [SaleController::class, 'restore'])->name('sales.restore');
        Route::resource('/sales', SaleController::class);
    });
});
