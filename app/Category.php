<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;

class Category extends Model
{
    protected $guarded = [];

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function getProducts(){
        return Product::where('category_id', $this->id)->where('state', 'available')->get();
    }
    
    public function stateStyle(){
        switch ($this->state) {
            case 'not-available':
                return 'badge badge-danger';
                break;
            case 'available':
                return 'badge badge-success';
                break;
        }
    }

}

