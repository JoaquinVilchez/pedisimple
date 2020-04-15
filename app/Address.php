<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\City;
use App\Province;

class Address extends Model
{
    protected $guarded = [];
    
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
       if($this->floor==null || $this->department==null || $this->building_name==null){
            return $this->street.' '.$this->number;
       }else{
            return $this->street.' '.$this->number.' - '.$this->floor.$this->department.' - '.$this->building_name;
       }
    }

    public function getCity(){
        $city =  City::find($this->city_id);
        $province =  Province::find($city->province_id);
        return $city->name.', '.$province->name;
     }

    public function getFullAddress(){
        return $this->getAddress().' - '.$this->getCity();
     }
}
