@extends('layouts.master')
@section('extraStyle')
@section('content')
<!-- side bar -->
@include('balde_components.navs.side-bar')
<!-- top nav bar -->
@include('balde_components.navs.nav-bar-v1')
{{-- banner  --}}


 <div style="padding: 80px; text-align: justify">

    <h1 align="center" class="text-green font-bold text-2xl pt-3 pb-2">Sobre nosotros</h1>
   <br></br>
    
    <h1 class="text-green font-bold text-2xl pt-3 pb-2">COSMIC</h1>
    <br></br>
   
    
    <h3 class="text-green font-bold text-1xl pt-3 pb-2">Nuestra empresa</h3>
    <span>Somos la empresa líder del sureste mexicano en la distribución y comercialización de frutas y vegetales ofreciendo la mejor calidad del mercado.</span>
    
   
</div>
<footer class="container lg:px-32 lg:px-32 flex flex-col flex-wrap mx-auto md:items-center lg:items-start md:flex-row md:flex-no-wrap mb-10">

   
</footer>

@include('balde_components.footer')
@endsection













































