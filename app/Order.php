<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }
    
    public function shop(){
        return $this->belongsTo('App\Shop');
    }

    public function products(){
        return $this->belongsToMany('App\Product'); 
    }

    public function payment(){
        return $this->hasOne('App\Payment');
    }
}
