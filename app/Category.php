<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;

class Category extends Model
{
    public function products(){
        return $this->hasMany('App\Product');
    }

    public function getProducts(){
        return Product::where('category_id', $this->id)->where('state', 'activo')->get();
    }
}
