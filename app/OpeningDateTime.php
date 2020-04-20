<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OpeningDateTime extends Model
{
    public function getDayName(){
        // $day = DB::table('opening_date_times')->where('restaurant_id', $id);        
        switch ($this->weekday) {
            case 1:
                return "Lunes";
                break;
            case 2:
                return "Martes";
                break;
            case 3:
                return "Miercoles";
                break;
            case 4:
                return "Jueves";
                break;
            case 5:
                return "Viernes";
                break;
            case 6:
                return "Sabado";
                break;
            case 7:
                return "Domingo";
                break;
        }  
    }
}
