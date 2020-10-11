<?php
use App\Restaurant;
use Carbon\Carbon;
use App\OpeningDateTime;
use App\Product;
use App\Variant;

function formatPrice($price){
    return number_format($price, 0, ',', '');
}

function cartRestaurant(){
    $firstItem = \Cart::getContent()->first();
    $restaurant = $firstItem->associatedModel->restaurant->id;

    return $restaurant;
}

function generateCode()  {
    $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $digits = '1234567890';
    $randomString = '';
    for ($i = 0; $i < 3; $i++) {
        $randomString .= $letters[rand(0, strlen($letters) - 1)];
    }
    for ($i = 0; $i < 3; $i++) {
        $randomString .= $digits[rand(0, strlen($digits) - 1)];
    }
    return $randomString;
}

function generateNumberCode()  {
    $digits = '1234567890';
    $randomString = '';
    for ($i = 0; $i < 3; $i++) {
        $randomString .= $digits[rand(0, strlen($digits) - 1)];
    }
    return $randomString;
}

function normaliza($cadena){
    $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
    $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
    $cadena = utf8_decode($cadena);
    $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
    $cadena = strtolower($cadena);
    return utf8_encode($cadena);
}

function getDayName($day){
    if(is_array($day)){
        $day=$day['weekday'];
    }else{
        $day=$day;
    }
    switch ($day) {
        case 0:
            return "Domingo";
            break;
        case 1:
            return "Lunes";
            break;
        case 2:
            return "Martes";
            break;
        case 3:
            return "Miércoles";
            break;
        case 4:
            return "Jueves";
            break;
        case 5:
            return "Viernes";
            break;
        case 6:
            return "Sábado";
            break;
    }
}
function getGuestAddress($order){
    if($order->guest_floor==null || $order->guest_department==null){
            return $order->guest_street.' '.$order->guest_number;
    }else{
            return $order->guest_street.' '.$order->guest_number.' - '.$order->guest_floor.$order->guest_department;
    }
}

function whatsappNumberCustomer($order){
    if($order->user_id!=null){
        $phone = $order->user->getPhone();
    }else{
        $phone = $order->guest_characteristic.$order->guest_phone;
    }

    return $phone;
}

function whatsappMessageCustomer($order){
if($order->user_id!=null){
    $first_name = $order->user->first_name;
}else{
    $first_name = $order->guest_first_name;
}

$list = '';
foreach($order->lineItems as $item){
if($item->variants==null){
$list .= "
_- (".$item->quantity.") ".$item->product->name." [$".formatPrice($item->price*$item->quantity)."]_";
}else{
$list .= "
_- (".$item->quantity.") ".$item->product->name." (".implode(', ', $item->showVariants()).") [$".formatPrice($item->price*$item->quantity)."]_";
}
}

if($order->shipping_method=='delivery'){
$delivery = "
Envío: *$".formatPrice($order->delivery)."* _(El precio puede variar en base a la distancia)_";
}else{
$delivery = '';
}

return
"¡Hola ".$first_name."! Soy ".Auth::user()->first_name." de ".$order->restaurant->name.". Confirmamos tu pedido que hiciste en *".config("app.name")."*.

Código: *".$order->code."*
Detalle del pedido: "
.$list."

Subtotal: *$".formatPrice($order->subtotal)."*".$delivery."

Total: *$".formatPrice($order->total)."*

Nos mantendremos en contacto contigo para coordinar la entrega del pedido.

¡Muchas gracias por hacer tu pedido!

________________________________
_www.pedisimple.com_
_Venado Tuerto, Santa Fe_"
;
}

function whatsappUpdateOrder($order){
if($order->user_id!=null){
    $first_name = $order->user->first_name;
}else{
    $first_name = $order->guest_first_name;
}

$list = '';
foreach($order->lineItems as $item){
if($item->variants==null){
$list .= "
_- (".$item->quantity.") ".$item->product->name." [$".formatPrice($item->price*$item->quantity)."]_";
}else{
$list .= "
_- (".$item->quantity.") ".$item->product->name." (".implode(', ', $item->showVariants()).") [$".formatPrice($item->price*$item->quantity)."]_";
}
}

if($order->shipping_method=='delivery'){
$delivery = "
Envío: *$".formatPrice($order->delivery)."* _(El precio puede variar en base a la distancia)_";
}else{
$delivery = '';
}

return
"*Pedido modificado:*

Detalle del pedido: "
.$list."

Subtotal: *$".formatPrice($order->subtotal)."*".$delivery."

Total: *$".formatPrice($order->total)."*
________________________________
_www.pedisimple.com_
_Venado Tuerto, Santa Fe_"
;
}


function whatsappRejectOrderMessage($order){
    if($order->user_id!=null){
        $first_name = $order->user->first_name;
    }else{
        $first_name = $order->guest_first_name;
    }

    return '¡Hola '.$first_name.'! Soy '.Auth::user()->first_name.' de '.$order->restaurant->name.'. Lamentamos informarte que no podemos tomar tu pedido en este momento. ';
}

function whatsappCancelOrderMessage($order){
    if($order->user_id!=null){
        $first_name = $order->user->first_name;
    }else{
        $first_name = $order->guest_first_name;
    }

    return '¡Hola '.$first_name.'! Soy '.Auth::user()->first_name.' de '.$order->restaurant->name.'. Te informamos que hemos cancelado tu pedido. ';
}

function gluberMessage($order){
    if($order->user_id!=null){
        $first_name = $order->user->first_name;
    }else{
        $first_name = $order->guest_first_name;
    }

    return 'Hola, soy '.Auth::user()->first_name.' de '.$order->restaurant->name.' (_'.$order->restaurant->address->getAddress().'_) Me comunico desde '.config("app.name").'. '.'Tengo que hacer una entrega a *'.getOrderAddress($order).'* con el codigo *'.$order->code.'*. ¿Hay disponibilidad?';
}

function getOrderAddress($order){
    if ($order->user_id !=null) {
        if ($order->address_id==null){
            return getGuestAddress($order);
        }else{
            return $order->address->getAddress();
        }
    }else{
        return getGuestAddress($order);
    }
}

function getVariantsName($data){
    implode(', ', $item->showVariants());
}

function gluberStatus(){
    if(env('GLUBER_STATUS')=='YES'){
        return true;
    }else{
        return false;
    }
}

function showVariantsName($data){

    $variants = [];
        foreach($data as $id) {
            $variant = Variant::find(intval($id));
            array_push($variants,$variant->name);
        }
    return implode(', ', $variants);
}
?>