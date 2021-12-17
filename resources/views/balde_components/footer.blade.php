<footer class="text-white bg-black  body-font  ">
    <div class="container lg:px-32 flex flex-col flex-wrap  px-11 py-2 md:px-5 mx-auto md:items-center lg:items-start md:flex-row md:flex-no-wrap ">
        <div class="flex flex-wrap flex-grow mt-8  text-left md:py-5 md:mt-0 ">
            <div class="w-full px-0 lg:w-1/2 md:w-1/2 mb-4 mb-md-0">
                <p class="text-lg text-gray-200 mx-md-3 font-semibold ">
                    INFORMACIÓN DE LA TIENDA
                </p>
                <p class="text-sm text-gray-200 mx-md-3 mb-3">
                    Av. Yucatán 582, local 11, Col. Maya <br>
                    97134 Mérida, Yucatán, México<br>
                </p>
                <p class="text-sm text-gray-200 mx-md-3 mb-2">
                    Envíenos un correo a: info@cosmicmx.com
                </p>
                <p class="text-sm text-gray-200 mx-md-3 ">
                    Téfono: +52 999 114 5236
                </p>
            </div>
            <div class="w-full px-0 lg:w-1/2 md:w-1/2">
                <p class="text-lg text-gray-200 font-semibold ">
                    {{__("COSMIC")}}
                </p>
                <nav class="mb-10 list-none">
                    <!-- <li>
                        <a href="" class="text-sm text-gray-400 hover:text-gray-500 cursor-pointer ">
                            Envío
                        </a>
                    </li> -->
                    <li>
                        <a href="/aviso-legal" class="text-sm text-gray-400 hover:text-gray-500 cursor-pointer ">
                            Aviso legal
                        </a>
                    </li>
                    <li>
                        <a href="/terminos"class="text-sm text-gray-400 hover:text-gray-500 cursor-pointer ">
                            Términos y condiciones
                        </a>
                    </li>
                    <li>
                        <a href="/sobren" class="text-sm text-gray-400 hover:text-gray-500 cursor-pointer ">
                            Sobre nosotros
                        </a>
                    </li>
                    <!-- <li>
                        <a href="/pagose" class="text-sm text-gray-400 hover:text-gray-500 cursor-pointer ">
                            Pago Seguro 🔒
                        </a>
                    </li> -->
                    <li>
                        <a href="/contacto" class="text-sm text-gray-400 hover:text-gray-500 cursor-pointer ">
                            Contáctanos
                        </a>
                    </li>
                </nav>
            </div>
            {{-- <div class="w-full px-0 lg:w-1/3 md:w-1/2">
                <p class="text-lg text-gray-200 font-semibold ">
                    DESCARGA NUESTRA APLICACIÓN
                </p>
                <div class="mb-10 flex flex-col md:flex-row">
                    <a href="https://play.google.com/store/apps/details?id=com.cosmicmx.markets" target="_blank"
                        class="nav-link w-full">
                        <img src='/images/google.png'  width="100%" height="180px" />
                    </a>
                    <a href="https://apps.apple.com/us/app/cosmic-mx/id1592934876" target="_blank"
                        class="nav-link w-full">                    
                        <img src='/images/app-store.png' width="120%" height="180px"  />
                    </a>
                    <a href="#" class="nav-link w-full md:w-1/2 rounded bg-white text-black hover:text-gray-300 mt-1 md:mr-2 h-12 flex items-center justify-center">
                        <img src='/images/google.png' />
                         <span class="font-semibold">
                            {{__("Google Play")}}
                        </span> 
                    </a>
                    <a href="#" class="nav-link w-full md:w-1/2 rounded bg-white text-black hover:text-gray-300 mt-1 md:mr-2 h-12 flex items-center justify-center">
                        <img src='/images/app-store.png' />
                        <span class="font-semibold">
                            {{__("App Store")}}
                        </span>
                    </a>
                </div>
            </div> --}}
        </div>
    </div>
   <div class="" style="background: #222;">
        <div class="">
             <span  align="center" class="">
                <p class="text-sm text-center text-gray-200 sm:text-left ">
                    {{setting('app_name')}} © {{__("All copyrights reserved")}}
                </p>
            </span>
            {{--<div class="dropdown dropup">
                <button type="button" class="bg-gray-200 py-1 px-2 -mt-2 text-black rounded-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-globe "></i> {{__("Language")}}
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a id="en" onclick="setLanguage(this.id)" class="dropdown-item cursor-pointer flex flex-row items-center">
                        <img width="30" height="30" src="/images/flags/uk_flag.png" alt="flag" class="mr-2 rounded-sm">
                        <span>{{__("English")}}</span>
                    </a>
                </div>
            </div>--}}
            <script type="application/javascript">
                function setLanguage(lang) {
                    loadLanguageAsync(lang);
                }
            </script>
        </div>
    </div>
</footer>
{{-- localStorage.setItem('language', lang) --}}