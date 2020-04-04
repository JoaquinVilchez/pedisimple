<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function shop(){
        return $this->belongsTo('App\Shop');
    }

    public function category(){
        return $this->belongsTo('App\Category');
    }

    public function orders(){
        return $this->belongsToMany('App\Order');
    }
}
