<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;
use App\Models\Auction;
use Carbon\Carbon;

class UpdateAuctionStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-auction-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update auction statuses based on start and end dates';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Update pending auctions to live
        Auction::where('status', 'pending')
            ->where('starting_date', '<=', Carbon::now())
            ->update(['status' => 'live']);

        // Update live auctions to end
        Auction::where('status', 'live')
            ->where('end_date', '<=', Carbon::now())
            ->update(['status' => 'ended']);

        // Complete orders
        $completedAuctions = Auction::where([
            ['status', 'ended'],
            ['highest_bid', '!=', null]
        ])->doesntHave('order')
            ->orderBy('end_date', 'asc')
            ->get();

        foreach ($completedAuctions as $auction) {
            $order = new Order();
            $order->payment = null;
            $auction->order()->save($order);
            
            $highestBid = $auction->highestBid;
            if ($highestBid) {
                $user = $highestBid->user;
                if ($user) {
                    $user->orders()->save($order);
                }
            }
        }

        $this->info('Auction statuses updated successfully.');
    }
}
