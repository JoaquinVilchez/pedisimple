<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\City;
use App\Province;

class Address extends Model
{
    protected $guarded = [];
    
    public function order(){
        return $this->hasMany(Order::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function restaurant(){
        return $this->belongsTo(Restaurant::class);
    }

    public function city(){
        return $this->belongsTo(City::class);
    }

    public function getAddress(){
       if($this->floor==null || $this->department==null){
            return $this->street.' '.$this->number;
       }else{
            $address = $this->street.' '.$this->number.' - '.$this->floor.$this->department;
            if($this->building_name!=null){
                $address = $address.' - Edificio '.$this->building_name;
            }
            return $address;
       }
    }

    public function getCity(){
        $city =  City::find($this->city_id);
        $province =  Province::find($city->province_id);
        return $city->name.', '.$province->name;
     }

    public function getFullAddress(){
        return $this->getAddress();
     }
}
