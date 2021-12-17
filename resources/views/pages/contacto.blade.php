@extends('layouts.master')
@section('extraStyle')
@section('content')
<!-- side bar -->
@include('balde_components.navs.side-bar')
<!-- top nav bar -->
@include('balde_components.navs.nav-bar-v1')
{{-- banner  --}}


 <div style="padding: 30px; margin-top:40px; text-align: justify">
     


    <h1 align="center" class="text-green font-bold text-2xl pt-3 pb-2">CONTACTA CON NOSOTROS</h1>
   <br></br>
    
    <h1 class="text-green font-bold text-1xl pt-3 pb-2">INFORMACIÓN DE LA TIENDA</h1>
    <br></br>
   

<table  border="0">
  <tr>
    <td width="70"><img src='/images/z1.png' alt="image"  alt="image" width="26" height="32"></td>
    <td colspan="2">
        Av. Yucatán 582, local 11, Col. Maya 
    97134 Mérida, Yucatán, México</td>
  </tr>
<tr>
    <td></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><img src='/images/z2.png' alt="image"  alt="image" width="26" height="32"></td>
    <td colspan="2">
        
Llámenos: 
+52 999 114 5236
    </td>
  </tr>
  <tr>
    <td></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><img src='/images/z3.png' alt="image"  alt="image" width="26" height="32"></td>
    <td colspan="2">
Envíenos un correo a:
info@cosmicmx.com</td>
  </tr>
</table>
  
</div>
<footer class="container lg:px-32 lg:px-32 flex flex-col flex-wrap mx-auto md:items-center lg:items-start md:flex-row md:flex-no-wrap mb-10">

   
</footer>

@include('balde_components.footer')
@endsection













































