<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $user = request()->user();
        $status = request()->input('status');

        if ($status === null || $status == "all") {
            $orders = Order::whereHas('auction', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->with('auction')->get();
            return view('dashboard.orders', compact('orders'));
        }

        $orders = Order::whereHas('auction', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('status', $status)->with('auction')->get();
        return view('dashboard.orders', compact('orders'));
    }

    public function destroy(Order $order)
    {
        try {
            $auction = $order->auction;
            $auction->highestBid = null;
            $auction->save();
            $order->delete();
            return redirect()->route('dashboard.orders')->with('message', "Order canceled successfully!");
        } catch (\Exception $e) {
            return redirect()->route('dashboard.orders')->with('error', $e->getMessage());
        }
    }

    public function deliver(Order $order)
    {
        $order->status = "delivered";
        $order->save();
        return redirect()->route('dashboard.orders');
    }

    public function purchases()
    {

        $user = request()->user();
        $status = request()->input('status');

        if ($status === null || $status == "all") {
            $orders = $user->orders;
            return view('dashboard.purchases', compact('orders'));
        }
        $orders = $user->orders()->where('status', $status)->get();
        return view('dashboard.purchases', compact('orders'));
    }

    public function checkout(Order $order)
    {
        return view('checkout', compact('order'));
    }
}
