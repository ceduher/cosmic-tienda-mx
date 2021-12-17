<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script type="text/javascript" defer>
            const google_maps_key = "<?php echo setting('google_maps_key');?>"; 
            const LANG_I18N = "<?php echo setting('language');?>"; 
        </script>
        <style>
            :root {
                --main_color:{{setting('main_color')}};
            }
        </style>
        {{-- fonts --}}
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        {{-- title of the site --}}
        <title>{{ setting('app_name') }} @yield('title')</title>
        {{-- tab icon --}}
        <link rel="shortcut icon" href="" type="image/x-icon"/>
        {{-- bootstrap css --}}
        <link href="{{ asset('css/app.css') }}?vjs=2.0.0" rel="stylesheet">
        {{-- tailwind css --}}
        <link href="{{ asset('css/tailwind.css') }}?vjs=2.0.0" rel="stylesheet">
        {{-- main style --}}
        <link href="{{ asset('css/main.css') }}?vjs=2.0.0" rel="stylesheet">
        {{-- costume style --}}
        <link href="{{ asset('css/style.css') }}?vjs=2.0.0" rel="stylesheet">
        {{-- extraStyle --}}
        <style>
            main {
                background-image: url("/images/bg.jpg");
                backdrop-filter: opacity(0.3) !important;
                margin-top: 60px;
                width: 100% !important;
                overflow-x: hidden !important;
            }
            .bg-orange-400{
                background-color: rgb(251 146 60);
            }
            .bg-orange-300{
                background-color: rgb(253 186 116);
            }
            .text-orange-400{
                color: rgb(253 186 116);
            }
        </style>
        @yield('extraStyle')
    </head>
@if (\Route::currentRouteName() == 'home')
    <body class="modal-active">
@else
    <body>
@endif
        <!--Modal-->
        @if (\Route::currentRouteName() == 'home')
        <div class="modal fixed w-full h-full top-0 left-0 flex items-center justify-center">
          <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
          <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
            <div class="modal-close absolute top-0 right-0 cursor-pointer flex flex-col items-center mt-4 mr-4 text-white text-sm z-50">
              <svg class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
              </svg>
              <span class="text-sm">(Cerrar)</span>
            </div>
            <!-- Add margin if you want to see some of the overlay behind the modal-->
            <div class="modal-content py-4 text-left px-6">
              <!--Body-->
              <div style="padding: 80px 0px; text-align: center">
                <h1 class="text-orange-400 font-bold text-2xl pt-3 pb-2">Descarga Nuestra Aplicación</h1>
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
              <!--Footer-->
              <div class="flex justify-end pt-2">
                <button class="modal-close px-4 bg-orange-400 p-3 rounded-lg text-white hover:bg-orange-300">Cerrar</button>
              </div>
            </div>
          </div>
        </div>
        @endif 

        <div id="app">
            <button type="button" id="top" class="z-50 hidden bg-green text-white text-2xl py-1 px-2 rounded-full outline-none border-none fixed bottom-2 right-5">
                <i class="fas fa-chevron-up"></i>
            </button>
            @yield('content')
            <example-component></example-component>
        </div>
        <script src="{{asset('js/app.js')}}?v=2.0.0"></script>
        <script src="{{asset('js/main.js')}}?v=2.0.0"></script>
        <script src="{{asset('js/costum-slick.js')}}?v=2.0.0"></script>
        @yield('extraJs')
        @error('search')
            <script type="application/javascript">
                Vue.notify({
                    group: 'bar',
                    type: 'error',
                    title: "<?php echo __('Important message') ?> ",
                    text: "<?php echo __('search Error') ?> "
                })
            </script>
        @enderror
        @if(Session::get('purchased-product'))
            <script type="application/javascript">
                Vue.notify({
                    group: 'bar',
                    type: 'error',
                    title: "<?php echo __('Oops! Alguien ha comprado tu producto') ?> ",
                    text: "<?php echo __('Verifica los productos de tu carrito e intenta nuevamente.') ?> "
                })
            </script>
        @endif
    </body>
</html>