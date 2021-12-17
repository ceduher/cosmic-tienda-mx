@extends('layouts.master')
@section('extraStyle')    
    <link href="{{ asset('css/detail-restaurant-tabs.css') }}" rel="stylesheet">
    <style>
        /* main::after {
        content: "";
        background: url("/images/bg.png");
        opacity: 0.3;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        position: absolute;
        z-index: -1;
        } */
        .custom-map-control-button {
          background-color: #fff;
          border: 0;
          border-radius: 2px;
          box-shadow: 0 1px 4px -1px rgba(0, 0, 0, 0.3);
          margin: 10px;
          padding: 0 0.5em;
          font: 400 18px Roboto, Arial, sans-serif;
          overflow: hidden;
          height: 40px;
          cursor: pointer;
        }
        .custom-map-control-button:hover {
          background: #ebebeb;
        }
    </style>
@endsection   
@section('content')
    @include('balde_components.navs.side-bar')                       
    @include('balde_components.navs.nav-bar-v2')
    <main class="w-full mt-16 relative  " >
        <div class="container lg:px-32">
            @if ($errors->any())
                <div class="alert alert-danger mb-0">
                    <ul>
                        @foreach ($errors->all() as $error)
                            @switch($error)
                                @case('El campo dirección es obligatorio')
                                @case('El campo calle es obligatorio')
                                @case('El campo N° exterior es obligatorio')
                                @case('El campo N° interior es obligatorio')
                                @case('El campo colonia es obligatorio')
                                @case('El campo codigo postal es obligatorio')
                                @case('El campo municipio es obligatorio')
                                @case('El campo estado es obligatorio')
                                @case('El campo dirección de entrega es obligatorio')
                                @case('El campo nombre en dirección es obligatorio')
                                @case('El campo apellido en dirección es obligatorio')
                                @case('El campo telefono en dirección es obligatorio')
                                @case('url')
                                    {{-- <li>Debe completar la dirección de entrega</li> --}}
                                    @break
                            
                                @default
                                    <li>{{ $error }}</li>
                            @endswitch
                        @endforeach
                        @php
                            $faltaDireccion = in_array('El campo dirección es obligatorio', $errors->all()) || 
                                in_array('La direccion debe ser alfanumerica', $errors->all()) || 
                                in_array('El campo calle es obligatorio', $errors->all()) || 
                                in_array('El campo N° exterior es obligatorio', $errors->all()) || 
                                in_array('El campo N° interior es obligatorio', $errors->all()) || 
                                in_array('El campo colonia es obligatorio', $errors->all()) || 
                                in_array('El campo codigo postal es obligatorio', $errors->all()) || 
                                in_array('El campo municipio es obligatorio', $errors->all()) || 
                                in_array('El campo estado es obligatorio', $errors->all()) || 
                                in_array('El campo dirección de entrega es obligatorio', $errors->all()) || 
                                in_array('El campo nombre en dirección es obligatorio', $errors->all()) || 
                                in_array('El campo apellido en dirección es obligatorio', $errors->all()) || 
                                in_array('El campo telefono en dirección es obligatorio', $errors->all()) || 
                                in_array('url', $errors->all());
                        @endphp
                        @if ($faltaDireccion)
                            <li>Debe completar la dirección de entrega</li>
                        @endif
                    </ul>
                </div>
            @endif
        </div>
        <form id="stripe-form" method="post" action="{{route("order")}}" class="container lg:px-32 flex flex-col lg:flex-row py-10">
            @csrf
            {{-- form inputs --}}
            <div class="flex-1 lg:mr-5">
                {{-- Personal Details --}}
                <div class="w-full rounded mb-3 shadow-lg">
                    <header class="w-full bg-green text-white text-xl rounded-t-sm py-4 px-3 font-bold text-left">
                    {{__('Personal Details')}}
                    </header>
                    <div class="bg-white grid grid-cols-6 gap-6  p-4 rounded-b-sm" >
                        <!-- First name -->
                            <div class="col-span-6  ">
                                <label for="first_name" class="block text-sm font-medium text-gray-700">{{__('Full name')}}</label>
                                <input  type="text" name="first_name" value="{{auth()->user()->name}}"  id="first_name" required readonly class="mt-1 p-2 outline-none  block w-full shadow-sm sm:text-sm rounded bg-gray-100 text-gray-500" >
                            </div>
                        <!-- email -->
                            <div class="col-span-6 md:col-span-3">
                                <label for="email" class="block text-sm font-medium text-gray-700">{{__('Email address')}}</label>
                                <input type="email" name="email" value="{{auth()->user()->email}}"id="email" required readonly class="mt-1 p-2 outline-none  block w-full shadow-sm sm:text-sm rounded bg-gray-100 text-gray-500" >
                            </div>
                        <!-- phone -->
                            @if(isset($customFields["phone"]))
                                <div class="col-span-6 md:col-span-3   ">
                                    <label for="phone" class="block text-sm font-medium text-gray-700"> 
                                        {{__('Phone number')}}
                                    </label>
                                    <input type="text" name="phone" id="phone" autocomplete="phone" placeholder="{{$customFields["phone"]["view"]}}" required  readonly
                                        value="@if(old('phone')){{ old('phone')}} @else{{$customFields["phone"]["value"]}}@endif"   
                                        class="mt-1 p-2 outline-none bg-gray-100 text-gray-500 block w-full shadow-sm sm:text-sm rounded  @error('phone') form-control is-invalid  @enderror"    >
                                    @error('phone')
                                        <div class="text-red-500 text-sm ">{{ $message }}</div>
                                    @enderror
                                </div>
                                <input type="hidden" name="phone_type" value="default">
                            @else
                                <div class="col-span-6 md:col-span-3   ">
                                    <label for="phone" class="block text-sm font-medium text-gray-700"> 
                                        {{__('Phone number')}}
                                    </label>
                                    <input 
                                        type="text" 
                                        name="phone" 
                                        id="phone" 
                                        autocomplete="phone" 
                                        placeholder="{{__('Phone number')}} ..."
                                        required  
                                        value="{{ old('phone') }}"   
                                        class="mt-1 p-2 outline-none  block w-full shadow-sm sm:text-sm rounded  @error('phone') form-control is-invalid  @enderror"    
                                    >
                                    @error('phone')
                                        <div class="text-red-500 text-sm ">{{ $message }}</div>
                                    @enderror
                                </div>
                                <input type="hidden" name="phone_type" value="costume">
                            @endif
                        {{-- address --}}
                            <div class="col-span-6 grid grid-cols-6 gap-6 " >
                                <div class="col-span-6">
                                    <order-address 
                                        :restrictions="{{ json_encode($geocerca) }}"
                                        :deliveryaddress="{{ json_encode($deliveryAddress) }}"
                                        :user_id="{{$user_id}}">
                                    </order-address>
                                </div>
                                @if (isset($customFields["address"]))
                                    <input type="hidden" name="address_type" value="default">
                                @else
                                @endif
                            </div>
                        {{-- hint --}}
                            <div class="col-span-6">
                                <label for="hint" class="block text-sm font-medium text-gray-700">
                                    {{__("Hint")}}
                                </label>
                                <textarea name="hint" id="hint" cols="10" rows="4" 
                                    style="border: 1px solid #eee" class="mt-1 p-3 outline-none block w-full shadow-md sm:text-sm rounded" >
                                    {{old("hint")}}
                                </textarea>
                            </div>
                            {{-- hint --}}
                            {{-- <div class="col-span-6">
                                <div id="message-club"></div>
                                <div id="map" style="height: 400px; width: 100%;"></div>
                            </div> --}}
                    </div>
                </div>
                {{-- Payment Method --}}
                <div class="w-full rounded my-3 shadow-lg">
                    <header class="w-full bg-green text-white text-xl rounded-t-sm py-4 px-3 font-bold text-left">
                        {{__('Payment Method')}}
                    </header>
                    <div class="bg-white p-4 rounded-b-sm">
                        <ul id="payment-tabs" class="nav nav-pills mb-3 flex flex-col md:flex-row" id="pills-tab" role="tablist">
                            <li class="nav-item flex-1 text-md" role="presentation">
                                <a class="nav-link flex justify-between items-center" onclick="setMethod('card')" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">
                                    {{__('Pay with Credit card')}}
                                    <i class="far fa-credit-card text-lg"></i>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                                 <input
                                    id="card-holder-name" 
                                    type="text" 
                                    class="form-control"
                                    placeholder="{{__('Card Holder Name')}}"
                                />
                                <!-- Stripe Elements Placeholder -->
                                <div class="p-4" id="card-element"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Order Summary --}}
            <div style="height:100px; width:390px;" class="w-full lg:w-1/3 rounded ">
                <div class=" w-full border-2 bg-white rounded  border-gray-300 border-dotted">
                    <div class="text-center border-b-2 bg-gray-100 border-gray-300 border-dotted py-3">
                        <p class="text-2xl font-bold">{{__('Order Summary')}}</p>
                        <p class="text-gray-900 font-medium "> {{$market->name}}</p>
                    </div>
                    <div class="py-3 px-4 flex flex-col">  
                        <!-- Type of  Delivery -->
                        <div class="flex flex-row justify-between my-2">
                            <div class="text-black font-normal">{{__('Order Type')}}</div>
                            <div id="orderType" class="text-black font-bold "></div>
                        </div>   
                        <hr class="text-gray-400 my-2">
                        <!-- orders -->
                        <div id="orders"></div>       
                        <!-- Subtotal -->
                        <div class="flex flex-row justify-between my-2">
                            <div class="text-black font-normal">{{__('Subtotal')}}</div>
                            <div id="subtotal" class="text-black font-bold "></div>
                        </div>
                        {{-- delivery fee --}}
                        <div  class="flex flex-row justify-between my-2">
                            <div class="text-black font-normal">{{__('Delivery fee')}}</div>
                            <div id="delivery_fee" class="text-black font-bold "></div>
                        </div>
                        {{-- tax --}}
                        <div class="flex flex-row justify-between my-2">
                            <div class="text-black font-normal">{{__('Tax')}}</div>
                            <div id="tax" class="text-black font-bold "></div>
                        </div>
                        <!-- total -->
                        <div class="flex flex-row justify-between my-2 text-red-600 text-xl font-semibold">
                            <div class="">{{__('Total')}}</div>
                            <div id="total"></div>
                        </div>    
                        {{-- coupon --}}
                        <div class="input-group input-group my-2">
                            <input type="text" name="coupon" id="coupon" placeholder="{{__('Add Coupons')}}" class="form-control p-3 fix-rounded-right rounded" >
                            <div class="input-group-prepend">
                                <span onclick="checkCoupon()" class="cursor-pointer input-group-text py-1 px-2 ml-2 border-none bg-green text-white font-semibold rounded">{{__('Valider')}}</span>
                            </div>
                        </div>   
                        <div class="text-red-500 text-sm" id="coupon_msg"></div>
                        <!-- button -->
                        <div class="my-3">
                            <input type="hidden" name="order" id="order">
                            <input type="hidden" name="payment_method" id="payment_method">
                            <input type="hidden" name="orderType" id="orderTypeInput">
                            <button type="submit" class="form-control mb-3 p-2 border-none bg-green text-white font-semibold rounded">{{__('Make your Order')}}</button>
                            <p class="text-center text-gray-600 text-sm font-light">{{__('Or Call Us at')}}<b class="font-semibold" > {{$market->mobile}}</b></p>
                        </div>
                    </div>
                </div>
            </div>
        </form>        
	</main>
    @include('balde_components.footer')
@endsection

@section('extraJs')
    <script src="https://js.stripe.com/v3/"></script>
    <script type="text/javascript">
        //variabels
        const stripe = Stripe('pk_live_51JlK8cDNOEJL9cKAujo4fLdiemhuKYiWNNwDCTpOr1YeknnQJFwx0ZFjeeogx8db1TclpmRJYsDqqXL3bUNIKViW00sAMyFImN');
        const elements = stripe.elements();
        const cardElement = elements.create('card');
        cardElement.mount('#card-element');
        var form = document.getElementById('stripe-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            // stripe.createToken(cardElement).then(function(result) {
            //     if (result.error) {
            //         // Inform the user if there was an error.
            //         var errorElement = document.getElementById('card-errors');
            //         errorElement.textContent = result.error.message;
            //     } else {
            //         // Send the token to your server.
            //         stripeTokenHandler(result.token);
            //     }
            // });
            
            stripe
            .createPaymentMethod({
                type: 'card',
                card: cardElement,
                billing_details: {
                    name: @json(auth()->user()->name),
                    email: @json(auth()->user()->email),
                },
            })
            .then(function(result) {
                if (result.error) {
                } else {
                    stripeTokenHandler(result.paymentMethod);
                }
            });
        });
        // Submit the form with the token ID.
        function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var form = document.getElementById('stripe-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'paymentMethod');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

            // Submit the form
            form.submit();
        }
        var order = JSON.parse(localStorage.getItem('order'));
        // console.log('order',order)
        // if(order.market.id !==  @json($market)?.id ) location.href=location.origin+"/notFound"        
        var default_currency = null;
        var currency_right = null;  
        var withcoupon = false;
        //functions
        const setDefaultCurrency=currency=>{
            default_currency=currency
        }
        const setCurrencyRight=isRight=>{
            currency_right=isRight
        }
        const getCurrency=()=>{
            fetch('/api/default/currency')
            .then(response => response.json())
            .then(response => setDefaultCurrency(response))
            .catch(err => console.error(err))
        }
        const getCurrencyRight=()=>{
            fetch('/api/default/currencyRight')
            .then(response => response.json())
            .then(response => setCurrencyRight(response != false))
            .catch(err => console.error(err))
        }
        const wait=()=>{
            setTimeout(function(){(default_currency != null || currency_right != null) ?showData() : wait();},5)
        }
        const showPrice=(price = 0)=>{
            if(currency_right != false){
                return price.toFixed(2) +" "+default_currency
            }
            return default_currency+" "+price.toFixed(2) 
        }
        const setMethod=methode=>{
            document.getElementById("payment_method").setAttribute("value",methode);
        }
        const checkCoupon=()=>{
            const input = document.getElementById("coupon")
            const msg = document.getElementById("coupon_msg")
            coupon= input.value 
            if (coupon === "") {
                input.classList.add("is-invalid");
                msg.innerHTML=`{{__('coupon_invalid')}} `
            }else{
                if (!withcoupon) {
                    axios
                    .get(`/api/coupon/check?coupon=${coupon}`)
                    .then(response => response.data )
                    .then(response => {                
                        if(!response.valid){
                            input.classList.add("is-invalid")
                            input.value=""
                            msg.innerHTML=`{{__('coupon_invalid')}} `
                        }else{
                            input.classList.remove("is-invalid")
                            input.classList.add("is-valid")
                            msg.innerHTML=""
                            applyCoupon(response)
                            withcoupon=true;
                        }
                    })
                    .catch((err) => {
                        input.classList.add("is-invalid");
                        console.error(err);
                    })
                }
            }
        }
        const applyCoupon = response =>{
            products=[];
            order.orders.forEach(product=>{
                products.push({
                    "id":product.product_id,
                    "price":product.oldPrice,
                    "numberOfMeals":product.numberOfMeals,
                    "category":product.productCategory
                })
            })   
            var tax = order.market.default_tax;   
            var total = order.total ;      
            var disFixed = 0;
            products.forEach(product => {
                var dis = 0 
                
                if(response.discountables.products.indexOf(product.id)>=0){
                    if(response.discount_type==="percent"){
                        dis=dis+ (product.price*response.discount)/100
                    }else{
                        disFixed=response.discount
                    }
                }else if(response.discountables.markets.indexOf(order.market.id)>=0){
                    if(response.discount_type==="percent"){
                        dis=dis+ (product.price*response.discount)/100
                    }else{
                        disFixed=response.discount
                    }
                }else if(response.discountables.categorys.indexOf(product.category)>=0 ){
                    if(response.discount_type==="percent"){
                        dis=dis+ (product.price*response.discount)/100
                    }else{
                        disFixed=response.discount
                    }
                }
                // Descuento porcentaje por cada elemento del carrito
                if(response.discount_type==="percent") {
                    total=total- dis * parseInt(product.numberOfMeals);
                } 
                /*
                // Descuento monto fijo por cada elemento del carrito
                else {
                    total=total- dis ;
                }*/
            })
            
            // Descuento sobre el precio de compra
            if(disFixed){
                total-=disFixed    
            }
            const old=`<p class="line-through ...">${document.getElementById("total").textContent}</p>`;
            document.getElementById("total").innerHTML=`${old}  ${showPrice(total+(total*tax)/100)}` 
        }
        const setNewAddress=()=>{
            var x = document.getElementById("address");
            var option = document.createElement("option");
            option.text = localStorage.getItem('geo_add');
            option.value = localStorage.getItem('geo_add'); //localStorage.getItem('geo_id');
            x.add(option, x[0]);
            x.removeAttribute('hidden')
            
            /*const addressSelect = document.getElementById("address");
            const address = addressSelect.value;
            console.log('direccion de address para añadir', address)
            
            let option = document.createElement("option")
            option.value = address;
            option.text = address;
            addressSelect.add(option)*/
            /*
            document.getElementById("address").innerHTML=
            `<div class="col-span-6 md:col-span-4">
                <label for="city" class="block text-sm font-medium text-gray-700">
                    {{__('Delivery Addres')}} 
                </label>
                <input 
                    type="text" 
                    name="address" 
                    id="address"  
                    placeholder="...." 
                    autocomplete="address"
                    required
                    value="{{ old('address') }}" 
                    class="mt-1 p-2 outline-none  block w-full shadow-sm sm:text-sm rounded  @error('address') form-control is-invalid  @enderror ">
                @error('address')
                    <div class="text-red-500 text-sm ">{{ $message }}</div>
                @enderror
            </div>   
            <div class="col-span-6 md:col-span-2">
                <label for="street_address" class="block text-sm font-medium text-gray-700">
                    {{__('Delivery Addres description')}}  
                </label>
                <input 
                    type="text" 
                    name="delivery_address_description" 
                    id="delivery_address_description" 
                    autocomplete="delivery_address_description"  
                    placeholder="example : Home"
                    required 
                    value="{{ old('street_address') }}" 
                    class="mt-1 p-2 outline-none  block w-full shadow-sm sm:text-sm rounded  @error('delivery_address_description') form-control is-invalid  @enderror " >
                @error('delivery_address_description')
                        <div class="text-red-500 text-sm ">{{ $message }}</div>
                @enderror
            </div>
            <input type="hidden" name="address_type" value="costume">
            `;*/
        }
        const _orderValid=()=>{
            // console.log('order', order)
            if (!order ||
                !["TakeAway", "Delivery"].includes(order.orderType) ||            
                order.orders === null ||
                order.orders.length === 0 ||
                order.orderType === null ||
                order.restaurant === null ||
                order.delivery_fee === null
            ){
                //localStorage.removeItem("order");
                //console.log('removiendo order')
                //location.href=location.origin+"/notFound";
            }
        }
        const showData=()=>{
            _orderValid();
            if (default_currency === null || currency_right === null) {wait()}
            else{
                var tax = order.market.default_tax;   
                var total = order.total ;         
                if(order.orderType !== "TakeAway"){
                    document.getElementById("delivery_fee").textContent=showPrice(order.delivery_fee); 
                }else{
                    document.getElementById("delivery_fee").textContent='free';
                    total=order.total-order.delivery_fee;
                    document.getElementById("address").innerHTML=``;
                }
                if(document.getElementById('orders').innerHTML === ""){
                    order.orders.forEach(element=>{
                        document.getElementById('orders').innerHTML +=`
                            <div class="flex flex-row justify-between my-2.5">
                                <div class="text-black font-normal">
                                    ${element.numberOfMeals} x ${element.product_name}
                                </div>
                                <div class="text-black font-bold ">
                                    ${showPrice(element.price)}
                                </div>
                            </div>`
                        ;
                    });
                } 
                document.getElementById("tax").textContent=tax+" %";  
                document.getElementById("total").textContent=showPrice(total+(total*tax)/100);
                document.getElementById("orderType").textContent=order.orderType;
                document.getElementById("subtotal").textContent=showPrice(order.total-order.delivery_fee);  
                document.getElementById("order").setAttribute("value",JSON.stringify(order));
                document.getElementById("payment_method").setAttribute("value","cash");
                document.getElementById("orderTypeInput").setAttribute("value",order.orderType);
            }
        }
        getCurrency();
        getCurrencyRight();
        wait();
    </script>
@endsection
@section('extraJs')
    <script type="application/javascript">
        $(document).ready(function()
        {
            var basketCount = document.querySelector('.cart-products-count');
            basketCount.innerHTML = {{$count}};   
        }) 
    </script>
@endsection