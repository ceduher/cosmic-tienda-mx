@extends('layouts.master')

@section('extraStyle')    
<style>
    .tab-pane table {
        width: auto !important;
    }
</style>
@endsection
@section('content')
    <!-- side bar -->
    @include('balde_components.navs.side-bar')                       
    <!-- top nav bar -->
    @include('balde_components.navs.nav-bar-v2')

    <main class="cart pb-5">
        <header class="row">
            <div class="container lg:px-32 flex flex-col md:flex-row md:justify-between items-center my-3">
                <div class="">
                    <div class="text-black text-sm py-1 ">
                        <a href="/" class="hover:text-gray-800 hover:no-underline">
                            Inicio
                        </a> &nbsp; > &nbsp;
                        <a href="/category/" class="text-green hover:text-green-400 hover:no-underline">
                            {{$product->category->name}}
                        </a>
                    </div>
                </div>
            </div>
        </header>
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-4">
                    <img src="{{ $product->getFirstMediaUrl('image') }}" alt="image" class="h-full rounded-l-md object-cover" />
                </div>
                <div class="col px-5 px-md-0 py-4 p-mb-0">
                    <div class="mt-2">
                        <h2 class="text-black text-2xl font-bold">{{ $product->name }}</h2>                               
                        <p>Categoria: <span class="text-gray-400">Vegetales</span></p>
                    </div>
                    <div class="flex items-center my-2">
                        <p class="text-gray-400 text-xs">Precio</p>
                        <div class="text-green font-bold h4 py-1 px-2"><span>$</span>{{ $product->price }}</div>
                    </div>
                    <cart-add :cartid={{ $cartid }} :id={{ $product->id }} :stock={{ $product->qty }}></cart-add>

                    <div class="mt-4 px-4 bg-white">
                        <ul class="nav nav-tabs nav-fill bg-white" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link text-green text-left" data-toggle="tab" href="#duck" role="tab" aria-controls="duck" aria-selected="true">Descripción</a>
                            </li>
                        </ul>
                        
                        <div class="tab-content mt-3 pb-4">
                        <div class="tab-pane active" id="duck" role="tabpanel" aria-labelledby="duck-tab">
                            <div>{!! $product->description !!}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="flex flex-col justify-center items-center "  >
            <div class="w-full rounded mb-2">
                <div class="box w-full flex p-2">
                    <div class="h-full w-1/3 text-right justify-items-end">
                        <img src="{{ $product->getFirstMediaUrl('image') }}" alt="image" class="h-full rounded-l-md object-cover" />
                    </div>
                    <div class="flex-1 flex flex-col justify-between rounded-r-md px-4 pt-4">
                        <div class="flex h-full w-full justify-between align-items-start">
                            <div>
                                <h2 class="text-black text-2xl font-bold">{{ $product->name }}</h2> 
                                                             
                                <p>Categoria: <span class="text-gray-400">Vegetales</span></p>
                            </div>
                        </div>
                        <div class="flex w-full justify-between">
                            <div class="flex items-center">
                                <p class="text-gray-400 text-xs">Precio</p>
                                <div class="text-green font-bold h4 py-1 px-2"><span>$</span>{{ $product->price }}</div>
                            </div>
                        </div>
                        <cart-add :cartid={{ $cartid }} :id={{ $product->id }}></cart-add>
                        <div class="flex flex-col w-full">
                            <div class="mb-2 flex align-items-center">
                                <i class="fas fa-lock fa-2x mr-2"></i><h3> Pago seguro </h3>
                            </div>
                            <div class="mb-2 flex align-items-center">
                                <i class="fas fa-truck fa-2x"></i><h3> Entregas a Tiempo<h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container mt-5 pt-4">
                    <div class="row bg-white">
                        <div class="col-12">
                          <ul class="nav nav-tabs nav-fill bg-white" role="tablist">
                            <li class="nav-item">
                              <a class="nav-link text-green text-left" data-toggle="tab" href="#duck" role="tab" aria-controls="duck" aria-selected="true">Descripción</a>
                            </li>
                          </ul>
                         
                          <div class="tab-content mt-3 pb-4">
                            <div class="tab-pane active" id="duck" role="tabpanel" aria-labelledby="duck-tab">
                                {!! $product->description !!}  
                            </div>
                        </div>
                    </div>
                </div>
             </div>
        </div> -->
    </main>
    @include('balde_components.footer')
@endsection
@section('extraJs')
<!-- <script type="application/javascript">
        $(document).ready(function()
        {
            var basketCount = document.querySelector('.cart-products-count');
            basketCount.innerHTML = {{$count}};   
        }) 
</script> -->
@endsection