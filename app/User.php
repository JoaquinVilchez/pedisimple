<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function routeNotificationForWhatsApp()
    {
        return '+549'.$this->characteristic.$this->phone;
    }

    public function addresses(){
        return $this->hasMany(Address::class);
    }
    
    public function orders(){
        return $this->hasMany(Order::class);
    }
    
    public function restaurant(){
        return $this->hasOne(Restaurant::class);
    }

    public function fullName(){
        return $this->first_name.' '.$this->last_name;
    }

    public function getPhone(){
        return $this->characteristic.$this->phone;
    }

}
