<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    protected $guarded = [];

    public function restaurant(){
        return $this->belongsTo(Restaurant::class);
    }

    public function products(){
        return $this->belongsToMany(Product::class, 'products_variants');
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

    public function translateState(){
        switch ($this->state) {
            case 'not-available':
                return 'No disponible';
                break;
            case 'available':
                return 'Disponible';
                break;
       }
    }
}
