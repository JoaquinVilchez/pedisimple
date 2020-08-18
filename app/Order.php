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

    public function getFullName(){
        if($this->user_id!=null){
            return $this->user->fullName();
        }else{
            return $this->guest_first_name.' '.$this->guest_last_name;
        }
    }

    public function getFullAddress(){
        if($this->address!=null){
            return $this->address->getAddress();
        }else{
            if($this->guest_floor==null || $this->guest_department==null){
                return $this->guest_street.' '.$this->guest_number;
           }else{
                $address = $this->guest_street.' '.$this->guest_number.' - '.$this->guest_floor.$this->guest_department;
                if($this->guest_building_name!=null){
                    $address = $address.' - Edificio '.$this->guest_building_name;
                }
                return $address;
           }
        }
    }

    public function getPhone(){
        if($this->user_id!=null){
            return $this->user->getPhone();
        }else{
            return $this->guest_characteristic.'-'.$this->guest_phone;
        }
    }

    public function getShippingMethod(){
        switch ($this->shipping_method) {
            case 'delivery':
                return 'Delivery';
                break;
            case 'pickup':
                return 'Retiro en local';
                break;
        }
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
            case 'cancelled':
                return 'badge badge-dark';
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
            case 'cancelled':
                return 'Cancelado';
                break;
        }
    }

}
