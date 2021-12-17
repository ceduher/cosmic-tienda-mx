<?php

namespace App\Observers;

use App\Models\Cart;
use App\Models\Product;

class CartObserver
{
    /**
     * Handle the Cart "retrieved" event.
     *
     * @param  \App\Models\Cart  $cart
     * @return void
     */
    public function retrieved(Cart $cart)
    {
        $this->checkProductStock($cart);
    }

    /**
     * Handle the Cart "created" event.
     *
     * @param  \App\Models\Cart  $cart
     * @return void
     */
    public function created(Cart $cart)
    {
        $this->checkProductStock($cart);
    }

    /**
     * Handle the Cart "updated" event.
     *
     * @param  \App\Models\Cart  $cart
     * @return void
     */
    public function updated(Cart $cart)
    {
        $this->checkProductStock($cart);
    }

    /**
     * Handle the Cart "deleted" event.
     *
     * @param  \App\Models\Cart  $cart
     * @return void
     */
    public function deleted(Cart $cart)
    {
        //
    }

    /**
     * Handle the Cart "restored" event.
     *
     * @param  \App\Models\Cart  $cart
     * @return void
     */
    public function restored(Cart $cart)
    {
        //
    }

    /**
     * Handle the Cart "force deleted" event.
     *
     * @param  \App\Models\Cart  $cart
     * @return void
     */
    public function forceDeleted(Cart $cart)
    {
        //
    }

    private function checkProductStock(Cart $cart)
    {
        $product = Product::find($cart->product_id);
        
        if($product->qty == 0 || $product->qty < $cart->qty) {
            $cart->delete();
        }
    }
}
