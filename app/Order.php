<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

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
            $address = $this->address->getAddress();
        }else{
            if($this->guest_floor==null && $this->guest_department==null){
                $address =  $this->guest_street.' '.$this->guest_number;
            }else{
                if($this->guest_floor==null && $this->guest_department!=null){
                    $address = $this->guest_street.' '.$this->guest_number.' - '.$this->guest_department;
                }else{
                    $address = $this->guest_street.' '.$this->guest_number.' - '.$this->guest_floor.$this->guest_department;
                }

                if($this->guest_building_name!=null){
                    $address = $address.' - Edificio '.$this->guest_building_name;
                }
            }
        }
        return $address;
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

    public function delayHours(){
        $now = Carbon::now();
        $order = Carbon::parse($this->created_at);
        $hours = $order->diffInHours($now);

        return $hours;
    }

    public function delayAlert(){
        $now = Carbon::now();
        $order = Carbon::parse($this->created_at);
        $hours = $order->diffInHours($now);
        $minutes = $order->diffInMinutes($now);

        if($hours>=24){
            return '<span class="badge badge-danger"><i class="far fa-clock"></i> Este pedido tiene más de un día de demora</span>';
        }elseif($hours>=12 && $hours<24){
            return '<span class="badge badge-danger"><i class="far fa-clock"></i> Este pedido tiene más de 12 horas de demora</span>';
        }else{
            if($minutes>=10 && $minutes<30){
                return '<span class="badge badge-warning"><i class="fas fa-exclamation-triangle"></i> Pedido realizado hace más de 10 minutos</span>';
            }elseif($minutes>=30 && $minutes<60){
                return '<span class="badge badge-warning"><i class="fas fa-exclamation-triangle"></i> Pedido realizado hace más de 30 minutos</span>';
            }elseif($minutes>=60 && $minutes<1440){
                return '<span class="badge badge-warning"><i class="fas fa-exclamation-triangle"></i> Pedido realizado hace más de una hora</span>';
            }
        }
    }

}
