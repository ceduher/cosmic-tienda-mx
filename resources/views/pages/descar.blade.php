@extends('layouts.master')
@section('extraStyle')
@section('content')
<!-- side bar -->
@include('balde_components.navs.side-bar')
<!-- top nav bar -->
@include('balde_components.navs.nav-bar-v1')
<div style="padding: 80px; text-align: center">
  <h1 class="text-green font-bold text-2xl pt-3 pb-2">Descarga Nuestra Aplicación</h1>
  <br/>
  <!-- <br/>
  <h1 class="text-green font-bold text-2xl pt-3 pb-2">Para dispositivos iOS</h1>
  <table border="0" align="center">
    <tr>
      <td>
        <a href="https://apps.apple.com/mx/app/cosmic-mx/id1592934876">
          <img src="/images/app-store1.png" width="350" height="44" algin="center"/>
        </a>
      </td>
    </tr>
  </table> -->
  <h1 class="text-green font-bold text-2xl pt-3 pb-2">Para dispositivos Android</h1>
  <table border="0" align="center">
    <tr>
      <td>
        <a href="https://play.google.com/store/apps/details?id=com.cosmicmx.markets">
          <img src="/images/google-play-badge.png" width="350" height="44" />
        </a>
      </td>
    </tr>
  </table>
  <!-- 
    <a href="https://apps.apple.com/mx/app/cosmic-mx/id1592934876">
      <img src="app-storejpg.jpg" width="117" height="33" border="0" />
    </a>
    <p class="text-white text-xl font-semibold my-2 ">
      <img src="pizza.jpg" width="564" height="168" />
    </p> 
  -->
</div>
<footer class="container lg:px-32 lg:px-32 flex flex-col flex-wrap mx-auto md:items-center lg:items-start md:flex-row md:flex-no-wrap mb-10">
</footer>
@include('balde_components.footer')
@endsection













































