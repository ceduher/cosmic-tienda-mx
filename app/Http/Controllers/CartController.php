<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Market;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $listitems=[]; 
        $response = [
            "countMarket" => Market::count(), 
            "user_id" => Auth::check() ? Auth::id() : 0,
            "market" => Market::first(),
            "products" => Product::all(),
        ];
        return view('cart')->with($response);
    }
}
