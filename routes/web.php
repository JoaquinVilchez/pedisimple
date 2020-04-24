<?php

use Illuminate\Support\Facades\Route;
use App\Exports\UsersExport;
use App\User;

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

Auth::routes(['verify' => true]);

Route::get('/',function(){
    return view('home');
})->name('home');

Route::get('/comercios/solicitud', function(){
    return view('request');
})->name('register.request');

// Route::get('/gracias', function(){
//     return view('thankyou');
// })->name('thankyou')->name('thankyou');

// Route::get('/confirmado', function(){
//     return view('confirmation');
// })->name('confirmation')->name('confirmation');

Route::post('/carrito/addTax', 'CartController@deliveryTax')->name('cart.deliveryTax');
Route::get('/carrito/vaciar', 'CartController@empty')->name('cart.empty');
Route::resource('/carrito', 'CartController')->names('cart');

// Route::resource('/checkout', 'CheckoutController')->names('checkout');

// Route::resource('/direcciones', 'AddressController')->names('address');

// Route::resource('/pedidos', 'OrderController')->names('order');

Route::resource('/datos', 'UserController')->names('user')->middleware(['verified']);;

Route::resource('/comercios', 'ListController')->names('list');

Route::post('/comercios/solicitud', 'RestaurantController@request')->name('restaurant.request');
Route::get('/comercio/informacion', 'RestaurantController@info')->name('restaurant.info')->middleware(['verified', 'hasRestaurant']);
Route::get('/comercio/horarios', 'RestaurantController@openingTime')->name('restaurant.times')->middleware(['verified', 'hasRestaurant']);
Route::resource('/comercio', 'RestaurantController')->names('restaurant')->middleware(['verified', 'hasRestaurant']);
Route::get('/comercio/create', 'RestaurantController@create')->name('restaurant.create')->middleware(['verified']);
Route::post('/comercio', 'RestaurantController@store')->name('restaurant.store')->middleware(['verified']);
Route::get('/comercio/{comercio}', 'RestaurantController@show')->name('restaurant.show')->middleware('Visible');


//PRODUCTOS
Route::get('/producto/export-excel', 'ProductController@exportExcel')->name('product.export.excel')->middleware('verified');
Route::post('/producto/import-excel', 'ProductController@importExcel')->name('product.import.excel')->middleware('verified');
Route::post('/producto/{id}', 'ProductController@isAvailable')->name('product.available')->middleware('verified');

Route::get('/productos', 'ProductController@index')->name('product.index')->middleware('verified');
Route::get('/productos/create', 'ProductController@create')->name('product.create')->middleware('verified');
Route::post('/productos', 'ProductController@store')->name('product.store')->middleware('verified');
Route::get('/productos/{producto}', 'ProductController@edit')->name('product.edit')->middleware('verified');
Route::put('/productos/{producto}', 'ProductController@update')->name('product.update')->middleware('verified');
Route::delete('/productos', 'ProductController@destroy')->name('product.destroy')->middleware('verified');

//CATEGORIAS
Route::get('/categoria/export-excel', 'CategoryController@exportExcel')->name('category.export.excel')->middleware('verified');
Route::post('/categoria/import-excel', 'CategoryController@importExcel')->name('category.import.excel')->middleware('verified');
Route::post('/categoria/{id}', 'CategoryController@isAvailable')->name('category.available')->middleware('verified');

Route::get('/categorias', 'CategoryController@index')->name('category.index')->middleware('verified');
Route::get('/categorias/create', 'CategoryController@create')->name('category.create')->middleware('verified');
Route::post('/categorias', 'CategoryController@store')->name('category.store')->middleware('verified');
Route::get('/categorias/{categoria}', 'CategoryController@edit')->name('category.edit')->middleware('verified');
Route::put('/categorias/{categoria}', 'CategoryController@update')->name('category.update')->middleware('verified');
Route::delete('/categorias', 'CategoryController@destroy')->name('category.destroy')->middleware('verified');

// Route::resource('/categorias', 'CategoryController')->names('category')->middleware('verified');



// Route::get('/download', function(){
//     return Excel::download(new UsersExport, 'users.xlsx');
// });
