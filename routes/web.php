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

Route::resource('/datos', 'UserController')->names('user');

Route::resource('/comercios', 'ListController')->names('list');

Route::get('/comercio/informacion', 'RestaurantController@info')->name('restaurant.info')->middleware(['verified', 'hasRestaurant']);
Route::get('/comercio/horarios', 'RestaurantController@openingTime')->name('restaurant.times')->middleware(['verified', 'hasRestaurant']);
Route::resource('/comercio', 'RestaurantController')->names('restaurant')->middleware(['verified', 'hasRestaurant']);
Route::get('/comercio/create', 'RestaurantController@create')->name('restaurant.create')->middleware(['verified']);
Route::post('/comercio', 'RestaurantController@store')->name('restaurant.store')->middleware(['verified']);
Route::get('/comercio/{comercio}', 'RestaurantController@show')->name('restaurant.show');

Route::post('/producto/{id}', 'ProductController@isAvailable')->name('product.available')->middleware('verified');
Route::resource('/productos', 'ProductController')->names('product')->middleware('verified');

Route::post('/categoria/{id}', 'CategoryController@isAvailable')->name('category.available')->middleware('verified');
Route::resource('/categorias', 'CategoryController')->names('category')->middleware('verified');


// Route::get('/download', function(){
//     return Excel::download(new UsersExport, 'users.xlsx');
// });
