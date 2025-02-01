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

                case "unsold":
                    $auctions = $user->auctions()->where('status', 'ended')->whereNull('highest_bid')->get();
                    break;

                default:
                    $auctions = $user->auctions()->whereNot([
                        ['status', '!=', 'ended'],
                        ['highest_bid', null]
                    ])->get();
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

        $min = (float)request('min');
        $max = (float)request('max');
        $condition = request('condition');
        $category = request('category');
        $sort = request('sort');

        $query = Auction::query();

        if ($min > 0) {
            $query->where('current_price', '>=', $min);
        }

        if ($max > 0) {
            $query->where('current_price', '<=', $max);
        }

        if (!empty($condition)) {
            $query->where('condition', $condition);
        }
        if (!empty($category)) {
            $query->where('category_id', $category);
        }

        $query->where('status', 'live');

        if (!empty($sort)) {
            if ($sort == 'price') {
                $query->orderBy('current_price', 'asc');
            } elseif ($sort == 'date') {
                $query->orderBy('created_at', 'desc');
            }
        }

        $auctions = $query->paginate(12);
        return view('marketplace', compact('auctions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(Auction $auction)
    {
        if ($auction->status !== 'live') {
            abort(404);
        }
        $category = $auction->category()->first();
        $relatedAuctions = $category->auction()->where([
            ['id', '!=', $auction->id],
            ['status', '==', 'live']
        ])->limit(5)->get();
        return view('auction', compact('auction', 'relatedAuctions'));
    }

    public function search($keyword)
    {
        $auctions = Auction::where('status', 'live')
            ->where(function ($query) use ($keyword) {
                $query->where('title', 'like', "%$keyword%")
                    ->orWhere('description', 'like', "%$keyword%");
            })->paginate(15);
        return view('marketplace', compact('auctions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        return view('dashboard.edit');
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
