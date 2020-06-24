<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Product extends Model
{
    protected $guarded = [];

    public function restaurant(){
        return $this->belongsTo(Restaurant::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function orders(){
        return $this->belongsToMany(Order::class);
    }

    // public function lineItem(){
    //     return $this->belongsTo(LineItem::class);
    // }

    public function stateStyle(){
        switch ($this->state) {
            case 'not-available':
                return 'badge badge-danger';
                break;
            case 'available':
                return 'badge badge-success';
                break;
       }
    }

    public function translateState(){
        switch ($this->state) {
            case 'not-available':
                return 'No disponible';
                break;
            case 'available':
                return 'Disponible';
                break;
       }
    }

    public function getTemporaryDate(){
        $now = Carbon::now();
        $start_date = Carbon::parse($this->start_date);
        $end_date = Carbon::parse($this->end_date);

        if($now>$end_date){
            return 'Finalizado.';
        }elseif($now<$start_date){
            if($now->diffInDays($start_date, false)>1){
                return 'Programado - Comienza en: '.$now->diffInDays($start_date, false).' días.';
            }else{
                return 'Programado - Comienza mañana.';
            }
        }elseif($now>=$start_date){
            if($now->diffInDays($end_date, false)>1){
                return 'Activo - Termina en: '.$now->diffInDays($end_date, false).' días.';
            }else{
                return 'Activo - Termina hoy.';
            }
        }
    }

    public function isTemporaryActive(){
        $now = Carbon::now();
        $start_date = Carbon::parse($this->start_date);
        $end_date = Carbon::parse($this->end_date);

        if($now>=$start_date and $now<$end_date){
            return true;
        }else{
            return false;
        }
    }

    public function getRemainingDays(){
        $now = Carbon::now();
        $start_date = Carbon::parse($this->start_date);
        $end_date = Carbon::parse($this->end_date);

        if($now>=$start_date){
            if($now->diffInDays($end_date, false)>1){
                return 'Termina en: '.$now->diffInDays($end_date, false).' días.';
            }else{
                return 'Termina hoy.';
            }
        }
    }
}