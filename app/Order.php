<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Order extends Model
{
    use Notifiable;
    
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

    public function lineitems(){
        return $this->hasMany(LineItem::class);
    }

    public function address(){
        return $this->belongsTo(Address::class);
    }

    public function stateStyle(){
        switch ($this->state) {
            case 'pending':
                return 'badge badge-dark';
                break;
            case 'accepted':
                return 'badge badge-warning';
                break;
            case 'closed':
                return 'badge badge-success';
                break;
            case 'rejected':
                return 'badge badge-danger';
                break;
        }
    }

    public function stateLang(){
        switch ($this->state) {
            case 'pending':
                return 'Pendiente';
                break;
            case 'accepted':
                return 'Aceptado';
                break;
            case 'closed':
                return 'Finalizado';
                break;
            case 'rejected':
                return 'Rechazado';
                break;
        }
    }

}
