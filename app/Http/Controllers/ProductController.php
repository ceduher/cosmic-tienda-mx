<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        return view('products.index')->with([
            "products" => Product::withAvg('productReviews', 'rate')
                ->orderBy('product_reviews_avg_rate', 'desc')
                ->latest()
                ->paginate(6),
            "total" => Product::count(),
        ]);
    }
    
    public function details(Product $product)
    {
        // $product = Product::where('slug',  $slug)->get()->first();
        $count=0;
        if (Auth::check()){
           $count= Cart::where('user_id', Auth::id())->sum('quantity');
        }
        return view('products.details')->with([
            "product" => $product,
            'count'=>  $count
        ]);
    }    
}
