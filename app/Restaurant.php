<?php

namespace App;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;

class restaurant extends Model
{
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function address(){
        return $this->hasOne(Address::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function categories(){
        return $this->hasMany(Category::class);
    }

    public function restaurantCategories(){
        return $this->belongsToMany(RestaurantCategory::class, 'relation_restaurant_category', 'restaurant_id', 'category_restaurant_id');
    }

    public function shippingMethod(){
        switch ($this->shipping_method) {
            case 'pickup':
                return 'Retiro en local';
                break;
            case 'delivery':
                return 'Delivery';
                break;
            case 'delivery-pickup':
                return 'Retiro y Delivery';
                break;
       }
    }

}
