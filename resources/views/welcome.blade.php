@extends('layouts.master')

@section('extraStyle')
<style>
    @media(max-width: 1200px) {
        .container.lg\:px-32.py-5 {
            padding-top: 0px !important;
        }
        #slides .vueperslides {
            height: 160px !important;
        }
    }
    @media(max-width: 600px) {
        #slides .vueperslides {
            height: 120px !important;
        }
    }
    @media(max-width: 500px) {
        #slides .vueperslides {
            height: 100px !important;
        }
    }
</style>
@endsection

@section('content')
<!-- side bar -->
@include('balde_components.navs.side-bar')
<!-- top nav bar -->
@include('balde_components.navs.nav-bar-v1')
{{-- banner  --}}
<main class="pt-4">
<!-- body overlay -->
<div class="body-blackout"></div>
    <banner></banner>
    <main-index  
        :cartid={{ $cartid }}
        :app_name="`{{setting('app_name')}}`"
        :countMarket={{$countMarket}}>
    </main-index>
    <footer class="container lg:px-32 lg:px-32 flex flex-col flex-wrap mx-auto md:items-center lg:items-start md:flex-row md:flex-no-wrap pb-10">
        <div class="w-full mb-10">
            <img alt="" src="/images/placeholder9.jpg" style="width: 100%; height: 100%; max-height: 425px;">
        </div>
        <div class="w-full lg:w-1/3 md:w-full pr-2">
            <a href="women" aria-label="Advertisement">
                <img alt="" src="/images/placeholder1.jpg" style="width: 100%; height: 100%; max-height: 425px;">
            </a>
        </div>
        <div class="w-full lg:w-1/3 md:w-full pr-2">
            <a aria-label="Advertisement">
                <img alt="" src="/images/placeholder2.jpg" style="height: 100%; width: 100%; max-height: 425px;">
            </a>
        <div style="height: 10px;"></div>
            <a aria-label="Advertisement">
                <img alt="" src="/images/placeholder3.jpg" style="height: 100%; width: 100%; max-height: 425px;">
            </a>
        </div>
        <div class="w-full lg:w-1/3 md:w-full">
            <a href="kids" aria-label="Advertisement">
                <img alt="" src="/images/placeholder8.jpg" style="width: 100%; height: 100%; max-height: 425px;">
            </a>
        </div>
        <div class="w-full bg-white p-10 text-center mt-8">
            <p class="text-2xl">
                Somos la empresa líder del sureste mexicano en la distribución y comercialización de frutas y vegetales ofreciendo la mejor calidad del mercado.
            </p>
        </div>
    </footer>
</main>

@include('balde_components.footer')
@endsection