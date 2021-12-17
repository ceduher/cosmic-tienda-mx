<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use Stripe;
use App\Models\Cart;
use App\Models\CartOption;
use App\Models\Coupon;
use App\Models\CustomFieldValue;
use App\Models\DeliveryAddresse;
use App\Models\Market;
use App\Models\Option;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\productOrder;
use App\Models\ProductOrderExtra;
use App\Models\ProductOrderOption;
use App\Models\GeoCerca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index(Market $market)
    {
        $customFields = array();
        $userAdresses = array();
        $customFieldValue = auth()->user()->customFieldValue;
        if (count($customFieldValue) != 0) {
            foreach ($customFieldValue as $customField) {
                if ($customField->customField->isPhone()) {
                    $customFields["phone"] = ["value" => $customField->value, "view" => $customField->view];
                }
                if ($customField->customField->isAddress()) {
                    array_push($userAdresses, ["value" => $customField->value, "view" => $customField->view]);
                }
            }
            $customFields["address"] = $userAdresses;
        }
        $geocerca = GeoCerca::all();
        $deliveryAddress = DeliveryAddresse::where('user_id', auth()->user()->id)->get();
        
        $count=0;
        if(Auth::check()) {
            $count = Cart::where('user_id', Auth::id())->sum('quantity');
        }        
        return view("order.make")->with([
            "market" => $market,
            "customFields" => $customFields,
            "deliveryAddress" => $deliveryAddress->toArray(),
            "geocerca" => [
                "postalCode" => $geocerca->pluck('code'),
                "colonia" => $geocerca->pluck('name'),
            ],
            "count"=>$count,
            "user_id" => auth()->user()->id,
        ]);
    }
    public function store(OrderStoreRequest $request)
    {
        if ($request->payment_method === "paypal") {
            abort(403, 'payment with paypal is comming soon');
        }
        
        // $request->validate([
        //     'phone' => 'required|string',
        //     'address' => 'string|max:255',
        //     'order' => 'required',
        //     'payment_method' => 'required',
        //     'orderType' => 'required',
        //     'phone_type' => 'required',
            
        //     'calle' => 'required|string',
        //     'numext' => 'required|string',
        //     'numint' => 'nullable|string',
        //     'colonia' => 'required|string',
        //     'codigo_postal' => 'required|string',
        //     'municipio' => 'required|string',
        //     'estado' => 'required|string',
        //     'direccion_entrega' => 'required|string',
        //     'nombre' => 'required|string',
        //     'apellido' => 'required|string',
        //     'telefono' => 'required|string',
        //     'url' => 'required|string',
        // ]);
        
        try {
            $response = $this->makeOrder($request);
            if ($response[0] instanceof Market && $response[1] instanceof Order) {
                return redirect("/order/confirm")->with('market', $response[0])->with('order', $response[1]);
            };
            return redirect("/order/not-confirm")->with('message', "Order Not confirmed");
        } catch (\Throwable $th) {
            Log::emergency('error');
            Log::emergency($th);

            return redirect('/order/not-confirm')->with('message', "Order Not confirmed");
        }
    }
    public function confirm()
    {
        
        if (session('market') && session('order')) {
            return view('order.confirm')->with([
                'market' => session('market'),
                'order' => session('order')
            ]);
        }
        abort(404);
    }
    public function notConfirm()
    {
        if (session('message')) {
            return view('order.not_confirm');
        }
        abort(404);
    }
    private function makeOrder($request)
    {
        $order = collect(json_decode($request->order, true));
        $user = auth()->user();
        $market = Market::findOrFail($order->get('market')['id']);
        $totalPrice = 0;
        $orders = array();
        foreach ($order->get('orders') as $theOrder) {
            $productOrdered = Product::findOrFail($theOrder['product_id']);
            $productOrderedOptions = array();
            $orderPrice = $productOrdered->getPrice();
            foreach ($theOrder['options'] as $option_id) {
                $option = Option::findOrFail($option_id);
                $orderPrice = $orderPrice + $option->price;
                array_push($productOrderedOptions, $option);
            }
            $totalPrice = $totalPrice + ($orderPrice * $theOrder['numberOfMeals']);
            array_push($orders, [
                'product' => $productOrdered,
                'productOptions' => $productOrderedOptions,
                'price' => $orderPrice ,//* $theOrder['numberOfMeals'],
                'numberOfMeals' => $theOrder['numberOfMeals'],
            ]);

            $this->checkProductStock($productOrdered, $theOrder['numberOfMeals']);
        }
        $deliveryFee = 0;
        if ($order->get('orderType') == 'Delivery') {
            if ($totalPrice < 400) {
                $deliveryFee = $market->delivery_fee;
                $totalPrice += $deliveryFee;
            }
        }
        /*if (request('coupon')) {
            $coupon = Coupon::where('code', request('coupon'))->first();
            if ($coupon != null) {
                $couponData = $coupon->checkValidation();
                if ($couponData['valid']) {
                    foreach ($orders as $order) {
                        if (in_array($order["product"]->id, $couponData['discountables']["products"])) {
                            $dis = $order["product"]->getPrice() - ($order["product"]->getPrice() - ($order["product"]->getPrice() * $couponData["discount"]) / 100);
                        } elseif (in_array($order["product"]->restaurant_id, $couponData['discountables']["products"])) {
                            $dis = $order["product"]->getPrice() - ($order["product"]->getPrice() - ($order["product"]->getPrice() * $couponData["discount"]) / 100);
                        } elseif (in_array($order["product"]->category_id, $couponData['discountables']["categorys"])) {
                            $dis = $order["product"]->getPrice() - ($order["product"]->getPrice() - ($order["product"]->getPrice() * $couponData["discount"]) / 100);
                        } else {
                            $dis = 0;
                        }
                        $totalPrice = $totalPrice - $dis * $order["numberOfMeals"];
                    }
                }
            }
        }*/
        if (request('coupon')) {
            $coupon = Coupon::where('code', request('coupon'))->first();
            if ($coupon != null) {
                $couponData = $coupon->checkValidation();
                if ($couponData['valid']) {
                    foreach ($orders as $order) {
                        if (in_array($order["product"]->id, $couponData['discountables']["products"])) {
                            if($coupon->discount_type == 'percent') {
                                $dis = $order["product"]->getPrice() - ($order["product"]->getPrice() - ($order["product"]->getPrice() * $couponData["discount"]) / 100);
                            } else {
                                $dis = $couponData["discount"];
                            }
                        } elseif (in_array($order["product"]->market_id, $couponData['discountables']["markets"])) {
                            if($coupon->discount_type == 'percent') {
                                $dis = $order["product"]->getPrice() - ($order["product"]->getPrice() - ($order["product"]->getPrice() * $couponData["discount"]) / 100);
                            } else {
                                $dis = $couponData["discount"];
                            }
                        } elseif (in_array($order["product"]->category_id, $couponData['discountables']["categorys"])) {
                            if($coupon->discount_type == 'percent') {
                                $dis = $order["product"]->getPrice() - ($order["product"]->getPrice() - ($order["product"]->getPrice() * $couponData["discount"]) / 100);
                            } else {
                                $dis = $couponData["discount"];
                            }
                        } else {
                            $dis = 0;
                        }

                        if($coupon->discount_type == 'percent') {
                            $totalPrice = $totalPrice - $dis * $order["numberOfMeals"];
                        }
                    }
                    
                    if($dis) {
                        $totalPrice = $totalPrice - $dis;   
                    }
                }
            }
        }
        $tax = $market->default_tax;
        $totalPrice = $totalPrice + $totalPrice * $tax / 100;
        
        $this->stripeCharge($totalPrice, $request);

        $payment = Payment::create([
            "price" => $totalPrice,
            "user_id" => $user->id,
            "description" => "Pedido pagado",
            "status" => "Pagado",
            "method" => $request->payment_method,
        ]);
        if ($request->orderType == "Delivery" && blank($request->delivery_address_id) ) {
            $deliveryAddresse = DeliveryAddresse::create([
                "description" => $request->delivery_address_description ? $request->delivery_address_description : "default user address",
                "address" => $request->address ? $request->address : null,
                "is_default" => $request->address_type == "default" ? true : false,
                "user_id" => $user->id,
                'calle' => $request->calle,
                'numext' => $request->numext,
                'numint' => $request->numint,
                'colonia' => $request->colonia,
                'codigo_postal' => $request->codigo_postal,
                'municipio' => $request->municipio,
                'estado' => $request->estado,
                'direccion_entrega' => $request->direccion_entrega,
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'telefono' => $request->telefono,
                'url' => $request->url,
            ]);
        }
        if ($request->address_type != "default" && $request->address != "" && $request->address != null) {
            CustomFieldValue::create([
                "value" => $request->address,
                "view" => $request->address,
                "custom_field_id" => 6,
                "customizable_type" => "App\Models\User",
                "customizable_id" => $user->id
            ]);
        }
        if ($request->phone_type != "default") {
            CustomFieldValue::create([
                "value" => $request->phone,
                "view" => $request->phone,
                "custom_field_id" => 4,
                "customizable_type" => "App\Models\User",
                "customizable_id" => $user->id
            ]);
        }
        $order = Order::create([
            'user_id' => $user->id,
            'order_status_id' => 1,
            'tax' => $market->admin_commission,
            'delivery_fee' => $deliveryFee,
            'delivery_address_id' => $request->orderType == "Delivery" ?  ($request->delivery_address_id ? $request->delivery_address_id : $deliveryAddresse->id) : null,
            'payment_id' => $payment->id,
            'hint' => $request->hint ? $request->hint : null
        ]);
        foreach ($orders as $theOrder) {
            $productOrder = productOrder::create([
                "product_id" => $theOrder["product"]->id,
                "order_id" => $order->id,
                "quantity" => $theOrder["numberOfMeals"],
                "price" => $theOrder["price"],
            ]);
            $cart = Cart::create([
                'product_id' => $theOrder["product"]->id,
                'user_id' => $user->id,
                'quantity' => $theOrder["numberOfMeals"]
            ]);
            foreach ($theOrder['productOptions'] as $productOptions) {
                ProductOrderOption::create([
                    "product_order_id" => $productOrder->id,
                    "option_id" => $productOptions->id,
                    "price" => $productOptions->price,
                ]);
                CartOption::create([
                    'option_id' => $productOptions->id,
                    'cart_id' => $cart->id
                ]);
            }
        }

        //Substract product
        $this->subProduct($orders);

        //Delete cart items
        Cart::where('user_id', Auth::id())->delete();


        return [$market, $order];
    }

    private function stripeCharge($total, $request) {
        if ($request->payment_method === "card") {
            //$tmp = json_decode($request->order);
            
            $stripeCharge = $request->user()->charge(
                $total * 100 , $request->paymentMethod
            );
        }
    }

    private function checkProductStock(Product $product, $qty) {
        if($product->qty == 0 || $product->qty < $qty) {
            return redirect("/cart")->with('purchased-product', "Oops! Alguno de los productos de su carrito ya fueron comprados");
        }
    }

    private function subProduct($orders) {
        foreach($orders as $order) {
            $product = $order['product'];
            $qty = $order['numberOfMeals'];
            $product->fill(['qty' => $product->qty - $qty])->save();
        }
    }
}
