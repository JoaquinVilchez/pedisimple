<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function restaurant(){
        return $this->belongsTo(Restaurant::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function orders(){
        return $this->belongsToMany(Order::class);
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