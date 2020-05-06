<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RestaurantCategory extends Model
{
    public function restaurants(){
        return $this->belongsToMany(Restaurant::class, 'relation_restaurant_category', 'category_restaurant_id', 'restaurant_id');
    }
}
