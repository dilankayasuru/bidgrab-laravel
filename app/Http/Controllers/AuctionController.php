<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AuctionController extends Controller
{

    public function userAuctions(Request $request)
    {
        try {
            $user = auth()->user();
            $status = $request->input('status');

            $query = Auction::query();

            if (!Gate::allows('admin-functions')) {
                $query->where('user_id', $user->id);
            }

            switch ($status) {
                case "pending":
                    $query->where('status', 'pending');
                    break;

                case "live":
                    $query->where('status', 'live');
                    break;

                case "unsold":
                    $query->where('status', 'ended')->whereNull('highest_bid');
                    break;

                default:
                    $query->whereNot([
                        ['status', '!=', 'ended'],
                        ['highest_bid', null]
                    ]);
                    break;
            }

            $auctions = $query->orderBy('created_at', 'desc')->paginate(6);

            return view('dashboard.auctions', compact('auctions'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
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
    public function create(Request $request)
    {
        Gate::authorize('create-auction');
        return view('dashboard.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Auction $auction)
    {
        $user = auth()->user();

        if ($request->routeIs('dashboard.preview')) {
            if (Gate::allows('admin-functions') || Gate::allows('modify-auction', $auction)) {
                $category = $auction->category;
                $relatedAuctions = $category->auction()->where([
                    ['id', '!=', $auction->id],
                    ['status', 'live']
                ])->limit(5)->get();
                return view('auction', compact('auction', 'relatedAuctions'));
            } else {
                abort(403, 'Unauthorized action.');
            }
        }

        if ($auction->status !== 'live' && (!Gate::allows('admin-functions') && !Gate::allows('modify-auction', $auction))) {
            abort(404);
        }

        $category = $auction->category;
        $relatedAuctions = $category->auction()->where([
            ['id', '!=', $auction->id],
            ['status', 'live']
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
