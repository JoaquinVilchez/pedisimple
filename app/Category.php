<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;

class Category extends Model
{
    public function products(){
        return $this->hasMany(Product::class);
    }

    public function getProducts(){
        return Product::where('category_id', $this->id)->where('state', 'activo')->get();
    }
}
