<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function restaurant(){
        return $this->belongsTo(Restaurant::class);
    }

    public function products(){
        return $this->hasMany(Product::class); 
    }

    public function payment(){
        return $this->hasOne('App\Payment');
    }

    // public function lineitems(){
    //     return $this->hasMany(LineItem::class);
    // }

    public function stateStyle(){
        switch ($this->state) {
            case 'pendiente':
                return 'badge badge-danger';
                break;
            case 'confirmado':
                return 'badge badge-warning';
                break;
            case 'entregado':
                return 'badge badge-success';
                break;
            case 'cancelado':
                return 'badge badge-secondary';
                break;
        }
    }
}
