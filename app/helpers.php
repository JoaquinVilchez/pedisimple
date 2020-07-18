<?php
use App\Restaurant;
use Carbon\Carbon;
use App\OpeningDateTime;
use App\Product;

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
        $phone = $order->guest_characteristic.'-'.$order->guest_phone;
    }

    return $phone;
}

function whatsappMessageCustomer($order){
    if($order->user_id!=null){
        $first_name = $order->user->first_name;
    }else{
        $first_name = $order->guest_first_name;
    }

    return '¡Hola '.$first_name.'! Soy '.Auth::user()->first_name.' de '.$order->restaurant->name.'. Confirmamos un pedido que hiciste desde '.config("app.name").'.';
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

?>