<?php

namespace App\Http\Controllers\API;

use App\Models\Auction;
use App\Models\Bid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class BidController extends Controller
{
    public function placeBid(Request $request, Auction $auction)
    {        
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:' . $auction->current_price + 1,
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => "The amount field must be greater than Rs. $auction->current_price"], 422);
        }

        if ($auction->status !== 'live') {
            return response()->json(['message' => 'Auction is not live.'], 400);
        }

        if (Auth::id() === $auction->user_id) {
            return response()->json(['message' => 'You cannot bid on your own auction.'], 403);
        }

        try {
            $bid = new Bid();
            $bid->amount = $request->amount;
            $bid->user_id = Auth::id();
            $bid->auction_id = $auction->id;
            $bid->save();

            $auction->current_price = $request->amount;
            $auction->bid_count++;
            $auction->highest_bid = $bid->id;
            $auction->save();

            return response()->json(['message' => 'Bid placed successfully!', 'bid' => $bid], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
