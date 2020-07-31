<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
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

Route::get('registro/{token}', 'Auth\RegisterController@commerceRegister')->middleware('Invitation');

Route::get('/', 'RestaurantController@index')->name('home');

Route::get('/bienvenido',function(){
    return view('auth.welcome');
})->name('welcome')->middleware(['auth','verified']);

Route::get('/solicitud', function(){
    return view('request');
})->name('register.request');
Route::post('/solicitud', 'RestaurantController@request')->name('restaurant.request');

Route::get('/confirmado', function(){
    return view('confirmation');
})->name('confirmation');

Route::get('/comercios/check', 'RestaurantController@check')->name('restaurant.check');

Route::get('/checkout/descargar/{order}', 'CheckoutController@download')->name('checkout.download');
Route::resource('/checkout', 'CheckoutController')->names('checkout');

Route::resource('usuario/direcciones', 'AddressController')->names('address');
Route::resource('usuario/datos', 'UserController')->names('user')->middleware(['auth', 'verified']);

Route::post('/carrito/addTax', 'CartController@deliveryTax')->name('cart.deliveryTax');
Route::get('/carrito/vaciar', 'CartController@empty')->name('cart.empty');
Route::resource('/carrito', 'CartController')->names('cart');

Route::post('/usuario/invitaciones/reenviar', 'InvitationController@resend')->name('invitation.resend')->middleware(['auth','verified', 'Admin']);
Route::resource('/usuario/invitaciones', 'InvitationController')->names('invitation')->middleware(['auth','verified', 'Admin']);
Route::get('/usuario/administracion/comercios', 'RestaurantController@list')->name('restaurant.admin.list')->middleware(['auth','verified', 'Admin']);
Route::post('/usuario/administracion/comercios', 'RestaurantController@updateStatus')->name('restaurant.admin.updateStatus')->middleware(['auth','verified', 'Admin']);

Route::resource('/comercios', 'ListController')->names('list');

Route::get('/configuracion/informacion', 'RestaurantController@info')->name('restaurant.info')->middleware(['verified', 'hasRestaurant']);
Route::get('/configuracion/horarios', 'RestaurantController@openingTime')->name('restaurant.times')->middleware(['verified', 'hasRestaurant']);
Route::put('/configuracion/horarios', 'RestaurantController@openingTimeUpdate')->name('restaurant.times.update')->middleware(['verified', 'hasRestaurant']);
Route::resource('/configuracion', 'RestaurantController')->names('restaurant')->middleware(['verified', 'hasRestaurant']);
Route::get('/comercio/create', 'RestaurantController@create')->name('restaurant.create')->middleware(['verified']);
Route::post('/comercio/store', 'RestaurantController@store')->name('restaurant.store')->middleware(['verified']);
Route::get('/{comercio}', 'RestaurantController@show')->name('restaurant.show')->middleware('Visible');

//PRODUCTOS
Route::post('/productos/showData', 'ProductController@showData')->name('product.showData');
Route::get('/productos/export-excel', 'ProductController@exportExcel')->name('product.export.excel')->middleware(['auth','verified', 'hasRestaurant']);
Route::post('/productos/import-excel', 'ProductController@importExcel')->name('product.import.excel')->middleware(['auth','verified', 'hasRestaurant']);
Route::post('/productos/{id}', 'ProductController@isAvailable')->name('product.available')->middleware(['auth','verified', 'hasRestaurant']);

Route::post('/variant/ajaxcreate', 'VariantController@ajaxCreate')->name('variant.ajaxcreate');
Route::post('/getVariants', 'VariantController@getVariants')->name('variant.getVariants');
Route::post('/showItemVariants', 'VariantController@showItemVariants')->name('variant.showItemVariants');
Route::resource('/productos/variantes', 'VariantController')->names('variant')->middleware(['auth','verified', 'hasRestaurant']);
Route::post('/productos/variante/eliminar', 'VariantController@destroy')->name('variant.destroy')->middleware(['auth','verified', 'hasRestaurant']);

Route::get('/productos/temporales', 'ProductController@temporaries')->name('product.temporaries')->middleware(['auth','verified', 'hasRestaurant']);
Route::get('/productos/menu', 'ProductController@index')->name('product.index')->middleware(['auth','verified', 'hasRestaurant']);
Route::get('/productos/create', 'ProductController@create')->name('product.create')->middleware(['auth','verified', 'hasRestaurant']);
Route::post('/productos', 'ProductController@store')->name('product.store')->middleware(['auth','verified', 'hasRestaurant']);
Route::get('/productos/editar/{producto}', 'ProductController@edit')->name('product.edit')->middleware(['auth','verified', 'hasRestaurant']);
Route::put('/productos/editar/{producto}', 'ProductController@update')->name('product.update')->middleware(['auth','verified', 'hasRestaurant']);
Route::delete('/productos', 'ProductController@destroy')->name('product.destroy')->middleware(['auth','verified', 'hasRestaurant']);
Route::delete('/productos/delete-all', 'ProductController@destroyAll')->name('product.destroyAll')->middleware(['auth','verified', 'hasRestaurant']);

//CATEGORIAS
Route::get('/productos/categoria/export-excel', 'CategoryController@exportExcel')->name('category.export.excel')->middleware(['auth','verified', 'hasRestaurant']);
Route::post('/productos/categoria/import-excel', 'CategoryController@importExcel')->name('category.import.excel')->middleware(['auth','verified', 'hasRestaurant']);
Route::post('/productos/categoria/{id}', 'CategoryController@isAvailable')->name('category.available')->middleware(['auth','verified', 'hasRestaurant']);

Route::get('/productos/categorias', 'CategoryController@index')->name('category.index')->middleware(['auth','verified', 'hasRestaurant']);
Route::get('/productos/categorias/create', 'CategoryController@create')->name('category.create')->middleware(['auth','verified', 'hasRestaurant']);
Route::post('/productos/categorias', 'CategoryController@store')->name('category.store')->middleware(['auth','verified', 'hasRestaurant']);
Route::get('/productos/categorias/{categoria}', 'CategoryController@edit')->name('category.edit')->middleware(['auth','verified', 'hasRestaurant']);
Route::put('/productos/categorias/{categoria}', 'CategoryController@update')->name('category.update')->middleware(['auth','verified', 'hasRestaurant']);
Route::post('/productos/categorias/borrar', 'CategoryController@destroy')->name('category.destroy')->middleware(['auth','verified', 'hasRestaurant']);

//PEDIDOS
Route::post('/pedidos/closed-details', 'OrderController@getClosedDetails')->name('order.closedDetails');
Route::get('/pedidos/nuevos', 'OrderController@new')->name('order.new');
Route::get('/pedidos/aceptados', 'OrderController@accepted')->name('order.accepted');
Route::get('/pedidos/cerrados', 'OrderController@closed')->name('order.closed');
Route::post('/pedidos/aceptar', 'OrderController@accept')->name('order.accept');
Route::post('/pedidos/rechazar', 'OrderController@reject')->name('order.reject');
Route::post('/pedidos/cerrar', 'OrderController@close')->name('order.close');
Route::post('/pedidos/cancelar', 'OrderController@cancel')->name('order.cancel');
Route::get('/pedido/{code}', 'CheckoutController@show')->name('confirmed.order');
Route::resource('usuario/pedidos', 'OrderController')->names('order');