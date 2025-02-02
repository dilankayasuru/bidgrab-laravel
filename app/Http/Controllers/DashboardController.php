<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        $data = $this->getAdminAnalytics();

        $totalSales = $data["totalSales"];
        $totalOrders = $data["totalOrders"];
        $totalAuctions = $data["totalAuctions"];
        $totalUsers = $data["totalUsers"];
        $salesByMonth = $data["salesByMonth"];
        $topAuctions = $data['topAuctions'];

        // Pass the data to the view
        return view('dashboard.dashboard', compact('totalSales', 'totalOrders', 'totalAuctions', 'totalUsers', 'salesByMonth', 'topAuctions'));
    }

    private function getAdminAnalytics()
    {
        $topAuctions = Auction::where('status', 'live')->orderBy('bid_count', 'desc')->limit(5)->get();
        $totalSales = Order::whereIn('status', ['delivered', 'payed'])
            ->with('auction')
            ->get()
            ->sum(function ($order) {
                return $order->auction->current_price;
            });
        $totalOrders = Order::count();
        $totalAuctions = Auction::count();
        $totalUsers = User::count();

        $salesByMonth = Order::whereIn('status', ['delivered', 'payed'])
            ->with('auction')
            ->get()
            ->groupBy(function ($order) {
                $month = Carbon::parse($order->created_at)->format('m');
                Log::info('Order created at: ' . $order->created_at . ' - Parsed month: ' . $month);
                return (int)$month;
            })
            ->map(function ($orders) {
                return $orders->sum(function ($order) {
                    return $order->auction->current_price;
                });
            })
            ->toArray();

        $salesByMonth = array_replace(array_fill(1, 12, 0), $salesByMonth);

        return [
            "topAuctions" => $topAuctions,
            "totalSales" => $totalSales,
            "totalOrders" => $totalOrders,
            "totalAuctions" => $totalAuctions,
            "totalUsers" => $totalUsers,
            "salesByMonth" => array_values($salesByMonth),
        ];
    }
    private function getUserAnalytics() {}
}
