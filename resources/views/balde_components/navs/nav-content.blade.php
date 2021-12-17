<!-- navbar-brand -->
<div >
    <button id="show-side-bar" class="lg:hidden nav-link absolute left-4 top-2 w-10 h-10 outline-none text-lg border-none"><i class="fas fa-align-left"></i></button>
    <a href="/"><img src="{{ asset('images/cosmic_logo.png') }}" width="80" height="70"></a>
</div>

<div>

    <!-- links -->
    <div class="hidden lg:flex lg:flex-row">
        <ul class="navbar-nav flex flex-row mr-auto ">
            <li class="nav-item flex align-items-center">
                <form 
                        class=" w-full h-12 md:w-4/5 md:h-4/6 bg-white flex flex-row rounded "
                        action="/search"
                        method="get">
                    {{-- @csrf --}}
                    <input
                    class="flex-1 bg-white outline-none py-3 pl-3  rounded-l-sm"
                        name="search"
                        type="search"
                        placeholder="Búsqueda por producto   "
                        required
                        autocomplete="off"
                        style="min-width: 230px;"
                    >
                    <button class=" bg-green rounded-r-s text-white" type="submit"> <i class="w-8 fas fa-search"></i></button>
                </form>
            </li>
            <li class="nav-item ml-3 flex  align-items-center">
                <a class="nav-link uppercase" aria-current="page" href="/"> 
                
                    {{__("Inicio")}}
                </a>
            </li>
        
            <li class="nav-item ml-3 flex align-items-center">
                <a class="nav-link uppercase text-s" aria-current="page" href="/category/5">
                
                    {{__("Frutas")}}
                </a>
            </li>
            <li class="nav-item ml-3 flex align-items-center">
                <a class="nav-link uppercase text-s" aria-current="page" href="/category/7">
            
                    {{__("Verduras")}}
                </a>
            </li>
            <li class="nav-item ml-3 flex align-items-center">
                <a class="nav-link uppercase text-s" aria-current="page" href="/category/8">
                
                    {{__("Consentidos del Hogar")}}
                </a>
            </li>
            
            {{--@guest
                <li class="nav-item ml-3 d-flex align-items-center">
                    <a class="nav-link" href="/login">
                        <img src='/images/Logout_ico.png' alt="image"  alt="image" width="26" height="32">
                    </a>
                </li>
                <li class="nav-item ml-3 d-flex align-items-center">
                    <div class="blockcart">
                        <a rel="nofollow" href="/cart">
                            <!-- <span class="cart-products-count">0</span> -->
                            <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                        </a>
                    </div>
                </li>
            @else
            <li class="nav-item ml-3 d-flex align-items-center">
                <a class="nav-link" href="/wishlist"><i class="icon far fa-heart"></i></a>
            </li>
            <li class="nav-item ml-3 d-flex align-items-center">
                <div class="btn-group">
                    <button type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <!-- {{auth()->user()->name}} -->
                        <img src='/images/Logout_ico.png' alt="image"  alt="image" width="26" height="32">
                    </button>
                    <div class="dropdown-menu dropdown-menu-left -ml-20 mt-3" aria-labelledby="triggerId">
                        <a class="dropdown-item text-black p-2"  href="/my-account" >
                            <i class="fas fa-user" ></i> <span>{{__("My account")}}</span>
                        </a>
                        <a class="dropdown-item text-red-500 hover:text-red-400 hover:bg-gray-50 p-2" 
                            href="{{ route('logout') }}" 
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="fas fa-door-open" ></i> <span>Cerrar Sesión</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>    
            </li>
            <li class="nav-item ml-3 d-flex align-items-center">
                <div class="blockcart">
                    <a rel="nofollow" href="/cart">
                        <span class="cart-products-count" id="cart-count-nav">@if($countCart > 0) {{ $countCart }} @else 0 @endif</span>
                        <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                    </a>
                </div>
            </li>
            @endguest --}}

            @guest
                <li class="nav-item ml-2 d-flex align-items-center">
                    <a class="nav-link" href="/login">
                        <img src='/images/Logout_ico.png' alt="image"  alt="image" width="26" height="32">
                    </a>
                </li>
                <li class="nav-item ml-3 d-flex align-items-center">
                    <div class="blockcart">
                        <a rel="nofollow" href="/cart">
                            <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                        </a>
                    </div>
                </li>
            @else
                <li class="nav-item ml-3 d-flex align-items-center">
                    <div class="btn-group text-sm flex">
                        <button type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <div class="hidden lg:hidden md:flex flex-column mr-2 text-right">
                                    <span>{{auth()->user()->name}}</span>
                                    <small class="text-muted">{{auth()->user()->email}}</small>
                                </div>
                                {{-- <img src="{{auth()->user()->getFirstMediaUrl('avatar')}}" class="rounded-full object-cover w-8 h-8 shadow-xl" alt="user"> --}}
                                <img src='/images/Logout_ico.png' alt="image"  alt="image" width="26" height="32">
                            </div>
                        </button>
                        <div class="dropdown-menu dropdown-menu-left -ml-28 mt-3" aria-labelledby="triggerId">
                            <a class="dropdown-item text-black p-2"  href="/my-account" >
                                <i class="fas fa-user" ></i> <span>{{__("My account")}}</span>
                            </a>
                            <a class="dropdown-item text-red-500 hover:text-red-400 hover:bg-gray-50 p-2" 
                                href="{{ route('logout') }}" 
                                onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <i class="fas fa-door-open" ></i> <span>Cerrar Sesión</span>
                            </a>
                        </div>
                    </div> 
                </li>
                <li class="nav-item ml-3 d-flex align-items-center">
                    <div class="blockcart">
                        <a rel="nofollow" href="/cart">
                            <span class="cart-products-count" id="cart-count-nav">@if($countCart > 0) {{ $countCart }} @else 0 @endif</span>
                            <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                        </a>
                    </div>
                </li>
            @endguest
        </ul>
    </div>

    

</div>

