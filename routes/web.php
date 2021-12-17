<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use \App\Http\Controllers\HomeController;
use \App\Http\Controllers\CategoryController;
use \App\Http\Controllers\FieldsController;
use \App\Http\Controllers\ProductController;
use \App\Http\Controllers\MarketController;
use \App\Http\Controllers\ReviewController;
use \App\Http\Controllers\OrderController;
use \App\Http\Controllers\CartController;
use \App\Http\Controllers\Auth\AuthSocialiteController;
use \App\Http\Controllers\api\CartController as ApiCartController;

Auth::routes();
Route::view('/help', 'pages.help');
Route::view('/gianmel', 'pages.gianmel');
Route::view('/terminos', 'pages.terminos');
Route::view('/aviso-legal', 'pages.avisol');
Route::view('/sobren', 'pages.sobren');
Route::view('/descar', 'pages.descar');
Route::view('/contacto', 'pages.contacto');
Route::view('/contactus', 'pages.contactus');
Route::view('/pagose', 'pages.pagose');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search']);
Route::get('/category/{category:id}', [CategoryController::class, 'index']);
Route::get('/fields/{field:id}', [FieldsController::class, 'index']);
Route::get('/products', [ProductController::class, 'index']);

Route::prefix('/markets')->group(function () {
    Route::view('/', 'markets.listing');
    Route::get('/{market:id}', [MarketController::class, 'show']);
});

Route::get('/producto/{product:slug}', [ProductController::class, 'details']);

Route::middleware('auth')->group(function () {
    Route::redirect('/home', '/');
    Route::view('/my-account', 'auth.account.profile');
    Route::view('/contact-us', 'pages.contactus');
    Route::view('/wishlist', 'pages.wishlist');
    
    Route::get('/cart', [CartController::class, 'index'])->name('cart');

    Route::get('/favorites/product/{skip}', [HomeController::class, 'favoriteProducts']);
    Route::prefix('/markets')->group(function () {
        Route::prefix('/review')->group(function () {
            Route::get('/{market:id}', [ReviewController::class, 'create']);
            Route::post('/{market:id}', [ReviewController::class, 'store'])->name('review');
        });
    });
    Route::prefix('/order')->group(function () {
        Route::get('/market/{market:id}', [OrderController::class, 'index']);
        Route::post('/', [OrderController::class, 'store'])->name('order');
        Route::get('/confirm', [OrderController::class, 'confirm']);
        Route::get('/not-confirm', [OrderController::class, 'notConfirm']);
    });
});

Route::prefix('/auth/{driver}')->group(function () {
    Route::get('/register', [AuthSocialiteController::class, 'register']);
    Route::get('/login', [AuthSocialiteController::class, 'login']);
    Route::get('/callback', [AuthSocialiteController::class, 'callback']);
});

Route::get('/terms' , function(){

    return view('terms');

});

Route::get('/private' , function(){

    return view('private');

});

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    return "Cleared!";
});

Route::middleware('auth')->prefix('/api/cart')->group( function () {
    Route::get('/show/{cartid?}', [ApiCartController::class, 'show']);
    Route::put('/add', [ApiCartController::class, 'store']);
    Route::post('/update/{id}', [ApiCartController::class, 'update']);
    Route::delete('/delete/{cart}', [ApiCartController::class, 'destroy']);
    Route::get('/count', [ApiCartController::class, 'count']);
});