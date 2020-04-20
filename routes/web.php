<?php

use Illuminate\Support\Facades\Route;
use App\Exports\UsersExport;

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

Route::get('/comercio/informacion', 'RestaurantController@info')->name('restaurant.info');
Route::get('/comercio/horarios', 'RestaurantController@openingTime')->name('restaurant.times');
Route::resource('/comercio', 'RestaurantController')->names('restaurant');

Route::post('/producto/{id}', 'ProductController@isAvailable')->name('product.available');
Route::resource('/productos', 'ProductController')->names('product');

Route::post('/categoria/{id}', 'CategoryController@isAvailable')->name('category.available');
Route::resource('/categorias', 'CategoryController')->names('category');

// Route::get('/download', function(){
//     return Excel::download(new UsersExport, 'users.xlsx');
// });
