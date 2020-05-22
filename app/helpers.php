<?php
use App\Restaurant;
use Carbon\Carbon;

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

?>