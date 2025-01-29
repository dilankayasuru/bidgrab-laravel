<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard.dashboard');
    })->name('dashboard');

    Route::prefix('dashboard')->name('dashboard.')->group(function () {

        Route::get('/orders', function () {
            return view('dashboard.orders');
        })->name('orders');

        Route::get('/auctions', function () {
            return view('dashboard.auctions');
        })->name('auctions');

        Route::get('/create', function () {
            return view('dashboard.create');
        })->name('create');
    });
});
