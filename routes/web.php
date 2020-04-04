<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', function(){
    return view('home');
})->name('home');

Route::get('/list', function(){
    return view('list');
})->name('list');

Route::get('/profile', function(){
    return view('profile');
})->name('profile');

Route::get('/checkout', function(){
    return view('checkout');
})->name('checkout');

Route::get('/gracias', function(){
    return view('thankyou');
})->name('thankyou');

Route::get('/confirmado', function(){
    return view('confirmation');
})->name('confirmation');

Route::get('/mis-direcciones', function(){
    return view('myAddresses');
})->name('myAddresses');

Route::get('/mis-pedidos', function(){
    return view('myOrders');
})->name('myOrders');

Route::get('/mis-datos', function(){
    return view('myAccount');
})->name('myAccount');
