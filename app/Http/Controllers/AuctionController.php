<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use Illuminate\Http\Request;

class AuctionController extends Controller
{

    public function userAuctions(Request $request)
    {
        try {
            $user = auth()->user();
            $status = $request->input('status');

            switch ($status) {

                case "pending":
                    $auctions = $user->auctions()->where('status', $status)->get();
                    break;

                case "live":
                    $auctions = $user->auctions()->where('status', $status)->get();
                    break;

                case "sold":
                    $auctions = $user->auctions()->where('status', 'ended')->whereNotNull('winner_id')->get();
                    break;

                case "unsold":
                    $auctions = $user->auctions()->where('status', 'ended')->whereNull('winner_id')->get();
                    break;

                default:
                    $auctions = $user->auctions()->get();
                    break;
            }

            return view('dashboard.auctions', compact('auctions'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 400);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Auction $auction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        return view('dashboard.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Auction $auction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Auction $auction)
    {
        try {
            $auction->delete();
            return response()->json(['message' => "Auction deleted successfully!"], 204);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
