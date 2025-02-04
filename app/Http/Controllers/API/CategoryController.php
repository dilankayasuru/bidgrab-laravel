<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        foreach ($categories as $category) {
            $category->image = asset('storage/' . $category->image);
        }
        return response()->json($categories);
    }

    public function auctions(Category $category)
    {
        $auctions = $category->auction()->where('status', 'live')->get();
        foreach ($auctions as $auction) {
            $auction->images = array_map(function ($image) {
                return asset('storage/' . $image);
            }, $auction->images);
            $auction->specs = json_decode($auction->specs);
            $auction->categoryName = $category->name;
        }
        return response()->json(['auctions' => $auctions, 'category' => $category]);
    }
}
