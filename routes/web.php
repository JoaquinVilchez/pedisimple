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




Route::get('/gracias', function(){
    return view('thankyou');
})->name('thankyou');

Route::get('/confirmado', function(){
    return view('confirmation');
})->name('confirmation');


Route::post('/cart', 'CartController@store')->name('cart.store');

Route::post('/cart/remove/{id}', 'CartController@remove')->name('cart.remove');

Route::post('/cart/update', 'CartController@update')->name('cart.update');

Route::get('/cart/empty', 'CartController@empty')->name('cart.empty');

Route::get('/checkout', 'CheckoutController@index')->name('checkout.index');
Route::post('/checkout/confirm', 'CheckoutController@store')->name('checkout.store');
//Ver direcciones
Route::get('/mis-direcciones', 'AddressController@index')->name('myAddresses');
//Agregar direccion
Route::post('/addAddress', 'AddressController@store')->name('address.store');
//Eliminar direccion
Route::delete('/removeAddress', 'AddressController@destroy')->name('address.destroy');
//Ver pedidos
Route::get('/mis-pedidos', 'OrderController@index')->name('myOrders');
//Ver pedido especifico
Route::get('/pedidos/{id}', 'OrderController@show')->name('order.show');
//Ver datos 
Route::get('/mis-datos', 'UserController@index')->name('myAccount');
//Editar usuarios
Route::post('/editData/{user}', 'UserController@update')->name('user.update');
//Ver restaurantes
Route::get('/restaurantes', 'ListController@index')->name('list');
//Perfil restaurante
Route::get('/{slug}', 'RestaurantController@show')->name('profile.show');

