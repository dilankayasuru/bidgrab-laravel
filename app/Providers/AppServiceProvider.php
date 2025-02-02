<?php

namespace App\Providers;

use App\Models\Auction;
use App\Models\Order;
use App\Models\PersonalAccessToken;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);

        Gate::define('modify-auction', function (User $user, Auction $auction) {
            return $user->id === $auction->user->id || $user->role === "admin";
        });

        Gate::define('admin-functions', function (User $user) {
            return $user->role === "admin";
        });

        Gate::define('place-bid', function (User $user, Auction $auction) {
            return $user->role !== "admin" && $user->id !== $auction->user_id;
        });

        Gate::define('deliver-order', function (User $user, Order $order) {
            return $user->role !== "admin" && $user->id !== $order->user_id;
        });

        Gate::define('create-auction', function (User $user) {
            return $user->role !== "admin";
        });
    }
}
