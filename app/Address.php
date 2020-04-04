<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function shop(){
        return $this->belongsTo('App\Shop');
    }

    public function city(){
        return $this->belongsTo('App\City');
    }
}
