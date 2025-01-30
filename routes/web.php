<?php

use App\Http\Controllers\AuctionController;
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

        Route::get('/auctions', [AuctionController::class, 'userAuctions'])->name('auctions');
        
        Route::delete('/auction/delete', [AuctionController::class, 'destroy'])->name('auction.destroy');

        Route::get('/create', [AuctionController::class, 'create'])->name('create');
    });
});
