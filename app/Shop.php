<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function orders(){
        return $this->hasMany('App\Order');
    }

    public function address(){
        return $this->hasOne('App\Address');
    }

    public function products(){
        return $this->hasMany('App\Product');
    }
}
