@extends('layouts.master')
@section('content')
   <!-- side bar -->
   @include('balde_components.navs.side-bar')                       
   <!-- top nav bar -->
   @include('balde_components.navs.nav-bar-v2')
   <main class="min-h-screen cart" style="min-height: 100vh;">
      <div class="flex flex-col justify-center items-center h-auto mt-md-5">
         <div class="w-full rounded lg:w-1/2">
            <div class="w-full border-2 rounded border-gray-300 border-dotted">
               <div class="text-center border-b-2 bg-gray-100 border-gray-300 border-dotted py-3">
                  <p class="text-2xl font-bold">Carrito de Compras</p>
                  <p class="text-red-600 font-semibold">Por favor verifique su pedido</p>
               </div>
               <div class="py-3 px-4 flex flex-col bg-white">
                  <cart-list 
                     :cartid="{{ $cartid }}"
                     :market="{{ json_encode($market) }}"
                     :products='{{ json_encode($products)}}'>
                  </cart-list>
               </div>
            </div>
         </div>
      </div>
   </main>
   @include('balde_components.footer')
@endsection