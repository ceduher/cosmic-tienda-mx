<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function topRated()
    {
        $products= Product::withAvg('productReviews', 'rate')
        ->orderBy('product_reviews_avg_rate', 'desc')
        ->take(10)
        ->get()
        ->map
        ->format();
        foreach ($products as $item) {
            if(blank($item["product"]->slug)) {
                $slug = Str::slug($item["product"]->name, '-');
                $item["product"]->slug = $slug;

                $tmpProd = Product::find($item["product"]->id);
                $tmpProd->update(['slug' => $slug]);
            }
        };
        return response()->json([
            "products" => $products
        ]);
    }
}
