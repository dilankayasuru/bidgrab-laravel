<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = request()->user();

        $adminAuth = Gate::allows('admin-functions');

        $data = $adminAuth ? $this->getAdminAnalytics() : $this->getUserAnalytics($user);

        $totalSales = $data["totalSales"];
        $totalOrders = $data["totalOrders"];
        $totalAuctions = $data["totalAuctions"];
        $totalUsers = $data["totalUsers"] ?? [];
        $salesByMonth = $data["salesByMonth"];
        $topAuctions = $data['topAuctions'];

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
    private function getUserAnalytics($user)
    {
        $topAuctions = $user->auctions()->where('status', 'live')->orderBy('bid_count', 'desc')->limit(5)->get();

        $totalSales = Order::whereIn('status', ['delivered', 'payed'])
            ->whereHas('auction', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->with('auction')
            ->get()
            ->sum(function ($order) {
                return $order->auction->current_price;
            });

        $totalOrders = Order::whereHas('auction', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->count();

        $totalAuctions = $user->auctions()->count();

        $salesByMonth = Order::whereIn('status', ['delivered', 'payed'])
            ->whereHas('auction', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->with('auction')
            ->get()
            ->groupBy(function ($order) {
                $month = Carbon::parse($order->created_at)->format('m');
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
            "salesByMonth" => array_values($salesByMonth),
        ];
    }

    public function users(Request $request)
    {
        Gate::authorize('admin-functions');

        $type = request()->input('type');
        $query = User::query();

        switch ($type) {
            case "admin":
                $query->where('role', 'admin');
                break;
            case "user":
                $query->where('role', 'user');
                break;
        }

        $users = $query->paginate(10);

        return view('dashboard.users', compact('users'));
    }

    public function createUser(Request $request)
    {
        Gate::authorize('admin-functions');

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'user_role' => 'required|string|in:user,admin',
        ]);

        $user = User::create([
            'name' => $request["name"],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        $user->role = $request['user_role'];
        $user->save();
        \Log::info($user);

        return redirect()->route('dashboard.users')->with('success', 'User created successfully');
    }
}
