<nav class="side-bar" id="side-bar" >
    <i id="cancel"> &times</i>
    <div class="top">
        <!-- <i class="fab fa-shopify text-2xl"></i>
        <span>{{ setting('app_name') }}</span> -->
        <a href="/"><img src="{{ asset('images/cosmic_logo.png') }}" width="100" height="70"></a>
    </div>
    <div class="links">
        <ul>
            <li><a href="/" class="{{ (request()->is('/')) ? 'active' : '' }}"> <i class="fas fa-home "></i> &nbsp; {{__("Inicio")}}</a></li>
            <!-- <li><a href="/markets"><i class="fas fa-store "></i> &nbsp; {{__("Markets")}}</a></li> -->
            <!-- <li><a href="/products"> <i class="fas fa-cubes "></i> &nbsp; {{__("Products")}}</a></li> -->
            <!-- <li><a href="/help"><i class="fas fa-info "></i> &nbsp; {{__("About")}}</a></li> -->
            <li><a href="/category/5" class="{{ (request()->is('category/5')) ? 'active' : '' }}"> <i class="fas fa-lemon "></i> &nbsp; {{__("Frutas")}}</a></li>
            <li><a href="/category/7" class="{{ (request()->is('category/7')) ? 'active' : '' }}"> <i class="fas fa-carrot "></i> &nbsp; {{__("Verduras")}}</a></li>
            <li><a href="/category/8" class="{{ (request()->is('category/8')) ? 'active' : '' }}"> <i class="fas fa-utensils "></i> &nbsp; <span class="text-s">{{__("Consentidos del Hogar")}}<span></a></li>
            @guest
                <li><a href="/login" class="{{ (request()->is('login')) ? 'active' : '' }}"><i class="icon fas fa-sign-in-alt"></i> &nbsp; {{__("Login")}} </a></li>
            @else
                <li><a href="/wishlist" class="{{ (request()->is('wishlist')) ? 'active' : '' }}"><i class="icon far fa-heart"></i> &nbsp; {{__("Favorites")}}  </a></li>
                <li><a href="/cart" class="{{ (request()->is('cart')) ? 'active' : '' }}"><i class="icon fas fa-shopping-basket"></i> &nbsp; {{__("Carrito")}}  </a></li>
                <li><a href="/my-account" class="{{ (request()->is('my-account')) ? 'active' : '' }}"><i class="icon far fa-user"></i> &nbsp; {{__("My account")}} </a></li>
                <li>
                    <a  href="{{ route('logout') }}" 
                    onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                    ><i class="icon fas fa-door-open"></i> &nbsp;{{__("Logout")}} </a>
                </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                </form>
           @endguest

            {{-- <li>
                <a class="drop_down_btn" href="#">pages <i class="fas fa-caret-down down"></i> </a>
                <ul>
                    <li> <a href="./index.html">Inicio</a></li>
                    <li> <a href="./confirm-delivery.html">Confirmar</a></li>
                    <li> <a href="./grid-listing-filterscol-map.html">grid</a></li>
                <li> <a href="#">page4</a></li>
                </ul>
            </li> --}}

        </ul>
    </div>
</nav>