<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RestaurantCategory extends Model
{
    public function restaurantCategories(){
        return $this->belongsToMany(Restaurant::class, 'relation_restaurant_category', 'category_restaurant_id', 'restaurant_id');
    }
}
