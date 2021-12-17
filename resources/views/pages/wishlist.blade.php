@extends('layouts.master')

@section('title')
    | {{__('Favorites')}}
@endsection

@section('content')
    <!-- side bar -->
    @include('balde_components.navs.side-bar')                       
    <!-- top nav bar -->
    @include('balde_components.navs.nav-bar-v1')
    <main class="w-full" >
		<div class="  w-full  relative flex justify-center  " style="height: 65vh;">
		    <img src="/images/placeholder7.jpg" alt="banner" class="absolute w-full h-full opacity-70 object-cover z-0">
			<div class="w-full h-full bg-black"></div>
			<div class=" container  absolute  w-11/12 md:w-2/3 flex flex-col justify-center text-center   h-96 ">
			
			</div>
		</div>
		<section class="flex flex-col">
			<div class="container">
                <div class="w-full pt-16 text-center">
					<div class="w-full  self-center content-center flex flex-row justify-center -mt-4 mb-6">
                        <p class="border-1 border-green w-44"></p>
                    </div>
                    <h2 class="text-black text-4xl font-semibold py-1 text-center" >
                        {{__('Tus favoritos')}}
                    </h2>
                   
				</div>
                <favorites @auth :idAuth={{auth()->id()}} @endauth></favorites>
            </div>        
		</section>
	</main>
    @include('balde_components.footer')
@endsection