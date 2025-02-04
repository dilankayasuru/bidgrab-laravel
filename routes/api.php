<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuctionController;
use App\Http\Controllers\API\BidController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\StripeController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])
        ->middleware('auth:sanctum');
});

Route::prefix('auctions')->group(function () {
    Route::get('/', [AuctionController::class, 'index']);
    Route::get('{auction}', [AuctionController::class, 'show']);
    Route::post('create', [AuctionController::class, 'store'])->middleware('auth:sanctum');
    Route::put('update/{auction}', [AuctionController::class, 'update'])->middleware('auth:sanctum');
});

Route::post('bid/{auction}', [BidController::class, 'create'])->middleware('auth:sanctum');

Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{category}', [CategoryController::class, 'auctions']);
Route::get('search', [AuctionController::class, 'search']);

Route::get('orders', [OrderController::class, 'index'])->middleware('auth:sanctum');
Route::post('deliver/{order}', [OrderController::class, 'deliver'])->middleware('auth:sanctum');

Route::post('pay/{order}', [StripeController::class, 'checkout'])->middleware('auth:sanctum')->name('api.pay');

Route::get('trending', [AuctionController::class, 'trending']);

