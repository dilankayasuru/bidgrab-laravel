<?php

use App\Http\Controllers\AuctionController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use App\Models\Auction;
use App\Models\Category;

Route::get('/', function () {
    $query = Auction::query();
    $query->where('status', 'live');
    $query->orderBy('bid_count', 'desc');
    $auctions = $query->limit(5)->get();
    $categories = Category::all();
    return view('welcome', compact('auctions', 'categories'));
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

        Route::get('/auctions', [AuctionController::class, 'userAuctions'])->name('auctions');
        
        Route::delete('/auction/delete', [AuctionController::class, 'destroy'])->name('auction.destroy');
        
        Route::get('/create', [AuctionController::class, 'create'])->name('create');
        
        Route::get('/edit', [AuctionController::class, 'edit'])->name('edit');
        
        Route::get('/orders', [OrderController::class, 'index'])->name('orders');

        Route::delete('/order/delete/{order}', [OrderController::class, 'destroy'])->name('order.delete');

        Route::post('/order/deliver/{order}', [OrderController::class, 'deliver'])->name('order.deliver');
    });

    Route::post('/place-bid/{auction}/{amount}', [BidController::class, 'create'])->name('place.bid');
});

Route::get('/auction/{auction}', [AuctionController::class, 'show'])->name('auction.show');

Route::get('/search/{keyword}', [AuctionController::class, 'search'])->name('auction.search');

Route::get('/auctions', [AuctionController::class, 'index'])->name('marketplace');
