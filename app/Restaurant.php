<?php

namespace App;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;

class restaurant extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function address(){
        return $this->hasOne('App\Address');
    }

    public function products(){
        return $this->hasMany('App\Product');
    }

    public function restaurantCategories(){
        return $this->belongsToMany(RestaurantCategory::class, 'relation_restaurant_category', 'restaurant_id', 'category_restaurant_id');
    }

}
