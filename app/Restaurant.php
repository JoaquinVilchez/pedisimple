<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class restaurant extends Model
{
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function address(){
        return $this->hasOne(Address::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function categories(){
        return $this->hasMany(Category::class);
    }

    public function restaurantCategories(){
        return $this->belongsToMany(RestaurantCategory::class, 'relation_restaurant_category', 'restaurant_id', 'category_restaurant_id');
    }

    public function shippingMethod(){
        switch ($this->shipping_method) {
            case 'pickup':
                return 'Retiro en local';
                break;
            case 'delivery':
                return 'Delivery';
                break;
            case 'delivery-pickup':
                return 'Retiro y Delivery';
                break;
       }
    }

    public function stateStyle(){
        switch ($this->state) {
            case 'cancelled':
                return 'badge badge-danger';
                break;
            case 'active':
                return 'badge badge-success';
                break;
            case 'pending':
                return 'badge badge-warning';
                break;
       }
    }

    public function translateState(){
        switch ($this->state) {
            case 'pending':
                return 'Pendiente';
                break;
            case 'active':
                return 'Activo';
                break;
            case 'cancelled':
                return 'Cancelado';
                break;
       }
    }

    public function getPhone(){
        if($this->second_characteristic == null && $this->second_phone == null){
            return $this->characteristic.'-'.$this->phone;
        }else{
            return $this->characteristic.'-'.$this->phone.' | '.$this->second_characteristic.'-'.$this->second_phone; 
        }
    }

    function getSchedule(){
        $days = OpeningDateTime::where('restaurant_id', $this->id)->get()->toArray();
        if(count($days)>0){
            $schedule = array(0,1,2,3,4,5,6);
            foreach ($days as $day) {               
                    $replace_day = (array($day['weekday']=>$day));
                    $schedule = array_replace_recursive($schedule, $replace_day);
            }  
            
        }elseif($days==null){
            $schedule = null;
        }
        
        return $schedule;
    }

    function isOpen(){

        $today = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now());
        $weekday = $today->dayOfWeek;   
        $schedule = $this->getSchedule();

        for ($i=0; $i < 7; $i++) { 
            
                if($schedule[$i]['weekday']==$weekday){
                    if($schedule[$i]['start_hour_1']!=null){
                        $start1 = Carbon::createFromTimeString($schedule[$i]['start_hour_1']);
                        $end1 = Carbon::createFromTimeString($schedule[$i]['end_hour_1']);
                    }else{
                        $start1=null;
                        $end1=null;
                    }
        
                    if($schedule[$i]['start_hour_2']!=null){
                        $start2 = Carbon::createFromTimeString($schedule[$i]['start_hour_2']);
                        $end2 = Carbon::createFromTimeString($schedule[$i]['end_hour_2'])->addDay();
                    }else{
                        $start2=null;
                        $end2=null;
                    }
        
                    if($schedule[$i]['state']=='open'){  
                        if($today->between($start1, $end1) || $today->between($start2, $end2)){
                            return true;
                        }else{
                            return false;
                        }
                    }else{
                        return false;
                    }
                }
        }
    }

}
