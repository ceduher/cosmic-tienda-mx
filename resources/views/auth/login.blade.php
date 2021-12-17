@extends('layouts.master')

@section('extraStyle')
<link href="{{ asset('css/confirm-delivery.css') }}" rel="stylesheet">
<link href="{{ asset('css/sign-in.css') }}" rel="stylesheet">

@endsection

@section('content')
<!-- side bar -->
@include('balde_components.navs.side-bar')
<!-- top nav bar -->
@include('balde_components.navs.nav-bar-v2')

<main class="w-full mb-2 flex flex-row justify-center px-3 px-sm-0">
    <div class="container lg:px-32 lg:w-3/5 xl:w-2/3 mt-6 shadow-2xl p-0  bg-white" style="height:fit-content;">
        <ul class="nav w-full flex flex-col md:flex-row justify-between" id="myTabn" role="tablist">
            <li class="nav-item flex-1" role="presentation">
                <a class="nav-link custom-btn active text-center hover:bg-gray-100 " id="login-tab" data-toggle="tab" href="#login" role="tab" aria-controls="login" aria-selected="true">
                    ¿Tienes cuenta? <b> Inicia sesión</b>
                </a>
            </li>
            <li class="nav-item custom-btn flex-1" role="presentation">
                <a class="nav-link custom-btn text-center hover:bg-gray-100 " id="sign-tab" data-toggle="tab" href="#register" role="tab" aria-controls="register" aria-selected="false">
                    ¿Eres nuevo? <b> Crea tu cuenta </b>
                </a>
            </li>
        </ul>
        <div class="tab-content" id="myTabnContent">
            <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                <div class="flex">
                    <div class="w-0 sm:w-1/2" style="background-image: url('/images/prueba.jpeg'); background-size: cover; background-position: center center">

                    </div>
                    <div class="w-full sm:w-1/2 pt-2 pb-4 px-2 px-sm-4 px-md-8">
                        @include('auth.forms.login')
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                <div class="flex">
                    <div class="w-full sm:w-1/2 pt-2 pb-4 px-2 px-sm-4 px-md-8">
                        @include('auth.forms.register')
                    </div>
                    <div class="w-0 sm:w-1/2" style="background-image: url('/images/prueba2.jpg'); background-size: cover; background-position: center center">
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@include('balde_components.footer')
@endsection