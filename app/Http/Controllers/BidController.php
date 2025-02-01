<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Bid;

class BidController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Auction $auction, $amount)
    {
        try {

            if (request()->user()->id === $auction->user()->first()->id) {
                return redirect()->route('auction.show', $auction)->with('error', "You can not bid on your own auction!");
            }

            if ($auction->status !== "live") {
                return redirect()->route('auction.show', $auction)->with('error', "Auction is not started yet!");
            }

            if ($amount < $auction->current_price) {
                return redirect()->route('auction.show', $auction)->with('error', "Bid amount can not be lower than current price!");
            }

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
