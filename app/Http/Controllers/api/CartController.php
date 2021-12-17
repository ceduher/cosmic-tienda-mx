<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function count(Request $request)
    {
        $count = Cart::where('user_id', Auth::id())->sum('quantity');
        return response()->json([
            'status' => ' Items en carrito',
            'records' => $count
        ]);    
    }
    public function show(Request $request, $cartid = null)
    {
        $listitems = [];
        $cart = Cart::where('user_id', $cartid ?? Auth::id() )->get();

        foreach ($cart as $item ) {
            $product= Product::where('id', $item->product_id)->get()->first();

            $stdClass = new \stdClass();
            $stdClass->id = $item->id;
            $stdClass->product_id = $item->product_id;
            $stdClass->name = $product->name;
            $stdClass->price = $product->price;
            $stdClass->qty = $item->quantity;
            $stdClass->market_id = $item->market_id;
            $stdClass->imagesrc = $product->getFirstMediaUrl('image');
            $listitems[] = $stdClass;
        }

        return response()->json([
            'status' => ' Items en carrito',
            'data' => $listitems
        ]);         
    }
    public function destroy(Request $request, Cart $cart)
    {
        $prod_check = Product::where('id', $cart->product_id)->first();
        if ($cart){
            $cart->delete();
            return response()->json([
                'success' => true,
                'message' => $prod_check->name.' borrado del carrito',
                'count'=>  Cart::where('user_id', $cart->user_id)->sum('quantity')
            ]); 
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Item '.$id.' no encontrado en carrito',
            ]);
        }            
    }    
    public function update(Request $request, $id )
    {
        $qty = $request->input('qty');
        $user_id = $request->input('user_id');

        $item = Cart::where('id', $id)->first();
        if($item) {
            if ($qty==0){
                $item->delete(); 
            } else {
                $item->quantity = $qty;
                $item->update();
            }
            $product = Product::where('id',$item->product_id)->first();
    
            return response()->json([
                'success' => true,
                'message' => $product->name.' actualizado en carrito',
                'count'=>  Cart::where('user_id', $user_id)->sum('quantity')
            ]);        
        } else {
            return response()->json([
                'status' => 'No se puede actualizar el carrito, por falta de existencias',
                'records' => $count
            ], 404);
        }
    }    
    public function store(Request $request)
    {
        $product_id = $request->input('id');
        $product_qty = $request->input('qty');
        $user_id = Auth::id();
        
        $cart_check = Cart::where('user_id', $user_id)->where('product_id', $product_id)->first();
        if ($cart_check){
            $cart_check->quantity += $product_qty;
            $cart_check->save();
        } else {
            $cartItem = new Cart();
            $cartItem->product_id = $product_id;
            $cartItem->user_id =  $user_id;
            $cartItem->quantity = $product_qty;
            $cartItem->save();
        }

        $cart_check = Cart::where('user_id', $user_id)->where('product_id', $product_id)->with('product')->first();
        $count = Cart::where('user_id', $user_id)->sum('quantity');

        if ($cart_check) {
            return response()->json([
                'status' => $cart_check->product->name.' añadido al carrito',
                'records' => $count
            ]);    
        } else {
            return response()->json([
                'status' => 'No se puede agregar al carrito, por falta de existencias',
                'records' => $count
            ], 404); 
        }

    }
}
