<?php

namespace App\Http\Controllers\API;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class OrderController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->with('auction')->paginate(10);
        return response()->json($orders);
    }

    public function deliver(Order $order)
    {
        $this->authorize('deliver-order', $order);
        $order->status = 'delivered';
        $order->save();
        return response()->json(['message' => 'Order delivered successfully!'], 200);
    }
    
}
