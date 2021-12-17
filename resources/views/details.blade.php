@extends('layouts.master')

@section('content')
    <!-- side bar -->
    @include('balde_components.navs.side-bar')                       
    <!-- top nav bar -->
    @include('balde_components.navs.nav-bar-v2')

    <main class="m-16 min-h-screen cart">
        <div class="flex flex-col justify-center items-center h-96"  >
            <div class="w-full rounded lg:w-1/2">
                <div class="box w-full flex bg-white p-2">
                    <div class="h-full w-1/3">
                        <img src="{{ $product->getFirstMediaUrl('image') }}" alt="image" class="h-full w-full rounded-l-md object-cover" />
                    </div>
                    <div class="flex-1 relative flex flex-col justify-between rounded-r-md px-4 pt-4 pb-3 bg-white">
                        <div class="flex w-full justify-between align-items-start">
                            <div>
                                <h2 class="text-black text-2xl font-bold">{{ $product->name }}</h2>                                
                                <p>Categoria: <span class="text-gray-400">Vegetales</span></p>
                                <p class="text-gray-400 text-sm">Cosmic</p>
                                <p class="text-gray-400 text-xs">Precio</p>
                            </div>
                            <!---->
                        </div>
                        <div class="flex w-full justify-between align-items-baseline">
                            <div class="flex flex-row items-center">
                                <div class="text-green text-base font-bold sm py-1 px-2"><span>$</span>{{ $product->price }}</div>
                                <!---->
                            </div>
                        </div>
                        <div class="flex w-full justify-between align-items-baseline">
                            <div class="quantity buttons_added">
                                <input type="button" value="-" class="minus">
                                <input type="number" step="1" min="1" max="" value=1 name="quantity" title="Qty" size="4" pattern="" inputmode="" class="input-text qty text">
                                <input type="button" value="+" class="plus"></div>                        
                        </div>
                        <button class="button add-to-cart">Añadir al carrito</button>
                    </div>
                </div>

             </div>
        </div>
    </main>
    
    @include('balde_components.footer')
@endsection