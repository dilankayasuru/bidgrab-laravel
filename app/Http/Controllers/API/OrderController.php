<?php

namespace App\Http\Controllers\API;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use function PHPSTORM_META\map;

class OrderController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->with('auction')->get();
        foreach ($orders as $order) {
            $order->auction->images = array_map(function ($image) {
                return asset('storage/' . $image);
            }, $order->auction->images);
        }
        return response()->json($orders);
    }

    public function deliver(Order $order)
    {
        $this->authorize('deliver-order', $order);
        $order->status = 'delivered';
        $order->save();
        return response()->json(['message' => 'Order delivered successfully!'], 200);
    }

    public function orders() {
        $user = Auth::user();
        $orders = Order::whereHas('auction', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with('auction')->get();
        
        foreach ($orders as $order) {
            $order->auction->images = array_map(function ($image) {
                return asset('storage/' . $image);
            }, $order->auction->images);
        }
        return response()->json($orders);
    }
}
