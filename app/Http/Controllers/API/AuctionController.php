<?php

namespace App\Http\Controllers\API;

use App\Models\Auction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class AuctionController extends Controller
{
    public function index(Request $request)
    {
        $query = Auction::query();

        $query->where('status', 'live');

        if ($request->has('min')) {
            $query->where('current_price', '>=', (float)$request->input('min'));
        }

        if ($request->has('max')) {
            $query->where('current_price', '<=',  (float)$request->input('max'));
        }

        if ($request->has('sort_by_date')) {
            $query->orderBy('created_at', $request->input('sort_by_date'));
        }

        if ($request->has('category')) {
            $query->where('category_id', $request->input('category'));
        }

        if ($request->has('condition')) {
            $query->where('condition', $request->input('condition'));
        }

        $auctions = $query->get();

        foreach ($auctions as $auction) {
            $auction->images = array_map(function ($image) {
                return asset('storage/' . $image);
            }, $auction->images);
            $auction->specs = json_decode($auction->specs);
            $auction->categoryName = $auction->category->name;
        }

        return response()->json($auctions);
    }

    public function show(Auction $auction)
    {
        $auction->images = array_map(function ($image) {
            return asset('storage/' . $image);
        }, $auction->images);

        $auction->specs = json_decode($auction->specs);
        $auction->categoryName = $auction->category->name;

        return response()->json($auction, 200);
    }

    public function store(Request $request)
    {
        try {

            $validatedData = Validator::make($request->only('title', 'description', 'starting_price', 'category_id', 'condition', 'images', 'duration', 'starting_date'), [
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'condition' => 'required|string',
                'duration' => 'required|numeric|in:1,3,5,7,10',
                'starting_date' => 'required|date|after_or_equal:today',
                'starting_price' => 'required|numeric|min:150',
                'category_id' => 'required|exists:categories,id',
                'images' => 'required|array|min:1|max:5',
                'images.*' => 'image|max:1024',
            ])->validate();

            $uploads = array_map(function ($image) {
                return $image->store();
            }, $validatedData['images']);

            $auctionData = [
                'title' => $validatedData['title'],
                'description' => $validatedData['description'],
                'images' => $uploads,
                'category_id' => $validatedData['category_id'],
                'condition' => $validatedData['condition'],
                'duration' => $validatedData['duration'],
                'starting_date' => Carbon::parse($validatedData['starting_date']),
                'starting_price' => (float)$validatedData['starting_price'],
                'current_price' => (float)$validatedData['starting_price'],
                'bid_count' => 0,
                'specs' => $request->input('specs')
            ];
            $auction = Auction::create($auctionData);

            return response()->json($auction, 201);
        } catch (ValidationException $error) {
            return response()->json(['message' => $error->getMessage()], 400);
        }
    }

    public function update(Request $request, Auction $auction)
    {
        try {
            $validatedData = Validator::make($request->only('title', 'description', 'current_price', 'category_id', 'condition', 'images', 'duration', 'starting_date'), [
                'title' => 'sometimes|required|string|max:255',
                'description' => 'sometimes|required|string',
                'current_price' => 'sometimes|required|numeric',
                'category_id' => 'sometimes|required|exists:categories,id',
                'condition' => 'sometimes|required|string',
                'duration' => 'sometimes|required|numeric|in:1,3,5,7,10',
                'starting_date' => 'sometimes|required|date|after_or_equal:today',
                'images' => 'sometimes|required|array|min:1|max:5',
                'images.*' => 'image|max:1024',
            ])->validate();

            if (isset($validatedData['images'])) {
                $uploads = array_map(function ($image) {
                    return $image->store();
                }, $validatedData['images']);
                $validatedData['images'] = $uploads;
            }

            $auction->update($validatedData);

            $specs = $request->input('specs');
            if (isset($specs)) {
                $auction->specs = json_encode($specs);
            }

            return response()->json($auction);
        } catch (ValidationException $error) {
            return response()->json(['message' => $error->getMessage()], 400);
        }
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $auctions = Auction::where('status', 'live')
            ->where(function ($query) use ($keyword) {
                $query->where('title', 'like', "%$keyword%")
                    ->orWhere('description', 'like', "%$keyword%");
            })->get();

        foreach ($auctions as $auction) {
            $auction->images = array_map(function ($image) {
                return asset('storage/' . $image);
            }, $auction->images);
            $auction->categoryName = $auction->category->name;
        }

        return response()->json($auctions);
    }

    public function trending()
    {
        $query = Auction::query();
        $query->where('status', 'live');
        $query->orderBy('bid_count', 'desc');
        $auctions = $query->limit(5)->get();

        foreach ($auctions as $auction) {
            $auction->images = array_map(function ($image) {
                return asset('storage/' . $image);
            }, $auction->images);
            $auction->specs = json_decode($auction->specs);
            $auction->categoryName = $auction->category->name;
        }

        return response()->json($auctions);
    }
}
