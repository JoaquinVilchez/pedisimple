<?php
use App\Restaurant;
use Carbon\Carbon;
use App\OpeningDateTime;

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

function normaliza($cadena){
    $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
    $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
    $cadena = utf8_decode($cadena);
    $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
    $cadena = strtolower($cadena);
    return utf8_encode($cadena);
}

function getDayName($day){
    // $day = DB::table('opening_date_times')->where('restaurant_id', $id);
    if(is_array($day)){
        $day=$day['weekday'];
    }else{
        $day=$day;
    }
    switch ($day) {
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
        case 7:
            return "Domingo";
            break;
    }  
}

function restaurantIsOpen(Restaurant $restaurant){
    $days = OpeningDateTime::where('restaurant_id', $restaurant->id)->get()->toArray();
    if(count($days)>0){
        $schedule = array(1,2,3,4,5,6,0);
        foreach ($days as $day) {               
                $replace_day = (array($day['weekday']-1=>$day));
                $schedule = array_replace_recursive($schedule, $replace_day);
        }  
        
        $today = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now());
        $weekday = $today->dayOfWeek;       
        $state = isOpen($days, $weekday, $today);
        if($state==null){
            $state=false;
        }

    }elseif($days==null){
        $schedule = null;
        $state=false;
    }

    return $state;
}


function isOpen($days, $weekday, $today){
    foreach ($days as $day) {
        if($day['weekday']==$weekday){
            if($day['start_hour_1']!=null){
                $start1 = Carbon::createFromTimeString($day['start_hour_1']);
                $end1 = Carbon::createFromTimeString($day['end_hour_1']);
            }else{
                $start1=null;
                $end1=null;
            }

            if($day['start_hour_2']!=null){
                $start2 = Carbon::createFromTimeString($day['start_hour_2']);
                $end2 = Carbon::createFromTimeString($day['end_hour_2'])->addDay();
            }else{
                $start2=null;
                $end2=null;
            }

            if($day['state']=='open'){  
                if($today->between($start1, $end1) || $today->between($start2, $end2)){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }
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

        return '¡Hola '.$first_name.'! Soy '.Auth::user()->first_name.' de '.$order->restaurant->name.'. Recibimos tu detalle de pedido desde '.config("app.name").'. ¿Querés confirmar el pedido?';
    }

    function gluberNumber(){
        return '3462642680';
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
            return $order->address->getAddress();  
        }
    }

?>