<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use App\Exports\UsersExport;
use App\Order;
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

Route::get('/mantenimiento', function () {
    return view('maintenance');
})->name('app.maintenance');

Route::post('/notifications/load', function () {
    return Auth::user()->unreadNotifications()->where('type', 'App\Notifications\NewOrder')->count();
});

Route::get('registro/{token}', 'Auth\RegisterController@commerceRegister')->middleware('Invitation');

Route::get('/bienvenido', function () {
    return view('auth.welcome');
})->name('welcome')->middleware(['auth', 'verified']);

Route::get('/solicitud', function () {
    return view('request');
})->name('register.request');
Route::post('/solicitud', 'RestaurantController@request')->name('restaurant.request');

Route::get('/confirmado', function () {
    return view('confirmation');
})->name('confirmation');

Route::get('/comercios/check', 'RestaurantController@check')->name('restaurant.check');

Route::get('/checkout/descargar/{order}', 'CheckoutController@download')->name('checkout.download');
Route::resource('/checkout', 'CheckoutController')->names('checkout');

Route::post('/checkout-login', 'UserController@checkoutLogin')->name('user.checkoutlogin');
Route::resource('usuario/direcciones', 'AddressController')->names('address')->middleware(['auth', 'verified', 'Maintenance']);
Route::resource('usuario/datos', 'UserController')->names('user')->middleware(['auth', 'verified', 'Maintenance']);

Route::post('/carrito/addTax', 'CartController@deliveryTax')->name('cart.deliveryTax');
Route::post('/carrito/vaciar', 'CartController@empty')->name('cart.empty');
Route::post('/carrito/remove', 'CartController@remove')->name('cart.remove');
Route::resource('/carrito', 'CartController')->names('cart');

Route::post('administracion/ownerdata', 'UserController@ownerData')->name('restaurant.admin.ownerData')->middleware(['auth', 'verified', 'Admin']);
Route::post('invitaciones/reenviar', 'InvitationController@resend')->name('invitation.resend')->middleware(['auth', 'verified', 'Admin']);
Route::post('administracion/invitaciones/eliminar', 'InvitationController@delete')->name('invitation.delete')->middleware(['auth', 'verified', 'Admin']);
Route::resource('administracion/invitaciones', 'InvitationController')->names('invitation')->middleware(['auth', 'verified', 'Admin']);
Route::get('administracion/comercios', 'RestaurantController@list')->name('restaurant.admin.list')->middleware(['auth', 'verified', 'Admin']);
Route::post('administracion/updatestatus', 'RestaurantController@updateStatus')->name('restaurant.admin.updateStatus')->middleware(['auth', 'verified', 'Admin']);

//SUSCRIPCIONES/PLANES
Route::get('administracion/servicio/planes', 'PlanController@index')->name('plan.index');
Route::get('administracion/servicio/planes/nuevo', 'PlanController@create')->name('plan.create');
Route::post('administracion/servicio/planes/crear', 'PlanController@store')->name('plan.store');
Route::get('administracion/servicio/planes/editar/{id}', 'PlanController@edit')->name('plan.edit');
Route::put('administracion/servicio/planes/editar/{id}', 'PlanController@update')->name('plan.update');
Route::post('administracion/servicio/planes/eliminar', 'PlanController@destroy')->name('plan.destroy');
//FIN-SUSCRIPCIONES/PLANES

//SUSCRIPCIONES/COMERCIOS
Route::get('administracion/servicio/suscripciones', 'SubscriptionController@index')->name('subscription.index');
Route::get('administracion/servicio/suscripciones/editar/{id}', 'SubscriptionController@edit')->name('subscription.edit');
Route::put('administracion/servicio/suscripciones/editar/{id}', 'SubscriptionController@update')->name('subscription.update');
Route::post('administracion/servicio/suscripciones/store', 'SubscriptionController@store')->name('subscription.store');
Route::post('administracion/servicio/suscripciones/destroy', 'SubscriptionController@destroy')->name('subscription.destroy');
Route::post('administracion/servicio/suscripciones/renew', 'SubscriptionController@renew')->name('subscription.renew');
//FIN-SUSCRIPCIONES/COMERCIOS

//COMERCIOS

Route::resource('/', 'ListController')->names('home')->middleware('Maintenance');

Route::post('/configuracion/readnotification', 'RestaurantController@readNotification')->name('updatePrices.readNotification')->middleware(['verified', 'hasRestaurant']);
Route::post('/configuracion/addnotificationnumber', 'RestaurantController@addNotificationNumber')->name('restaurant.notificationnumber')->middleware(['verified', 'hasRestaurant']);
Route::get('/configuracion/informacion', 'RestaurantController@info')->name('restaurant.info')->middleware(['verified', 'hasRestaurant']);
Route::get('/configuracion/horarios', 'RestaurantController@openingTime')->name('restaurant.times')->middleware(['verified', 'hasRestaurant']);
Route::put('/configuracion/horarios', 'RestaurantController@openingTimeUpdate')->name('restaurant.times.update')->middleware(['verified', 'hasRestaurant']);
Route::resource('/configuracion', 'RestaurantController')->names('restaurant')->middleware(['verified', 'hasRestaurant']);
Route::get('/comercio/create', 'RestaurantController@create')->name('restaurant.create')->middleware(['verified', 'isMerchant']);
Route::post('/comercio/store', 'RestaurantController@store')->name('restaurant.store')->middleware(['verified']);
Route::get('/{comercio}', 'RestaurantController@show')->name('restaurant.show')->middleware(['Visible', 'Maintenance']);
Route::post('/comercio/eliminar', 'RestaurantController@destroy')->name('restaurant.destroy')->middleware(['verified']);
Route::post('/comercio/pausarpedidos', 'RestaurantController@pauseOrders')->name('restaurant.pauseOrders')->middleware(['verified', 'hasRestaurant']);

//DOCUMENTACION
Route::get('/docs/documentacion', function () {
    return view('restaurant.documentation');
})->name('help.documentation')->middleware(['verified', 'hasRestaurant']);
//TERMINOS Y CONDICIONES
Route::get('/docs/terminosycondiciones', function () {
    return view('restaurant.termsandconditions');
})->name('help.termsandconditions')->middleware(['verified']);

//PRODUCTOS
Route::post('/productos/showData', 'ProductController@showData')->name('product.showData');
Route::get('/productos/export-excel', 'ProductController@exportExcel')->name('product.export.excel')->middleware(['auth', 'verified', 'hasRestaurant']);
Route::post('/productos/import-excel', 'ProductController@importExcel')->name('product.import.excel')->middleware(['auth', 'verified', 'hasRestaurant']);
Route::post('/producto/{id}', 'ProductController@isAvailable')->name('product.available')->middleware(['auth', 'verified', 'hasRestaurant']);

Route::post('/variante/{id}', 'variantController@isAvailable')->name('variant.available')->middleware(['auth', 'verified', 'hasRestaurant']);
Route::post('/variant/ajaxcreate', 'VariantController@ajaxCreate')->name('variant.ajaxcreate');
Route::post('/getVariants', 'VariantController@getVariants')->name('variant.getVariants');
Route::post('/showItemVariants', 'VariantController@showItemVariants')->name('variant.showItemVariants');
Route::resource('/productos/variantes', 'VariantController')->names('variant')->middleware(['auth', 'verified', 'hasRestaurant']);
Route::post('/productos/variante/eliminar', 'VariantController@destroy')->name('variant.destroy')->middleware(['auth', 'verified', 'hasRestaurant']);

Route::get('/productos/actualizarprecios', 'ProductController@editprices')->name('product.editprices')->middleware(['auth', 'verified', 'hasRestaurant']);
Route::post('/productos/actualizarprecios', 'ProductController@updateprices')->name('product.updateprices')->middleware(['auth', 'verified', 'hasRestaurant']);
Route::get('/productos/temporales', 'ProductController@temporaries')->name('product.temporaries')->middleware(['auth', 'verified', 'hasRestaurant']);
Route::post('/productos/temporales/detener', 'ProductController@stopTemporaryProduct')->name('product.temporary.stop')->middleware(['auth', 'verified', 'hasRestaurant']);
Route::get('/productos/menu', 'ProductController@index')->name('product.index')->middleware(['auth', 'verified', 'hasRestaurant']);
Route::get('/productos/create', 'ProductController@create')->name('product.create')->middleware(['auth', 'verified', 'hasRestaurant']);
Route::post('/productos', 'ProductController@store')->name('product.store')->middleware(['auth', 'verified', 'hasRestaurant']);
Route::get('/productos/editar/{producto}', 'ProductController@edit')->name('product.edit')->middleware(['auth', 'verified', 'hasRestaurant']);
Route::put('/productos/editar/{producto}', 'ProductController@update')->name('product.update')->middleware(['auth', 'verified', 'hasRestaurant']);
Route::delete('/productos', 'ProductController@destroy')->name('product.destroy')->middleware(['auth', 'verified', 'hasRestaurant']);
Route::delete('/productos/delete-all', 'ProductController@destroyAll')->name('product.destroyAll')->middleware(['auth', 'verified', 'hasRestaurant']);

//CATEGORIAS
Route::get('/productos/categoria/export-excel', 'CategoryController@exportExcel')->name('category.export.excel')->middleware(['auth', 'verified', 'hasRestaurant']);
Route::post('/productos/categoria/import-excel', 'CategoryController@importExcel')->name('category.import.excel')->middleware(['auth', 'verified', 'hasRestaurant']);
Route::post('/productos/categoria/{id}', 'CategoryController@isAvailable')->name('category.available')->middleware(['auth', 'verified', 'hasRestaurant']);

Route::post('/productos/categorias/reorder', 'CategoryController@reorder')->name('category.reorder')->middleware(['auth', 'verified', 'hasRestaurant']);
Route::get('/productos/categorias', 'CategoryController@index')->name('category.index')->middleware(['auth', 'verified', 'hasRestaurant']);
Route::get('/productos/categorias/create', 'CategoryController@create')->name('category.create')->middleware(['auth', 'verified', 'hasRestaurant']);
Route::post('/productos/categorias', 'CategoryController@store')->name('category.store')->middleware(['auth', 'verified', 'hasRestaurant']);
Route::get('/productos/categorias/{categoria}', 'CategoryController@edit')->name('category.edit')->middleware(['auth', 'verified', 'hasRestaurant']);
Route::put('/productos/categorias/{categoria}', 'CategoryController@update')->name('category.update')->middleware(['auth', 'verified', 'hasRestaurant']);
Route::post('/productos/categorias/borrar', 'CategoryController@destroy')->name('category.destroy')->middleware(['auth', 'verified', 'hasRestaurant']);

//PEDIDOS
Route::post('/pedidos/closed-details', 'OrderController@getClosedDetails')->name('order.closedDetails')->middleware(['auth', 'verified']);
Route::get('/pedidos/nuevos', 'OrderController@new')->name('order.new')->middleware(['auth', 'verified', 'hasRestaurant']);
Route::get('/pedidos/aceptados', 'OrderController@accepted')->name('order.accepted')->middleware(['auth', 'verified', 'hasRestaurant']);
Route::get('/pedidos/cerrados', 'OrderController@closed')->name('order.closed')->middleware(['auth', 'verified', 'hasRestaurant']);
Route::post('/pedidos/aceptar', 'OrderController@accept')->name('order.accept')->middleware(['auth', 'verified', 'hasRestaurant']);
Route::post('/pedidos/rechazar', 'OrderController@reject')->name('order.reject')->middleware(['auth', 'verified', 'hasRestaurant']);
Route::post('/pedidos/cerrar', 'OrderController@close')->name('order.close')->middleware(['auth', 'verified', 'hasRestaurant']);
Route::post('/pedidos/cancelar', 'OrderController@cancel')->name('order.cancel')->middleware(['auth', 'verified', 'hasRestaurant']);
Route::post('/pedidos/update', 'OrderController@updateOrder')->name('order.updateOrder')->middleware(['auth', 'verified', 'hasRestaurant']);
Route::post('/pedidos/edit', 'OrderController@editOrder')->name('order.editOrder')->middleware(['auth', 'verified', 'hasRestaurant']);
Route::post('/pedidos/usuario/cancelar', 'OrderController@UserCancelOrder')->name('order.userCancel');
Route::get('/pedido/{code}', 'CheckoutController@show')->name('confirmed.order');
Route::resource('usuario/pedidos', 'OrderController')->names('order')->middleware(['auth', 'verified', 'Maintenance']);

Route::post('/mailsubscription/create', 'MailSubscriptionController@store')->name('mailsubscription.store');
