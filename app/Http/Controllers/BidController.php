<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Bid;
use Illuminate\Support\Facades\Gate;

class BidController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Auction $auction, $amount)
    {
        try {

            if ($auction->status !== 'live') {
                return redirect()->route('auction.show', $auction)->with('error', "Auction is expired!");
            }

            if (request()->user()->id === $auction->user()->first()->id) {
                return redirect()->route('auction.show', $auction)->with('error', "You can not bid on your own auction!");
            }

            if ($auction->status !== "live") {
                return redirect()->route('auction.show', $auction)->with('error', "Auction is not started yet!");
            }

            if ($amount < $auction->current_price) {
                return redirect()->route('auction.show', $auction)->with('error', "Bid amount can not be lower than current price!");
            }

            Gate::authorize('place-bid', $auction);

            $bid = Bid::create(['amount' => $amount]);
            request()->user()->bids()->save($bid);
            $auction->bids()->save($bid);
            $auction->current_price = $amount;
            $auction->bid_count++;
            $auction->highest_bid = $bid->id;

            $auction->save();
            return redirect()->route('auction.show', $auction)->with('message', "Bid placed successfully!");
        } catch (\Exception $e) {
            return redirect()->route('auction.show', $auction)->with('error', $e->getMessage());
        }
    }
}
